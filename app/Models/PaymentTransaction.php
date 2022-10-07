<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    =   'payments_transactions';
    protected $guarded  =   ['id'];

    ### Status ###
    const Pending   =   1;
    const Rejected  =   2;
    const Succeeded =   2;


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
}
