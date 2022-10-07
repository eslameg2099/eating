<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MealRequest;
use App\Http\Requests\Api\UpdateMealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    //public function __construct()
    //{
    //    $this->authorizeResource(Meal::class, 'meal');
    //}
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::filter()->latest()->paginate();
        return view("dashboard.meals.index",compact("meals"));
    }
    public function trashed()
    {
        $meals = Meal::onlyTrashed()->filter()->latest()->paginate();
        return view("dashboard.meals.trashed",compact("meals"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.meals.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealRequest $request)
    {
        $meal = Meal::create($request->all());
        $meal->addAllMediaFromTokens();

        flash()->success(trans('meal.messages.created'));
        return redirect()->route('dashboard.meals.show', $meal);
    }

    /**
     * Display the specified resource.
     *
     * @param  Meal $meal
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return view('dashboard.meals.show',compact('meal'));
    }
    public function showTrashed($meal)
    {
        $meal = Meal::onlyTrashed()->find($meal);
        $this->authorize('viewTrash', $meal);

        return view('dashboard.meals.show', compact('meal'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Meal $meal
     * @return \Illuminate\Http\Response
     */
    public function edit($meal)
    {
        $meal = Meal::withTrashed()->find($meal);
        return view("dashboard.meals.edit",compact('meal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMealRequest $request,$meal)
    {
        $meal = Meal::withTrashed()->find($meal);
        //dd($meal);
        $meal->update($request->all());

        $meal->addAllMediaFromTokens();

        flash()->success(trans('meal.messages.updated'));

        return redirect()->route('dashboard.meals.show', $meal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();
        flash()->success(trans('meal.messages.soft_delete'));
        return redirect()->route('dashboard.meals.index');
    }
    public function restore($meal)
    {
        $meal = Meal::onlyTrashed()->find($meal);
        $this->authorize('restore', $meal);
        $meal->restore();
        flash()->success(trans('meal.messages.restore_meal'));
        return redirect()->route('dashboard.meals.index');
    }
}
