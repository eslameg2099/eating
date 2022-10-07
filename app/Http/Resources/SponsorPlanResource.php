<?php

namespace App\Http\Resources;

use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorPlanResource extends JsonResource
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
            "id"=> $this->id,
            "kitchen_id"=> $this->kitchen_id,
            'avatar' => $this->getFirstMediaUrl(),
            "title" => $this->sponsor_duration->title,
            'cost' => new Price($this->sponsor_duration->cost),
            "sponsor_duration_id"=> $this->sponsor_duration_id,
            "start_date"=> date("Y-m-d", strtotime($this->start_date)),
            "end_date"=> date("Y-m-d", strtotime($this->end_date)),
            "is_accepted"=> !! $this->accepted,
            "created_at"=> $this->created_at->diffForHumans(),
            "stopped"=> !! $this->deleted_at,
            'status' => $this->status($this->start_date,$this->end_date,$this->accepted),
            'status_code' => $this->statusCode($this->accepted,$this->end_date),
            'text' => trans('sponsorship.messages.text_tmp')
        ];
    }
    protected function status($start_date,$end_date,$status){
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
