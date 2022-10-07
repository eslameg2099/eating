<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\DeliveryExport;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\SpecialOrder;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::filter()->latest()->paginate();
        return view("dashboard.orders.idealOrders.index",compact("orders"));
    }
    public function delivery()
    {
        $deliveries = Delivery::filter()->with('delivery_company');
        $total_cost = $deliveries->where('status',200)->sum('cost');
        $total_profit = 0 ;
        $deliveries = $deliveries->latest()->paginate();
        foreach ($deliveries as $delivery) {
            $total_profit += $delivery->order->shipping_cost;
        }

        return view("dashboard.orders.idealOrders.delivery",compact("deliveries","total_cost","total_profit"));
    }
    public function excel(Request $request)
    {
        $withdrawals = Delivery::whereIn('id',$request->input('items', []))->get();
        return Excel::download(new DeliveryExport($withdrawals), date('Y-m-d').'.xls',
            \Maatwebsite\Excel\Excel::XLS);

        flash()->success(trans('wallets.messages.withdrawals'));
        return redirect('dashboard.deliveries.delivery');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view("dashboard.orders.idealOrders.show",compact("order"));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view("dashboard.orders.idealOrders.edit",compact("order"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        if ($order->payment_method == Order::CASH_PAYMENT) $order->update(["status" => $request->status]);
        if ($order->payment_method != Order::CASH_PAYMENT && $request->status != Order::DELIVERED_STATUS) $this->cancelOrder($request , $order);
        flash()->success(trans('orders.messages.updated'));
        return redirect()->route('dashboard.orders.show', $order);
    }
    private function cancelOrder($request , $order)
    {
        DB::transaction(function () use($order)
        {
            $user = $order->customer;
            $chef = $order->kitchen->user;
            $admin = auth()->user();
            $user->transferMoney($chef,$user,$order->sub_total);
            $user->transferMoney($admin,$user,$order->shipping_cost);
        });
        $order->update(["status" => $request->status]);
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
