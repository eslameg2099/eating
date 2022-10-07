<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\KitchenActivationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateKitchenRequest;
use App\Models\City;
use App\Models\Kitchen;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * AdminController constructor.
     *
     */
    public function __construct()
    {
        //$this->authorizeResource(Kitchen::class, 'kitchens');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $kitchens = Kitchen::filter()->latest()->paginate();

        return view('dashboard.kitchens.index', compact('kitchens'));
    }
    public function indexRequests()
    {
        $kitchens = Kitchen::filter()->whereNull('verified_at')->latest()->paginate();

        return view('dashboard.kitchens.requests.index', compact('kitchens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::listsTranslations('name')->pluck('name', 'id');

        return view('dashboard.kitchens.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\KitchenRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateKitchenRequest $request)
    {
        if(! $request->input("verified_at")) $request["verified_at"] = null ;
        $request->request->add(['latitude' => $request->lat , 'longitude' => $request->lng]);
        $kitchen = Kitchen::create($request->all());

        $kitchen->addAllMediaFromTokens();

        flash()->success(trans('kitchen.messages.created'));

        return redirect()->route('dashboard.kitchens.show', $kitchen);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Kitchen $kitchen
     * @return \Illuminate\Http\Response
     */
    public function show(Kitchen $kitchen)
    {
        return view('dashboard.kitchens.requests.show', compact('kitchen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Kitchen $kitchen
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Kitchen $kitchen)
    {
        $cities = City::listsTranslations('name')->pluck('name', 'id');
        return view('dashboard.kitchens.edit', compact('kitchen','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\KitchenRequest $request
     * @param \App\Models\Kitchen $kitchen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateKitchenRequest $request, Kitchen $kitchen)
    {
        if(! $request->input("verified_at")) $request["verified_at"] = null ;
        $kitchen->update($request->all());

        $kitchen->addAllMediaFromTokens();

        flash()->success(trans('kitchen.messages.updated'));
        if ($request->input("verified_at")) event(new KitchenActivationEvent($kitchen->refresh()));

        return redirect()->route('dashboard.kitchens.show', $kitchen);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Kitchen $kitchen
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Kitchen $kitchen)
    {
        //$kitchen = Kitchen::withTrashed()->find($kitchen->id);
        $kitchen->delete();

        flash()->success(trans('kitchen.messages.deleted'));

        return redirect()->route('dashboard.kitchens.index');
    }
    public function accept(Kitchen $kitchen)
    {
        //$kitchen = Kitchen::withTrashed()->find($kitchen->id);
        $kitchen->update([
            "verified_at" => Carbon::now()
        ]);
        event(new KitchenActivationEvent($kitchen));
        flash()->success(trans('kitchen.messages.accept'));

        return redirect()->route('dashboard.kitchens.requests.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Kitchen::class);

        $kitchens = Kitchen::onlyTrashed()->paginate();

        return view('dashboard.kitchens.trashed', compact('kitchens'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Kitchen $kitchen
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showTrashed(Kitchen $kitchen)
    {
        $this->authorize('viewTrash', $kitchen);

        return view('dashboard.kitchens.show', compact('kitchen'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Kitchen $kitchen
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($kitchen)
    {
        $kitchen = Kitchen::withTrashed()->find($kitchen);
        $this->authorize('restore', $kitchen);

        $kitchen->restore();

        flash()->success(trans('kitchen.messages.restored'));

        return redirect()->route('dashboard.kitchens.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Kitchen $kitchen
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Kitchen $kitchen)
    {
        $this->authorize('forceDelete', $kitchen);

        $kitchen->forceDelete();

        flash()->success(trans('kitchen.messages.deleted'));

        return redirect()->route('dashboard.kitchens.trashed');
    }
    public function accept_all()
    {

    }
}
