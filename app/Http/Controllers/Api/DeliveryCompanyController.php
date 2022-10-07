<?php

namespace App\Http\Controllers\Api;

use App\Models\DeliveryCompany;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\DeliveryCompanyResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeliveryCompanyController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the delivery_companies.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $delivery_companies = DeliveryCompany::filter()->simplePaginate();

        return DeliveryCompanyResource::collection($delivery_companies);
    }

    /**
     * Display the specified delivery_company.
     *
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return \App\Http\Resources\DeliveryCompanyResource
     */
    public function show(DeliveryCompany $delivery_company)
    {
        return new DeliveryCompanyResource($delivery_company);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $delivery_companies = DeliveryCompany::filter()->simplePaginate();

        return SelectResource::collection($delivery_companies);
    }
}
