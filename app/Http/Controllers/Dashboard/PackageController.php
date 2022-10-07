<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Package;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\PackageRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PackageController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * PackageController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Package::class, 'package');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::filter()->paginate();

        return view('dashboard.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\PackageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PackageRequest $request)
    {
        $package = Package::create($request->all());

        flash()->success(trans('packages.messages.created'));

        return redirect()->route('dashboard.packages.show', $package);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        return view('dashboard.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('dashboard.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\PackageRequest $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->all());

        flash()->success(trans('packages.messages.updated'));

        return redirect()->route('dashboard.packages.show', $package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Package $package
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Package $package)
    {
        $package->delete();

        flash()->success(trans('packages.messages.deleted'));

        return redirect()->route('dashboard.packages.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Package::class);

        $packages = Package::onlyTrashed()->paginate();

        return view('dashboard.packages.trashed', compact('packages'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Package $package)
    {
        $this->authorize('viewTrash', $package);

        return view('dashboard.packages.show', compact('package'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Package $package)
    {
        $this->authorize('restore', $package);

        $package->restore();

        flash()->success(trans('packages.messages.restored'));

        return redirect()->route('dashboard.packages.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Package $package
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Package $package)
    {
        $this->authorize('forceDelete', $package);

        $package->forceDelete();

        flash()->success(trans('packages.messages.deleted'));

        return redirect()->route('dashboard.packages.trashed');
    }
}
