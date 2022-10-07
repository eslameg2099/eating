<?php

namespace App\Http\Controllers\Api;

use App\Events\CustomerPayOrderEvent;
use App\Events\OrderAcceptedEvent;
use App\Events\WalletRechargeEvent;
use App\Http\Requests\Api\PayForOrderRequest;
use App\Http\Resources\miniOrderResource;
use App\Http\Resources\MiniUserResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Support\Payment\CashierManager;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Contracts\TransactionTypes;
use App\Support\Price;
use Cassandra\Exception\ValidationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WalletRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Support\Payment\Facades\Cashier;
use Illuminate\Validation\Rule;
use Laraeast\LaravelSettings\Facades\Settings;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function balance(){
        return Wallet::where('walletable_id',auth()->user()->id)->sum("transaction");
        //return Wallet::where('walletable_id',auth()->user()->id)->where("confirmed",1)->sum("transaction");
    }
    public function index()
    {
        $transactions = Wallet::where('walletable_id', auth()->user()['id'])->filter()->latest()->simplePaginate();

        return WalletResource::collection($transactions)->additional(['balance' => (double)$this->balance()]);
    }
    public function index_sample()
    {
        $transactions = Wallet::where('walletable_id', auth()->user()['id'])->latest()->limit(3)->get();

        return WalletResource::collection($transactions)->additional(['balance' => (double)$this->balance()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\WalletRequest  $request
     * @return WalletResource
     */
    public function store(WalletRequest $request)
    {
        
        $record = $request->validated();
        $wallet = auth()->user()->deposite($record);
        if ($wallet) {
            return new WalletResource($wallet);
        }
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareCheckout(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
            'payment_type' => ['required', Rule::in(array_keys(config('services.hyperpay.payment_methods')))],
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

        $checkout = Cashier::setUser($user)->prepareCheckout(
            $request->amount,
            $request->payment_type,
        );

        return response()->json([
            'checkout_id' => $checkout->checkout_id,
        ]);
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     */
    public function recharge(Request $request)
    {
        $request->validate([
            'checkout_id' => 'required|exists:checkouts,checkout_id',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();

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

        //Artisan::call('wallet:sync');

        $status = TransactionStatuses::PENDING_STATUS;

        if ($checkout->isPending()) {
            $status = TransactionStatuses::PENDING_STATUS;
        }
        if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
            $status = TransactionStatuses::CHARGE_WALLET_STATUS;
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

        //DB::beginTransaction();

        $transaction = $user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => $checkout->amount,
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => TransactionTypes::BALANCE_RECHARGE,
        ]);

        //DB::commit();

        //event(new WalletRechargeEvent($transaction));

        return new MiniUserResource($user->refresh());
    }
    public function payForOrder(PayForOrderRequest $request)
    {
        DB::beginTransaction();
        /** @var Order $order */
        $order = Order::find($request->input('order_id'));

        if ($order->payment_type == Order::ONLINE_PAYMENT) {
            $request->validate([
                'checkout_id' => 'required|exists:checkouts,checkout_id',
            ]);
        }
        //if ($order->payment_type == Order::WALLET_PAYMENT && $order->User->getBalance() < $order->payment->getTotal()) {
        //    throw \Illuminate\Validation\ValidationException::withMessages([
        //        'amount' => trans('transactions.errors.order.not-enough'),
        //    ]);
        //}

        if (! $order) {
            return $this->error(['message' => trans('errors.cannot_find_this_order')]);
        }

        if ($order->payment_type != Order::CASH_PAYMENT) {
            $order->handlePayment($request->checkout_id);
        }


        $order->update(['purchased' => '1']);
        $order->update(['status' => Order::COOKING_STATUS]);

        DB::commit();
        $order->active = User::CUSTOMER_TYPE;
        broadcast(new OrderAcceptedEvent($order));

        return $this->success([
            'message' => trans('global.operation_succeeded'),
            'order' => new miniOrderResource($order->refresh()),
        ]);
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'account_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required|digits:14',
            'iban_number' => 'required',
            'amount' => 'numeric',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = auth()->user();
        $user_balance = $user->wallet()->Balance();
        $credit = $user->credit()->updateOrCreate([
                'user_id' => $user->id,
                'account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'iban_number' => $request->iban_number,
            ]);
        if($user_balance <= 0) throw \Illuminate\Validation\ValidationException::withMessages(['message' => trans('wallets.messages.can_withdrew')]);
        $withdrew_request = $user->withdrewRequest([
            'user_id' => $user->id,
            'credit_id' => $credit->id,
            'value' => $user_balance,
        ]);
        if (! $withdrew_request) throw \Illuminate\Validation\ValidationException::withMessages(['message' => trans('wallets.messages.can_withdrew')]);
        $transaction = $user->withdrew(auth()->user(), [
            'credit_id' => $credit->id,
           'withdrawal_id' =>$withdrew_request->id,
           'transaction' => $withdrew_request->value * (-1),
            'status' => Wallet::WITHDRAWAL_REQUEST_STATUS,
            'confirmed' => 0
        ]);

        return response()->json([
            'message' => trans('wallets.messages.withdrew'),
            'dialog_message' => trans('wallets.messages.dialog_message'),
            'balance' => new Price($user->wallet()->Balance())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
