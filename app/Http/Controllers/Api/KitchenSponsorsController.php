<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\KitchenDurationResource;
use App\Http\Resources\MiniUserResource;
use App\Http\Resources\SponsorDurationResource;
use App\Http\Resources\SponsorPlanResource;
use App\Models\Kitchen;
use App\Models\KitchenDuration;
use App\Models\Order;
use App\Models\SponsorDurations;
use App\Models\User;
use App\Models\Wallet;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Contracts\TransactionTypes;
use App\Support\Payment\Facades\Cashier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KitchenSponsor;
use App\Http\Controllers\Controller;
use App\Http\Resources\KitchenResource;
use App\Http\Requests\Api\CreateKitchenSponsor;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Schema\ValidationException;

class KitchenSponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function indexKitchenDurations()
    {
        $kitchen = auth()->user()->kitchen()->first();
        if(! $kitchen) return response()->json(['message' => 'kitchen.messages.not-found'],404);
        $kitchen_durations = KitchenDuration::where('kitchen_id',$kitchen->id)->get();
        return KitchenDurationResource::collection($kitchen_durations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CreateKitchenSponsor  $request
     * @return \Illuminate\Http\Response
     * @return \App\Http\Resources\KitchenResource
     */
    public function store(CreateKitchenSponsor $request) :object
    {
        

        $kitchen = auth()->user()->kitchen;
        if ($kitchen->sponsor()->whereNull('start_date')->exists()) throw \Illuminate\Validation\ValidationException::withMessages(["message" => "لديك طلب تمديد معلق."]);
        $kitchenSponsor = $kitchen->sponsor()->create($request->validated());
        if($request->payment_method == KitchenSponsor::WALLET_PAYMENT) $this->walletPayment($kitchen, $request , $kitchenSponsor);
        $cost = $kitchenSponsor->sponsor_duration->cost;
        $kitchen_duration = KitchenDuration::create([
            'kitchen_id' => $kitchen->id,
            'cost' => $cost,
            'status' => KitchenSponsor::PENDING_STATUS
        ]);
        $kitchenSponsor->update(['kitchen_duration_id' => $kitchen_duration->id]);
        if ($request->hasFile('avatar')) {
            $kitchenSponsor->addMediaFromRequest('avatar')
                ->usingFileName(time().'.png')
                ->toMediaCollection();
        }
        return new KitchenResource($kitchen->refresh());
    }

    public function onlinePayment(Request $request)
    {
        return 12;
        $request->validate([
            'checkout_id' => 'required|exists:checkouts,checkout_id',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = User::find(1);

        Cashier::setActor($user)->setCheckout($request->checkout_id);
        $checkout = Cashier::updateStatus()->getCheckout();

        if ($checkout->transactions()->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'checkout' => [__('The given checkout_id already used.')],
                'status' => trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        $status = TransactionStatuses::PENDING_STATUS;

        if ($checkout->isPending()) {
            $status = TransactionStatuses::PENDING_STATUS;
        }
        if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
            $status = TransactionStatuses::SPONSOR_STATUS;
        }
        if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
            $status = TransactionStatuses::REJECTED_STATUS;
        }

        if (! $checkout->isSuccessful() && ! $checkout->isSuccessfulAndPending()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'balance' => 'Error: '. trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

         $user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => $checkout->amount,
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => Wallet::TRANSFER_STATUS,
        ]);
        KitchenSponsor::where('checkout_id', $request->checkout_id)->update([
            'paid' => 1
        ]);
        return response()->json([
            'message' => 'done'
        ]);

        //DB::commit();

        //event(new WalletRechargeEvent($transaction));

    }
    public function walletPayment($kitchen , $request,$kitchenSponsor )
    {
        $wallet = new Wallet() ;
        $wallet_balance = auth()->user()->wallet()->Balance();
        $sponsorCost = SponsorDurations::find($request->sponsor_duration_id)->cost;
        if($wallet_balance < $sponsorCost) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.can_withdrew")]);
        $transaction = $wallet->transferMoney(auth()->user(),User::find(1),$sponsorCost);
        if (! $transaction) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.transaction-error")]);
        $kitchenSponsor->update([
            'paid' => 1
        ]);
    }
    public function accept(KitchenSponsor $kitchenSponsor)
    {

    }
    public function extend(CreateKitchenSponsor $request)
    {
        $user = auth()->user();
        $kitchen = auth()->user()->kitchen;
        $sponsor_duration = SponsorDurations::find($request->sponsor_duration_id);

        $kitchen_sponsors = KitchenSponsor::where('kitchen_id',$kitchen->id)->where('paid',1)->whereNotNull('end_date')->whereDate('end_date','>=',Carbon::now())->get();
        if(count($kitchen_sponsors) == 0) return response()->json(['message' => 'there is no exist valid sponsorship to extend']);

        $start_date = $kitchen_sponsors->last()['end_date'];
        $start_date = Carbon::parse($start_date);
        switch ($sponsor_duration->duration_type){
            case 'year':
                $end_date = $start_date->addYears($sponsor_duration->duration);

                break;
            case 'day':
                $end_date = $start_date->addDays($sponsor_duration->duration);

                break;
            default:
                $end_date = $start_date->addMonths($sponsor_duration->duration);
                break;
        }
        $kitchen_sponsor = KitchenSponsor::create([
            'kitchen_id' => $kitchen->id,
            'sponsor_duration_id' => $request->sponsor_duration_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'accepted' => 0,
            'paid' => 0, //TODO
            'checkout_id' => $request->checkout_id
        ]);

        if ($request->payment_method == KitchenSponsor::WALLET_PAYMENT)$kitchen_duration =  $this->extendWallet($request,$user,$sponsor_duration,$kitchen_sponsor);

        return response()->json([
            "data" => 'done'
        ]);
        return new KitchenDurationResource($kitchen_sponsor->kitchenDuration);
    }
    public function extendOnline(Request $request)
    {

        $request->validate([
            'checkout_id' => 'required|exists:checkouts,checkout_id',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = User::find(1);
        $kitchen = auth()->user()->kitchen;
        Cashier::setActor($user)->setCheckout($request->checkout_id);
        $checkout = Cashier::updateStatus()->getCheckout();

        if ($checkout->transactions()->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'checkout' => [__('The given checkout_id already used.')],
                'status' => trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        $status = TransactionStatuses::PENDING_STATUS;

        if ($checkout->isPending()) {
            $status = TransactionStatuses::PENDING_STATUS;
        }
        if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
            $status = TransactionStatuses::BALANCE_STATUS;
        }
        if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
            $status = TransactionStatuses::REJECTED_STATUS;
        }

        if (! $checkout->isSuccessful() && ! $checkout->isSuccessfulAndPending()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'balance' => 'Error: '. trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        $user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => $checkout->amount,
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => Wallet::TRANSFER_STATUS,
        ]);
        $kitchen_sponsor = KitchenSponsor::where('checkout_id', $request->checkout_id)->first();
        $kitchen_sponsor->update(['paid' => 1 , 'accepted' => 1]);
        $kitchen_sponsors = KitchenSponsor::where('kitchen_id',$kitchen->id)->where('paid',1)->whereDate('end_date','>=',Carbon::now())->get();
        if($kitchen_sponsors){
            $start_date = $kitchen_sponsors->first()['start_date'];
            $end_date = $kitchen_sponsor->end_date;
            $cost = 0;
            foreach ($kitchen_sponsors as $sponsor)
                $cost += $sponsor->sponsor_duration->cost;
        }else{
            return response()->json(['message' => trans('sponsorship.messages.not-found')],404);
        }
        $kitchen_duration = KitchenDuration::where('kitchen_id',$kitchen->id)->whereDate('end_date','>=',Carbon::now())->first();
        KitchenDuration::find($kitchen_duration->id)->update([
            'kitchen_id' => $kitchen_sponsor->kitchen_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cost' => $cost,
        ]);
        $kitchen_sponsor->update(['kitchen_duration_id' => $kitchen_duration->id]);
        return response()->json([
            "data" => 'done'
        ]);
    }
    private function extendWallet($request, $user , $sponsor_duration , $kitchen_sponsor)
    {
        $kitchen = auth()->user()->kitchen;
        if ($request->payment_method == KitchenSponsor::WALLET_PAYMENT) {
            if ($user->can_withdrew($sponsor_duration->cost)){
                $user->transferMoney(auth()->user(), User::find(1),$sponsor_duration->cost);
            }
        }
        $kitchen_sponsor->update(['paid' => 1 , 'accepted' => 1]);
        $kitchen_sponsors = KitchenSponsor::where('kitchen_id',$kitchen->id)->where('paid',1)->whereDate('end_date','>=',Carbon::now())->get();
        if($kitchen_sponsors){
            $start_date = $kitchen_sponsors->first()['start_date'];
            $end_date = $kitchen_sponsor->end_date;
            $cost = 0;
            foreach ($kitchen_sponsors as $sponsor)
                $cost += $sponsor->sponsor_duration->cost;
        }else{
            return response()->json(['message' => trans('sponsorship.messages.not-found')],404);
        }
        $kitchen_duration = KitchenDuration::where('kitchen_id',$kitchen->id)->whereDate('end_date','>=',Carbon::now())->first();
        KitchenDuration::find($kitchen_duration->id)->update([
            'kitchen_id' => $kitchen_sponsor->kitchen_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cost' => $cost,
        ]);
        $kitchen_sponsor->update(['kitchen_duration_id' => $kitchen_duration->id]);
        return $kitchen_duration;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return \App\Http\Resources\KitchenResource
     */
    public function show() :object
    {
        if(is_null(auth()->user()->kitchen->sponsor)) return response()->json(['message' => trans('sponsorship.messages.not-found')]);
        return response()->json([
            'sponsor_duration' => new SponsorDurationResource(auth()->user()->kitchen->sponsor->sponsor_duration) ,
            "sponsor" => new SponsorPlanResource(auth()->user()->kitchen->sponsor)]);
    }
    public function showSummerySponsor(Kitchen $kitchen) :object
    {
        $sponsor_duration = KitchenDuration::where('kitchen_id',$kitchen->id)->first();
        if($sponsor_duration){
            return response()->json([
                'start_date' => date("Y-m-d", strtotime($sponsor_duration->start_date)) ,
                "end_date" => date("Y-m-d", strtotime($sponsor_duration->end_date)),
            ], 200);
        }else{
            return response()->json(['message' => trans('kitchen.messages.not-found')], 404);
        }
    }

    public function sponsorshipDetails(KitchenDuration $kitchenDuration)
    {
        return (new KitchenDurationResource($kitchenDuration))->additional([
            "details" => SponsorPlanResource::collection($kitchenDuration->KitchenSponsor)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
