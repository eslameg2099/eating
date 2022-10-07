<?php

namespace App\Http\Resources;

use App\Models\Wallet;
use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            "user" => new MiniUserResource($this->user),
            "transaction" =>new Price($this->transaction),
            "title" => trans("wallets.messages.transaction") . abs($this->transaction)  . ' '.trans("wallets.currency"),
            "type" => ($this->transaction >= 0) ? 1 : 0,
            "readable_type" => ($this->transaction > 0 ) ? trans("wallets.deposit") : trans("wallets.withdrew"),
//            "confirmed" => $this->confirmed ? true : false ,
            "created_at" => $this->created_at->toDateTimeString(),
            "created_at_form" => $this->created_at->diffForHumans(),
            "updated_at" => $this->updated_at->toDateTimeString(),
            "updated_at_form" => $this->updated_at->diffForHumans(),
            "balance" => new Price(auth()->user()->getBalance())
        ];
    }
}
