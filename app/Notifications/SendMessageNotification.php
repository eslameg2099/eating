<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\ChatRoomMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Channels\PusherChannel;
use App\Models\Notification as NotificationModel;
use Illuminate\Notifications\Messages\MailMessage;

class SendMessageNotification extends Notification
{
    use Queueable;

    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ChatRoomMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [PusherChannel::class];
    }

    /**
     * Get the pusher representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        return [
            'title'=> trans("notifications.titles.new_message", ['sender' => $this->message->sender->name]),
            'body'=> trans("notifications.messages.new_message_body", ['message' => $this->message->message]),
            'type'=> NotificationModel::CHAT_TYPE,
            'id'=> $this->message->room->id,
            'notification_id' => $this->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "order_id" => $this->message->room->order->id,
            "user_id" => $this->message->room->roomMembers->member_id,
            "kitchen_id" => $this->message->room->order->kitchen_id,
            "type" => NotificationModel::CHAT_TYPE,
        ];
    }
}
