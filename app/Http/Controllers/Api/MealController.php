<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Http\Requests\Api\MealRequest;
use App\Http\Requests\Api\UpdateMealRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $meals = auth()->user()->meals()->filter()->simplePaginate();

        return MealResource::collection($meals);
    }

    public function list_meals()
    {
        $meals = Meal::filter()->simplePaginate();

        return MealResource::collection($meals);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function trash()
    {
        $meals = auth()->user()->meals()->onlyTrashed()->filter()->simplePaginate();

        return MealResource::collection($meals);
    }

    public function sample_show()
    {
        $meals = auth()->user()->meals()->inRandomOrder()->limit(3)->get();

        return MealResource::collection($meals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\MealRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @return \App\Http\Resources\MealResource
     */
    public function store(MealRequest $request)
    {
        try {
            $meal = Meal::create($request->validated());
            if ($request->hasFile('avatar')) {
                foreach ($request->avatar as $avatar) {
                    $meal->addMedia($avatar)
                        ->usingFileName(time().'.png')
                        ->toMediaCollection('Meal');
                }
            }
        } catch (\Throwable $exception) {
            return response()->json(['message'=>"Something Went Wrong"], 422);
        }

        return $meal->getResource();
    }

    /**
     * Display the specified resource.
     *VoteResource.
     * @param  Meal $meal
     * @return \App\Http\Resources\MealResource
     */
    public function show($meal)
    {
        $meal = Meal::withTrashed()->find($meal);
        if(is_null($meal)) return response()->json(["message" => trans('meal.messages.not_found')],404);
        return $meal->getResource();
    }

    public function show_meal(Meal $meal)
    {
        return $meal->getResource();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateMealRequest  $request
     * @param  Mael  $meal
     * @return \Illuminate\Http\JsonResponse
     * @return \App\Http\Resources\MealResource

     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        try {
            $meal->update($request->validated());
            if ($request->hasFile('avatar')) {
                foreach ($request->avatar as $avatar) {
                    $meal->addMedia($avatar)
                        ->usingFileName(time().'.png')
                        ->toMediaCollection('Meal');
                }
            }
        } catch (\Throwable $exception) {
            return response()->json(['message' => 'Something Went Wrong'], 422);
        }

        return $meal->refresh()->getResource();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Meal::withTrashed()->find($id)->forceDelete();
        } catch (\Throwable $exception) {
            return response()->json(['message'=>"Something Went Wrong"], 422);
        }

        return response()->json(['message'=> trans('meal.messages.force_delete')], 200);
    }

    public function stop_meal(Meal $meal)
    {
        try {
            $meal->delete();
        } catch (\Throwable $exception) {
            return response()->json(['message'=>"Something Went Wrong"], 422);
        }

        return response()->json(['message'=> trans('meal.messages.soft_delete')], 200);
    }

    public function restore_meal($id)
    {
        try {
            Meal::withTrashed()->find($id)->restore();
        } catch (\Throwable $exception) {
            return response()->json(['message'=>"Something Went Wrong"], 422);
        }

        return response()->json(['message'=> trans('meal.messages.restore_meal')], 200);
    }

    public function favorite(Meal $meal)
    {
        auth()->user()->toggleFavorite($meal); // The user added to favorites this meal;

        return new MealResource($meal);
    }

    public function list_favorite()
    {
        $kitchens = auth()->user()->favorite(Meal::class); // The user added to favorites  kitchens;

        return MealResource::collection($kitchens);
    }
}
