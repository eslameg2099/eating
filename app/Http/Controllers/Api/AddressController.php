<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AddressResource::collection(auth()->user()->addresses()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return AddressResource
     */
    public function store(AddressRequest $request)
    {
        $address = auth()->user()->addresses()->create($request->validated());
        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AddressResource
     */
    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return AddressResource
     */
    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response()->json(["message" => trans("address.messages.deleted")]);
    }
}
