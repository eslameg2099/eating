<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  int  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Coupon $coupon)
    {
        return response()->json(["data" => $coupon->get_discount($coupon)]);
    }
    protected function applyCoupon($coupon)
    {
        /** @var \App\Models\Coupon $coupon */
        if (! $coupon = Coupon::where('title', $coupon)->first()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is invalid.')],
            ]);
        }
        if ($coupon->isExpired()) {
            throw ValidationException::withMessages([
                'coupon' => [__('The coupon you entered is expired.')],
            ]);
        }

        return response()->json(["data" => $coupon->get_discount($coupon)]);
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
