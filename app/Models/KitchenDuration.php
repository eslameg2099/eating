<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenDuration extends Model
{
    use HasFactory;

    protected $fillable = [
      'kitchen_id',
      'start_date',
      'end_date',
      'cost',
      'status'
    ];
    protected $dates = ['start_date','end_date'];


    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
    public function KitchenSponsor(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KitchenSponsor::class,'kitchen_duration_id');
    }
    /**
     * Scope the query to include only unread messages.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnApproved($query)
    {
        return $query->whereNull('start_date');
    }

}
