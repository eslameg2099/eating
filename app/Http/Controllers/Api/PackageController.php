<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\PackageResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PackageController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the packages.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $packages = Package::filter()->simplePaginate();

        return PackageResource::collection($packages);
    }

    /**
     * Display the specified package.
     *
     * @param \App\Models\Package $package
     * @return \App\Http\Resources\PackageResource
     */
    public function show(Package $package)
    {
        return new PackageResource($package);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $packages = Package::filter()->simplePaginate();

        return SelectResource::collection($packages);
    }
}
