<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_id',
        'kitchen_id',
        'rate',
        'reviewers',
    ];

    /**
     * Relations.
     */

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'kitchen_id');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Vote::class);
    }
}
