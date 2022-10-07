<?php

namespace App\Http\Resources;

use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorDurationResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "duration" => $this->duration,
            "duration_type" => $this->type($this->duration_type),
            "cost" => new Price($this->cost),
//            "currency" => $this->currency,
        ];
    }
    protected function type($type)
    {
        switch ($type){
            case 'year':
                return trans('sponsorship.duration_type.year');
            case 'month':
                return trans('sponsorship.duration_type.month');
            case 'day':
                return trans('sponsorship.duration_type.day');
            default:
                return '';
        }
    }
}
