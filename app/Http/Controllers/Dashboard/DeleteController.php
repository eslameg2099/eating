<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\KitchenActivationEvent;
use App\Models\KitchenDuration;
use App\Models\KitchenSponsor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{
    /**
     * Delete the given items of the given model type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if (class_exists($modelClass = $request->input('type'))) {
            $modelClass::find($request->input('items', []))
                ->each(function ($model) {
                    if (Gate::allows('delete', $model) || Gate::allows('reject', $model)) {
                        $model->delete();
                    }
                });
        }

        flash()->success(trans('check-all.messages.deleted', [
            'type' => $request->input('resource'),
        ]));

        return back();
    }

    /**
     * Restore the given items of the given model type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request)
    {
        if (class_exists($modelClass = $request->input('type'))) {
            $modelClass::withTrashed()->whereIn('id', $request->input('items', []))
                ->each(function ($model) {
                    if (Gate::allows('restore', $model)) {
                        $model->restore();
                    }
                });
        }

        flash()->success(trans('check-all.messages.restored', [
            'type' => $request->input('resource'),
        ]));

        return back();
    }
    /**
     * Accept the given items of the given model type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept_all(Request $request)
    {
        if (class_exists($modelClass = $request->input('type'))) {
            $modelClass::whereIn('id', $request->input('items', []))
                ->each(function ($model) {
                    if (Gate::allows('accept', $model)) {
                        $model->update([
                            "verified_at" => Carbon::now()
                        ]);
                        event(new KitchenActivationEvent($model));

                    }
                });
        }
        flash()->success(trans('check-all.messages.accept', [
            'type' => $request->input('resource'),
        ]));

        return back();
    }
    public function acceptAllSponsors(Request $request)
    {
        if (class_exists($modelClass = $request->input('type'))) {
            $modelClass::whereIn('id', $request->input('items', []))
                ->each(function ($model) {
                    if (Gate::allows('accept', $model)) {
                        $kitchenSponsor = $model->KitchenSponsor->first();
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
                            flash()->success(trans('kitchensponsor.messages.accepted'));
                            return back();
                        }
                        KitchenDuration::where('id',$kitchenSponsor['kitchen_duration_id'])->update([
                            'kitchen_id' => $kitchenSponsor->kitchen_id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'cost' => $cost,
                            'status' => KitchenSponsor:: ACCEPTED_STATUS
                        ]);
                    }
                });
        }
        flash()->success(trans('check-all.messages.accept', [
            'type' => $request->input('resource'),
        ]));

        return back();
    }

    /**
     * Force delete the given items of the given model type.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Request $request)
    {
        if (class_exists($modelClass = $request->input('type'))) {
            $modelClass::withTrashed()->whereIn('id', $request->input('items', []))
                ->each(function ($model) {
                    if (Gate::allows('forceDelete', $model)) {
                        $model->forceDelete();
                    }
                });
        }

        flash()->success(trans('check-all.messages.deleted', [
            'type' => $request->input('resource'),
        ]));

        return back();
    }
}
