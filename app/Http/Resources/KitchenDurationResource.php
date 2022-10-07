<?php

namespace App\Http\Resources;

use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;

class KitchenDurationResource extends JsonResource
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
            'id' => $this->id,
            'kitchen_id' => $this->kitchen_id,
            'title' => $this->KitchenSponsor->last()->sponsor_duration->title ?? null,
            'avatar' => $this->KitchenSponsor->first()->getFirstMediaUrl() ?? null,
            'start_date' => is_null($this->start_date) ? null :date("Y-m-d", strtotime($this->start_date)),
            'end_date' => is_null($this->end_date) ? null : date("Y-m-d", strtotime($this->end_date)),
            'cost' => new Price($this->cost),
            'status' => $this->status($this->start_date,$this->end_date,$this->status),
            'status_code' => $this->statusCode($this->status,$this->end_date),
            'text' => trans('sponsorship.messages.text_tmp') ?? null, // TODO After Admin
        ];
    }
    protected function status($start_date,$end_date,$status)
    {
        if($status === 2) return trans('sponsorship.statuses.rejected');
        if(is_null($start_date)) return trans('sponsorship.statuses.pending');
        if(! $end_date->isPast()) return trans('sponsorship.statuses.working');
        if($end_date->isPast()) return trans('sponsorship.statuses.expired');
    }
    protected function statusCode($status,$end_date)
    {
        if($end_date)if($end_date->isPast()) return 3;
        return $status;
    }

}
