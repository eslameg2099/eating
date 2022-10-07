<?php

namespace App\Http\Controllers\Api;

use App\Models\AssignOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\Delegate\AssignOrderResource;

class AssignOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\Delegate\AssignOrderResource
     */
    public function index()
    {
        $order = auth()->user()->assign_order()->whereNull('assigned_at')->whereNull('delivered_at')->first();
//        return response()->json($order);
        return new AssignOrderResource($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        auth()->user()->assign_order;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AssignOrder $assignOrder)
    {
        if (! $assignOrder->delegate_id == auth()->user()->id) {
            return response()->json(["message" => "unauthorized delegate"], 401);
        }
        $assignOrder->delete();

        return response()->json(["message" => trans("assigns.messages.deleted")], 401);
    }
}
