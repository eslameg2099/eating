<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'room_id',
        'receiver_id',
        'message',
    ];

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function user()
//    {
//        return $this->belongsTo(User::class,'receiver_id')->where('users.id','!=',auth()->user()['id']);
//        return $this->belongsTo(User::class,'receiver_id')->where('users.id','!=',auth()->user()['id']);
//    }

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->where('users.id', '!=', auth()->user()->id);
    }
}
