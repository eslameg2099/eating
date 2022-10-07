<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Helpers\priceHelper;
use App\Models\Order;
use App\Models\SpecialOrder;
use App\Models\User;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $admin_commission = priceHelper::adminCommission();
        $orders = Order::where('status',Order::DELIVERED_STATUS)
            ->whereNotNull('sub_total')
            ->whereNotNull('total_cost');
        $specials = SpecialOrder::where('status',SpecialOrder::FINISHED_STATUS)
                    ->whereNotNull('cost');
        $special_profit = $specials->count() * $admin_commission;
        $chefs_cost = $orders->sum('sub_total');
        $orders_profit = $orders->sum('total_cost') - $chefs_cost;
        $chefs_cost += ($specials->sum('cost') - ($specials->count() * $admin_commission));
        $total_profit = $orders_profit + $special_profit;
        $balances = User::whereIn('type',[User::CUSTOMER_TYPE , User::CHEF_TYPE])->get();
        $wallets = 0 ;
        foreach ($balances as $balance)
            $wallets += $balance->wallet()->Balance();
        return view('dashboard.home',compact('chefs_cost','total_profit' ,'wallets'));
    }
}
