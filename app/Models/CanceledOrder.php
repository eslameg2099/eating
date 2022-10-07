<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanceledOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "model_type",
        "model_id",
        "order_id",
        "type"
    ];

    public $timestamps;
    /**
     * Relations.
     * @return object
     */
    public function cancelable()
    {
        return $this->morphTo();
    }
}
