<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\DeliveryCompany;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\DeliveryCompanyRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeliveryCompanyController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * DeliveryCompanyController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(DeliveryCompany::class, 'delivery_company');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_companies = DeliveryCompany::filter()->paginate();

        return view('dashboard.delivery_companies.index', compact('delivery_companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.delivery_companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\DeliveryCompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DeliveryCompanyRequest $request)
    {
        $delivery_company = DeliveryCompany::create($request->all());

        flash()->success(trans('delivery_companies.messages.created'));

        return redirect()->route('dashboard.delivery_companies.show', $delivery_company);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryCompany $delivery_company)
    {
        return view('dashboard.delivery_companies.show', compact('delivery_company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryCompany $delivery_company)
    {
        return view('dashboard.delivery_companies.edit', compact('delivery_company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\DeliveryCompanyRequest $request
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DeliveryCompanyRequest $request, DeliveryCompany $delivery_company)
    {
        $delivery_company->update($request->all());

        flash()->success(trans('delivery_companies.messages.updated'));

        return redirect()->route('dashboard.delivery_companies.show', $delivery_company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DeliveryCompany $delivery_company)
    {
        $delivery_company->delete();

        flash()->success(trans('delivery_companies.messages.deleted'));

        return redirect()->route('dashboard.delivery_companies.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', DeliveryCompany::class);

        $delivery_companies = DeliveryCompany::onlyTrashed()->paginate();

        return view('dashboard.delivery_companies.trashed', compact('delivery_companies'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(DeliveryCompany $delivery_company)
    {
        $this->authorize('viewTrash', $delivery_company);

        return view('dashboard.delivery_companies.show', compact('delivery_company'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(DeliveryCompany $delivery_company)
    {
        $this->authorize('restore', $delivery_company);

        $delivery_company->restore();

        flash()->success(trans('delivery_companies.messages.restored'));

        return redirect()->route('dashboard.delivery_companies.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(DeliveryCompany $delivery_company)
    {
        $this->authorize('forceDelete', $delivery_company);

        $delivery_company->forceDelete();

        flash()->success(trans('delivery_companies.messages.deleted'));

        return redirect()->route('dashboard.delivery_companies.trashed');
    }
}
