<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\KitchenResourceSpecific;
use App\Models\Kitchen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChefResource;
use App\Http\Resources\KitchenResource;
use App\Http\Requests\Api\CreateKitchenRequest;
use App\Http\Requests\Api\UpdateKitchenRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(request $request)
    {
       
        $kitchens = Kitchen::active()->filter()->latest()->simplePaginate();
        return KitchenResource::collection($kitchens);
    }
    public function types()
    {
        return [
            'data' => [
                'kitchen' => trans("kitchen.types.kitchen"),
                'foodtruck' => trans("kitchen.types.foodtruck")
            ]

        ];
    }

    public function cookable($cookable_id)
    {
        switch ($cookable_id) {
            case '1':
                return 'kitchen';
            case '2':
                return 'foodtruck';
            default:
                return 'foodtruck';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CreateKitchenRequest  $request
     * @return ChefResource
     * @return \App\Http\Resources\KitchenResource
     */
    public function store(CreateKitchenRequest $request, Kitchen $kitchen)
    {
        $request = $request->validated();
        $request['cookable_type'] = $this->cookable($request['cookable_id']);
        $kitchen = $kitchen->create($request);
        $kitchen->uploadFile('avatar');
        if ($request['attach'] != null) {
        $kitchen->uploadFile('attach');
        }

    

        return new ChefResource(auth()->user());
    }

    /**
     * Display the specified resource.
     *
     * @return KitchenResource
     */
    public function show()
    {
        try {
            if (auth()->user()->kitchen()->exists()) {
                $kitchen = auth()->user()->kitchen()->first();
            } else {
                return response()->json(["message"=>trans('kitchen.messages.not-found')], 422);
            }
        } catch (\Throwable $exception) {
            return response()->json(["message"=>trans('kitchen.messages.not-found')], 422);
        }

        return new KitchenResourceSpecific($kitchen);
    }

    public function show_kitchen(Kitchen $kitchen)
    {
        return new KitchenResourceSpecific($kitchen);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateKitchenRequest  $request
     * @param  int  $id
     * @return ChefResource
     * @return \App\Http\Resources\KitchenResource
     */
    public function update(UpdateKitchenRequest $request, Kitchen $kitchen)
    {
        
        $data = $request->validated();
       
        if (isset($request['cookable_id'])) {
            $data['cookable_type'] = $this->cookable($data['cookable_id']);
        }

        try {
            $kitchen->update($data);
            $kitchen->map_addres = $request->address_on_map;
            $kitchen->save();
            if ($request->hasFile('avatar')) {
                $kitchen->addMediaFromRequest('avatar')
                    ->usingFileName(time().'.png')
                    ->toMediaCollection();
            }
        } catch (\Throwable $exception) {
            return response()->json(["message"=>trans('kitchen.messages.not-found')], 422);
        }

        return new ChefResource(auth()->user());
    }

    public function activate_kitchen(Request $request, Kitchen $kitchen)
    {
        $validated = $request->validate([
            'active' => 'required|in:0,1',
        ]);
        try {
            $kitchen->update($validated);
        } catch (\Throwable $exception) {
            return response()->json("Something Went Wrong", 500);
        }

        return new KitchenResource($kitchen->refresh());
    }

    public function activate_special_orders(Request $request, Kitchen $kitchen)
    {
        $validated = $request->validate([
            'active_special' => 'required|in:0,1',
        ]);
        try {
            $kitchen->update($validated);
        } catch (\Throwable $exception) {
            return response()->json("Something Went Wrong", 500);
        }

        return new KitchenResource($kitchen->refresh());
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

    public function favorite(Kitchen $kitchen)
    {
        auth()->user()->toggleFavorite($kitchen); // The user added to favorites this kitchen;

        return new KitchenResource($kitchen);
    }

    public function list_favorite(Request $request)
    {
        //$kitchens = Kitchen::onlyFavorited(auth()->user())->simplePaginate();
        //$kitchens = auth()->user()->favorite(Kitchen::class); // The user added to favorites  kitchens;
        $kitchens = Kitchen::filter()->onlyFavorited(Auth::id())->get(); // The user added to favorites  kitchens;

        return KitchenResource::collection($kitchens);
    }
}
