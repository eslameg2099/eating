<?php

namespace App\Http\Resources;

use App\Models\Kitchen;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeScreenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'offers' => [],
            'categories' => CategoryResource::collection(Category::all()->random(5)),
            'kitchens' => KitchenResource::collection(Kitchen::where('cookable_type', 'kitchen')->inRandomOrder()->limit(5)->get()),
            'foodtruck' => KitchenResource::collection(Kitchen::where('cookable_type', 'foodtruck')->inRandomOrder()->limit(5)->get()),


        ];
    }
}
