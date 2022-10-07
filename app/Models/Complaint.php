<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Object_;

class Complaint extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'special_order_id',
        'message'
        ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function order(){
        return $this->belongsTo(Order::Class,'order_id')->withTrashed();
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function special_order(){
        return $this->belongsTo(SpecialOrder::Class,'special_order_id');
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function user(){
        return $this->belongsTo(User::Class);
    }
}
