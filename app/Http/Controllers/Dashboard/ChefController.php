<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Chef;
use App\Models\City;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ChefRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ChefController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ChefController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Chef::class, 'chef');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chefs = Chef::filter()->latest()->paginate();

        return view('dashboard.accounts.chefs.index', compact('chefs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::listsTranslations('name')->pluck('name', 'id');
        return view('dashboard.accounts.chefs.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ChefRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ChefRequest $request)
    {
        if(! $request->input("phone_verified_at")) $request["phone_verified_at"] = null ;
        $chef = Chef::create($request->allWithHashedPassword());

        $chef->setType($request->type);
        $chef->fastDeposit($chef,0);
        if ($request->user()->isAdmin()) {
            $chef->syncPermissions($request->input('permissions', []));
        }

        $chef->addAllMediaFromTokens();

        flash()->success(trans('chefs.messages.created'));

        return redirect()->route('dashboard.chefs.show', $chef);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Chef $chef
     * @return \Illuminate\Http\Response
     */
    public function show(Chef $chef)
    {
        return view('dashboard.accounts.chefs.show', compact('chef'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Chef $chef
     * @return \Illuminate\Http\Response
     */
    public function edit(Chef $chef)
    {
        $cities = City::listsTranslations('name')->pluck('name', 'id');
        return view('dashboard.accounts.chefs.edit', compact('chef','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ChefRequest $request
     * @param \App\Models\Chef $chef
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChefRequest $request, Chef $chef)
    {
        if(! $request->input("phone_verified_at")) $request["phone_verified_at"] = null ;
        $chef->update($request->allWithHashedPassword());

        $chef->setType($request->type);

        if ($request->user()->isAdmin()) {
            $chef->syncPermissions($request->input('permissions', []));
        }

        $chef->addAllMediaFromTokens();

        flash()->success(trans('chefs.messages.updated'));

        return redirect()->route('dashboard.chefs.show', $chef);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chef $chef
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Chef $chef)
    {
        $chef->delete();

        flash()->success(trans('chefs.messages.deleted'));

        return redirect()->route('dashboard.chefs.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Chef::class);

        $chefs = Chef::onlyTrashed()->paginate();

        return view('dashboard.accounts.chefs.trashed', compact('chefs'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Chef $chef
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Chef $chef)
    {
        $this->authorize('viewTrash', $chef);

        return view('dashboard.accounts.chefs.show', compact('chef'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Chef $chef
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Chef $chef)
    {
        $this->authorize('restore', $chef);

        $chef->restore();

        flash()->success(trans('chefs.messages.restored'));

        return redirect()->route('dashboard.chefs.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Chef $chef
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Chef $chef)
    {
        $this->authorize('forceDelete', $chef);

        $chef->forceDelete();

        flash()->success(trans('chefs.messages.deleted'));

        return redirect()->route('dashboard.chefs.trashed');
    }
}
