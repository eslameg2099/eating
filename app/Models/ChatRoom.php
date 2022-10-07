<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{

    /**
     * The code of the support room type.
     */
    const PRIVATE_ROOM = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'special_order_id',
        'type',
    ];

    protected $with = [
        'lastMessage',
        'roomMembers.member',
    ];

    /**
     * Get all the members of the chat room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roomMembers()
    {
        return $this->hasMany(ChatRoomMembers::class, 'room_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastMessage()
    {
        return $this->hasOne(ChatRoomMessage::class, 'room_id')->latest('id');
    }

    /**
     * Get all the messages of the chat room.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(ChatRoomMessage::class, 'room_id');
    }

    public function getOtherMembers()
    {
        return $this->roomMembers->where('member_id', '!=', auth()->id());
    }
    /**
     * A message belong to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialOrder()
    {
        return $this->belongsTo(SpecialOrder::class,'special_order_id');
    }
    public function getOtherMember()
    {
        $roomMember = $this->roomMembers()->where('member_id', '!=', auth()->id())->whereHas('member', function ($query) {
            $query->where('type', '!=', User::ADMIN_TYPE);
        })->first();

        if ($roomMember) {
            return $roomMember->member;
        }
    }
}
