<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    /**
     * $table->id();

    $table->foreignId("user_id");
    $table->foreignId("order_id");
    $table->text("message");

    $table->timestamp("read_at")->nullable();
    $table->timestamps();
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "message" => $this->message,
            "user" => new MiniUserResource($this->user),
            "order" => new miniOrderResource($this->order) ,
            "special_order" => new SpecialOrderResource($this->special_order) ,
        ];
    }
}
