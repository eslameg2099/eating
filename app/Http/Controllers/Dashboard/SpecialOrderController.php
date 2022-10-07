<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SpecialOrder;
use DB;
use Illuminate\Http\Request;

class SpecialOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $special_orders = SpecialOrder::filter()->latest()->paginate();
        return view("dashboard.orders.specialOrders.index",compact("special_orders"));
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
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialOrder $specialOrder)
    {
        return view("dashboard.orders.specialOrders.show",compact("specialOrder"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(SpecialOrder $specialOrder)
    {
        return view("dashboard.orders.specialOrders.edit",compact("specialOrder"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpecialOrder $specialOrder)
    {
        if ($specialOrder->payment_method == SpecialOrder::CASH_PAYMENT) $specialOrder->update(["status" => $request->status]);
        if ($specialOrder->payment_method != SpecialOrder::CASH_PAYMENT && $request->status != SpecialOrder::FINISHED_STATUS) $this->cancelOrder($request , $specialOrder);
        flash()->success(trans('orders.messages.updated'));
        return redirect()->route('dashboard.specialOrders.show', $specialOrder);
    }
    private function cancelOrder($request , $specialOrder)
    {
        DB::transaction(function () use($specialOrder)
        {
            $user = $specialOrder->customer;
            $chef = $specialOrder->kitchen->user;
            $admin = auth()->user();
            $user->transferMoney($chef,$user,$specialOrder->sub_total);
            $user->transferMoney($admin,$user,$specialOrder->shipping_cost);
        });
        $specialOrder->update(["status" => $request->status]);
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
