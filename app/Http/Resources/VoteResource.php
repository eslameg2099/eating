<?php

namespace App\Http\Resources;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if (isset($request->special_order_id)) return $this->specialOrderToArray($request);
        return [
          'id' => $this->id,
          'meal_name' => $this->when($this->meal,function(){
              return $this->meal->name;
          }),
          'meal_id' => $this->meal_id,
          'rate' => $this->rate,
          'comment' => $this->comment,
          'user' => new MiniUserResource($this->customer),
        ];
    }

    private function specialOrderToArray($request)
    {
        return [
            'id' => $this->id,
            'meal_id' => $this->meal_id,
            'special_order_id' => $this->special_order_id,
            'rate' => $this->rate,
            'comment' => $this->comment,
            'user' => new MiniUserResource($this->customer),
        ];
    }
}