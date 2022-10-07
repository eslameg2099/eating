<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use App\Exports\WithdrewExport;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Chef;
use App\Models\Customer;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Support\Payment\Contracts\TransactionStatuses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WalletController extends Controller
{
    //public function __construct()
    //{
    //    $this->authorizeResource(Wallet::class, 'wallet');
    //}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::filter()->latest()->paginate();
        //return view("dashboard.wallets.index",compact("wallets"));
    }
    public function customerWallets()
    {
        $users = Customer::filter()->whereHas('wallet')->with('wallet')->paginate();
        return view("dashboard.wallets.customersWallet.index",compact("users"));
    }
    public function chefWallets()
    {
        $users = Chef::filter()->whereHas('wallet')->paginate();
        return view("dashboard.wallets.chefsWallet.index",compact("users"));
    }
    public function adminWallets()
    {
        $wallets = Wallet::where("walletable_id",1)->latest()->paginate();
        $user = auth()->user();
        return view("dashboard.wallets.adminWallet.show",compact("user","wallets"));
    }
    public function withdrawals()
    {
        $wallets = Withdrawal::whereNull("confirmed_at")->with('user','credit')->latest()->paginate();
        //$wallets = Wallet::where("status",Wallet::WITHDRAWAL_REQUEST_STATUS)->where('confirmed',0)->whereHas('user.credit')->with('user')->latest()->paginate();
        return view("dashboard.wallets.withdrawalRequests.index",compact("wallets"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @throws \Throwable
     */
    public function withdrew(Request $request)
    {
        $withdrawals = Withdrawal::whereIn('id',$request->input('items', []))->get();
        DB::transaction(function () use ($request,$withdrawals){
            foreach ($withdrawals as $withdrawal)
            {
                $withdrawal->update(['confirmed_at' => Carbon::now()]);
                $withdrawal->wallet->update([
                    'confirmed' => 1 ,
                    'status' => TransactionStatuses::WITHDRAWAL_STATUS
                ]);
            }
        });
        return Excel::download(new WithdrewExport($withdrawals), date('Y-m-d').'.xls',
            \Maatwebsite\Excel\Excel::XLS);

        flash()->success(trans('wallets.messages.withdrawals'));
        return redirect('dashboard/wallet/withdrawals');

    }
    public function adminDeposit(User $user, Request $request)
    {
        $request->request->add(['status' => Wallet::CHARGE_WALLET_STATUS]);
        auth()->user()->deposite($user,$request->all());
        flash()->success(trans('wallets.messages.transfer'));
        return redirect('dashboard/wallet/admins');
    }

    public function transfer(User $user , Request $request)
    {
        $wallet = new Wallet();
        //DB::beginTransaction();

        //DB::transaction(function () use($user , $request , $wallet){
        if ($request->title == 'withdrew') $wallet->transferMoney($user,auth()->user(),$request->transaction * -1,$request->note);
        if ($request->title == 'deposit') {
            if (! auth()->user()->can_withdrew($request->transaction)){
                flash()->error(trans('wallets.messages.can_withdrew'));
                return redirect('dashboard/wallet/customers/'.$user->id);
            }
            $wallet->transferMoney(auth()->user(), $user, $request->transaction,$request->note);
        }
        //});
        flash()->success(trans('wallets.messages.transfer'));
        return redirect('dashboard/wallet/customers/'.$user->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $wallets = $user->wallet()->latest()->get();
        if ($user->isCustomer()) return view("dashboard.wallets.customersWallet.show",compact("user","wallets"));
        return view("dashboard.wallets.chefsWallet.show",compact("user","wallets"));
    }

    public function showCredit(User $user)
    {
        $credit = $user->credit;
        return view("dashboard.wallets.withdrawalRequests.show",compact("user","credit"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
