<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\RoomFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    use Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'sender_id',
        'receiver_id',
        'last_message_id',
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = RoomFilter::class;

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function last_message()
    {
        return $this->hasOne(Chat::class)->latest();
    }

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function messages()
    {
        return $this->hasMany(Chat::class)->latest();
    }

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select('id', 'name', 'type');
    }

    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->select('id', 'name', 'type');
    }

    /*
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
//    public function last_messages()
//    {
//        return $this->hasMany(Chat::class,'receiver_id');
//    }
}
