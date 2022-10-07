<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessageResource;
use App\Http\Resources\Chat\RoomResource;
use App\Http\Resources\Chat\UserResource;
use App\Models\ChatRoom;
use App\Models\Room;
use App\Models\SpecialOrder;
use App\Models\User;
use App\Support\Chat\ChatManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChatController extends Controller
{
    protected $chat;

    public function __construct(ChatManager $chatManager)
    {
        $this->chat = $chatManager;
    }

    public function rooms(Request $request)
    {
        $this->chat->setUser(auth()->user());
        $rooms = $this->chat->getRooms();
        if(isset($request->today)) if($request->today) $rooms->whereDate('updated_at', Carbon::today());
        return RoomResource::collection(
            $rooms->latest('updated_at')->simplePaginate()
        );
    }
    public function getRoom(ChatRoom $room)
    {
        $this->chat->setUser(auth()->user());

        $this->chat->markAsRead($room);

        return $this->getRoomMessages($room);
    }
    public function getRoomBySpecialOrder($specialOrderID)
    {
        $special_order = SpecialOrder::findOrFail($specialOrderID);
        if (auth()->user()->type == 'customer') $user = $special_order->kitchen->user;
        if (auth()->user()->type == 'chef') $user = $special_order->customer;
        $room = $this->chat->setUser(auth()->user())->getRoomWith($user, ChatRoom::PRIVATE_ROOM , $special_order->id);
        $this->chat->markAsRead($room);

        return $this->getRoomMessages($room);
    }
    public function getRoomMessages(ChatRoom $room)
    {
        return MessageResource::collection(
            $room->refresh()->messages()->latest()->simplePaginate()
        )->additional([
            'room' => new RoomResource($room),
        ]);
    }

    public function sendMessage(Request $request, ChatRoom $room)
    {
        $request->validate([
            'message' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $message = $this->chat->setUser(auth()->user())
            ->sendMessage($room, $request->input('message'), $request->file('image'));

        return new MessageResource($message);
    }

    
    public function getUnreadRooms()
    {
        $unreadRooms =  auth()->user()->roomsMember()
            ->whereHas('room.lastMessage', function (Builder $builder) {
               $builder->whereColumn('last_read_message_id', '<', 'chat_room_messages.id');
            })->count();

        return response()->json([
            'unread_rooms' => $unreadRooms,
        ]);
    }
}
