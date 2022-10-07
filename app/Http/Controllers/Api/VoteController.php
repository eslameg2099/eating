<?php

namespace App\Http\Controllers\Api;

use App\Events\VoteEvent;
use App\Models\Chef;
use App\Models\Kitchen;
use App\Models\Meal;
use App\Models\Vote;
use App\Notifications\MakeReviewNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Http\Requests\Api\VoteRequest;
use App\Http\Resources\KitchenResource;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $votes = auth()->user()->votes()->simplePaginate();
        return VoteResource::collection($votes);
    }
    public function indexMeals(Meal $meal)
    {
        $votes = $meal->votes()->simplePaginate();
        return VoteResource::collection($votes);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\VoteRequest  $request
     * @return VoteResource
     */
    public function store(VoteRequest $request)
    {
        $vote = auth()->user()->vote()->updateOrCreate([
            'user_id'   => auth()->user()->id,
            'meal_id'   => $request->meal_id,
            'special_order_id' => $request->special_order_id
        ],$request->validated());
        //dd($vote);
        event(new VoteEvent($vote));
        return new VoteResource($vote);
    }

    /**
     * Display the specified resource.
     *
     * @param  Kitchen $kitchen
     * @return KitchenResource
     */
    public function show($id)
    {
        try {
            $kitchen = Kitchen::find($id);
        } catch (\Throwable $exception) {
            return response()->json(["message" => trans("vote.messages.not-found")], 417);
        }

        return new KitchenResource($kitchen);
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
