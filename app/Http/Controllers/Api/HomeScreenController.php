<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\HomeScreenOffersResource;
use App\Http\Resources\KitchenDurationResource;
use App\Models\Kitchen;
use App\Models\Category;
use App\Models\KitchenDuration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KitchenResource;
use App\Http\Resources\CategoryResource;

class HomeScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        
        $offers = KitchenDuration::whereDate('end_date','>=',Carbon::now())->get();
        $array2[] = (object) [
            'avatar' => url('/images/home-offer.png')
        ];
        if($request->city_id != null)
        {
            return response()->json([
                'offers' => $offers->isEmpty() ? $array2 : HomeScreenOffersResource::collection($offers),
                'categories' => CategoryResource::collection(Category::whereNotNull('active_at')->inRandomOrder()->limit(5)->get()),
                'kitchens' => KitchenResource::collection(Kitchen::active()->where('cookable_type', 'kitchen')->where('city_id',$request->city_id)->inRandomOrder()->limit(5)->get()),
                'foodtruck' => KitchenResource::collection(Kitchen::active()->where('cookable_type', 'foodtruck')->where('city_id',$request->city_id)->inRandomOrder()->limit(5)->get()),
                 ]);
         

        }
       else
       return response()->json([
        'offers' => $offers->isEmpty() ? $array2 : HomeScreenOffersResource::collection($offers),
        'categories' => CategoryResource::collection(Category::whereNotNull('active_at')->inRandomOrder()->limit(5)->get()),
        'kitchens' => KitchenResource::collection(Kitchen::active()->where('cookable_type', 'kitchen')->inRandomOrder()->limit(5)->get()),
        'foodtruck' => KitchenResource::collection(Kitchen::active()->where('cookable_type', 'foodtruck')->inRandomOrder()->limit(5)->get()),
        
    ]);
      


    }
}
