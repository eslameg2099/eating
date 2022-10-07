<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VehicleRequest;

class VehicleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\VehicleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VehicleRequest $request)
    {
        if(Vehicle::where('user_id',auth()->user()->id)->exists()) return response()->json(['message'=>trans("vehicle.messages.exist")], 422);;
        $vehicle = auth()->user()->vehicle()->create($request->validated());
        if ($request->hasFile('license_plate')) {
            $vehicle->addMediaFromRequest('license_plate')
                ->toMediaCollection();
        }

        return auth()->user()->getResource();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\VehicleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Request $request)
    {
         auth()->user()->vehicle()->update([
            'active' => $request->active
        ]);
        return auth()->user()->getResource();
    }
}
