<?php

use \Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order.{id}', function ($order, $id) {
    return (int) $order->id === (int) $id;
});
Broadcast::channel('SpecialOrder.{id}', function ($specialOrder, $id) {
    return (int) $specialOrder->id === (int) $id;
});


Broadcast::channel('room.{roomId}', function ($user, $roomId) {
   // $room = //
    return [
        'id' => $user->id,
        'name' => $user->full_name,
    ];
    return ChatRoom::findOrNew($roomId)->roomMembers()->where('member_id', $user->id)->exists();
});

