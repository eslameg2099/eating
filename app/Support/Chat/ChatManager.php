<?php

namespace App\Support\Chat;

use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use App\Support\Chat\Events\MessageRead;
use App\Support\Chat\Events\MessageSent;
use App\Support\Chat\Events\RoomAdded;
use App\Support\Chat\Contracts\ChatMember;
use App\Support\Chat\Exceptions\InvalidMemberType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ChatManager
{
    /**
     * The instance of authenticated user.
     *
     * @var \App\Models\User
     */
    protected $user;

    protected $groupTypeCode = 'group';

    protected $privateTypeCode = 'private';

    /**
     * Create user instance.
     */
    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getRooms()
    {
        return ChatRoom::whereHas('roomMembers', function ($query) {
            $query->where('member_id', $this->user->id);
        });

    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function getContacts()
    {
        return User::query()
            ->where('id', '!=', $this->user->id)
            ->whereDoesntHave('roomsMember.room', function (Builder $builder) {
                $builder->whereHas('roomMembers', function ($query) {
                    $query->where('member_id', $this->user->id);
                });
            })
            ->simplePaginate();
    }

    /**
     * @param iterable|\App\Support\Chat\Contracts\ChatMember $members
     * @param mixed $type
     * @param array $data
     * @throws \Exception
     * @return \App\Models\ChatRoom
     */
    public function getRoomWith($member, $type = null, $special_order_id ,$data = [])
    {
//        $member = $this->qualifyMembers($member);
        $type = $type ?: $this->guessTheRoomType($member);
        $room = ChatRoom::where("special_order_id",$special_order_id)->first();
        //$room = ChatRoom::where('type',$this->privateTypeCode)
        //    ->has('roomMembers')
        //    ->where($data)
        //    ->where(function (Builder $builder) use ($member) {
        //        $builder->whereHas('roomMembers', function ($query) use ($member) {
        //            $query->where('member_id', $member->id);
        //        });
        //    })
        //    ->first();

        return $room ?: $this->addRoom($member, $type, $special_order_id , $data);
    }

    protected function addRoom($member, $type = null, $special_order_id , $data = [])
    {
        $data['type'] = $this->privateTypeCode;
        $data['special_order_id'] = $special_order_id;
        $room = ChatRoom::create($data);
        //$room->roomMembers()->create([
        //    'member_id' => $member->id,
        //]);
        $members = collect([auth()->user(),$member]);
        $members->each(function ($member) use ($room) {
            $room->roomMembers()->create([
                'member_id' => $member->id,
            ]);
        });

        event(new RoomAdded($room));

        return $room;
    }

    /**
     * @param iterable $members
     * @throws \Exception
     * @return mixed
     */
    protected function guessTheRoomType(iterable $members)
    {
        return is_array($members) > 2 ? $this->groupTypeCode : $this->privateTypeCode;
    }

    /**
     * Ensure that the given members are valid.
     *
     * @param iterable|ChatMember $members
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function qualifyMembers($members): iterable
    {
        $members = Collection::make(Arr::wrap($members))->prepend($this->user);

        foreach ($members as $member) {
            if (! $member instanceof ChatMember) {
                throw new InvalidMemberType;
            }
        }

        return $members;
    }

    /**
     * @return \App\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function sendMessage(ChatRoom $room, $message = '', $file = null)
    {
        $chatMessage = $room->messages()->create([
            'sender_id' => $this->getUser()->id,
            'message' => $message,
        ]);

        if ($file) {
            $chatMessage->addMedia($file)->toMediaCollection();
        }

        broadcast(new MessageSent($chatMessage))->toOthers();
        $this->markAsRead($room, $chatMessage);

        return $chatMessage->refresh();
    }

    public function markAsRead(ChatRoom $room, ChatRoomMessage $chatRoomMessage = null)
    {
        $currentMember = $room->roomMembers->where('member_id', $this->user->id)->first();

        $message = $chatRoomMessage ?: $room->lastMessage;

        if (! $message || ! $currentMember) {
            return $this;
        }
        if ($currentMember->last_read_message_id == $message->id) {
            return $this;
        }

        $currentMember->forceFill([
            'last_read_message_id' => $message->id,
            'read_at' => now(),
        ])->save();

        broadcast(new MessageRead($message))->toOthers();

        return $this;
    }
}
