<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CrateSponsorDurationRequest;
use App\Models\SponsorDurations;
use Illuminate\Http\Request;

class SponsorDurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sponsorDurations = SponsorDurations::filter()->latest()->paginate();
        return view("dashboard.SponsorDurations.index",compact("sponsorDurations"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.SponsorDurations.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CrateSponsorDurationRequest $request)
    {
        $sponsorDuration = SponsorDurations::create($request->validated());
        flash()->success(trans('sponsorship.messages.create'));

        return redirect()->route('dashboard.sponsorDurations.show', $sponsorDuration);
    }

    /**
     * Display the specified resource.
     *
     * @param  SponsorDurations $sponsorDuration
     * @return \Illuminate\Http\Response
     */
    public function show(SponsorDurations $sponsorDuration)
    {
        return view("dashboard.SponsorDurations.show",compact("sponsorDuration"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SponsorDurations $sponsorDuration)
    {
        return view("dashboard.SponsorDurations.edit",compact('sponsorDuration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CrateSponsorDurationRequest $request, SponsorDurations $sponsorDuration)
    {
        $sponsorDuration->update($request->all());
        flash()->success(trans('sponsorship.messages.update'));
        return redirect()->route('dashboard.sponsorDurations.show', $sponsorDuration);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SponsorDurations $sponsorDuration)
    {
        $sponsorDuration->delete();
        flash()->success(trans('sponsorship.messages.deleted'));
        return redirect()->route('dashboard.sponsorDurations.index');
    }


}
