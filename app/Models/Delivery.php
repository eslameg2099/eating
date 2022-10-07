<?php

namespace App\Models;

use App\Http\Filters\DeliveryFilter;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = [
        'order_id',
        'delivery_company_id',
        'status',
        'message',
        'cost'
    ];
    protected $filter = DeliveryFilter::class;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function delivery_company()
    {
        return $this->belongsTo(DeliveryCompany::class);
    }
}
