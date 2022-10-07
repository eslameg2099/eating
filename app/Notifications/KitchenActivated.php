<?php

namespace App\Notifications;

use App\Models\Notification as NotificationModel;
use App\Notifications\Channels\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KitchenActivated extends Notification
{
    use Queueable;
    private $kitchen;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($kitchen)
    {
        $this->kitchen = $kitchen;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', PusherChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        return [
            'title'=> trans("notifications.titles.order"),
            'body'=> trans("notifications.messages.activation",['kitchen' => $this->kitchen->name]),
            'type'=> NotificationModel::ACTIVATION_TYPE,
            'id'=> $this->kitchen->id,
            'notification_id' => $this->id,
        ];
    }
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->kitchen->user_id,
            "kitchen_id" => $this->kitchen->id,
            "type" => NotificationModel::ACTIVATION_TYPE,
        ];
    }
}
