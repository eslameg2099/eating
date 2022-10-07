<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KitchenDuration;
use App\Models\KitchenSponsor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KitchenSponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kitchenDurations = KitchenDuration::with('kitchen','KitchenSponsor')->latest()->paginate();
        return view('dashboard.kitchenSponsors.index',compact('kitchenDurations'));
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
    public function show(KitchenDuration $kitchenDuration)
    {
        return view("dashboard.kitchenSponsors.show",compact('kitchenDuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(KitchenDuration $kitchenDuration)
    {
        return view("dashboard.kitchenSponsors.edit",compact('kitchenDuration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  KitchenDuration $kitchenDuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KitchenDuration $kitchenDuration)
    {
        $kitchenDuration->kitchenSponsor->first()->addAllMediaFromTokens();

        flash()->success(trans('kitchensponsor.messages.updated'));

        return redirect()->route('dashboard.kitchenDurations.show', $kitchenDuration);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  KitchenDuration $kitchenDuration
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, KitchenDuration $kitchenDuration)
    {
        $kitchenSponsor = $kitchenDuration->KitchenSponsor->first();
        $start_date = Carbon::now();
        switch ($kitchenSponsor->sponsor_duration->duration_type){
            case 'year':
                $end_date = Carbon::now()->addYears($kitchenSponsor->sponsor_duration->duration);
                break;
            case 'day':
                $end_date = Carbon::now()->addDays($kitchenSponsor->sponsor_duration->duration);
                break;
            default:
                $end_date = Carbon::now()->addMonths($kitchenSponsor->sponsor_duration->duration);
                break;
        }
        $kitchenSponsor->update([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'accepted' => 1,
        ]);
        $kitchen_sponsors = KitchenSponsor::where('kitchen_id',$kitchenSponsor->kitchen_id)->whereDate('end_date','>=',Carbon::now())->get();
        if($kitchen_sponsors){
            $start_date = $kitchen_sponsors->first()->start_date;
            $end_date = $kitchen_sponsors->last()->end_date;
            $cost = 0;
            foreach ($kitchen_sponsors as $sponsor)
                $cost += $sponsor->sponsor_duration->cost;
        }else{
            return flash()->success(trans('kitchensponsor.messages.accepted'));;
        }
        KitchenDuration::where('id',$kitchenSponsor['kitchen_duration_id'])->update([
            'kitchen_id' => $kitchenSponsor->kitchen_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cost' => $cost,
            'status' => KitchenSponsor:: ACCEPTED_STATUS
        ]);
        flash()->success(trans('kitchensponsor.messages.accepted'));
        return redirect()->route('dashboard.kitchenDurations.show', $kitchenDuration);
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
