<?php

namespace App\Http\Controllers\Api;

use App\Models\Chat;
use App\Models\Room;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatsResource;
use App\Http\Requests\Api\SendMessage;
use App\Http\Resources\MessagesResource;

class ChatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $rooms = Room::where('receiver_id', auth()->user()['id'])->orWhere('sender_id', auth()->user()['id'])->filter()->get();
        $rooms = $rooms->load('last_message', 'receiver', 'sender');

        return ChatsResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return MessagesResource
     */
    public function store(SendMessage $request)
    {
        $input = $request->validated();
        $auth_id = auth()->user()['id'];
        $room = Room::whereIn('receiver_id', [$input['receiver_id'], $auth_id])->whereIn('sender_id', [$input['receiver_id'], $auth_id])->first();
        if (is_null($room)) {
            $room = Room::create(['receiver_id' => $input['receiver_id'], 'sender_id' =>$auth_id]);
        }
        $input['room_id'] = $room['id'];
        $chat = Chat::create($input);
        if (! is_null($chat)) {
            $room->update(['last_message_id' => $chat['id'] ]) ;
        }
        event(new SendMessageEvent($chat));

        return new MessagesResource($chat);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ChatsResource
     */
    public function show(Room $room)
    {
        $chats = $room->load('messages', 'receiver', 'sender');

        return new ChatsResource($chats);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
