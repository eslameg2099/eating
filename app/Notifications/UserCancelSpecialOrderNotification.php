<?php

namespace App\Notifications;

use App\Models\Notification as NotificationModel;
use App\Notifications\Channels\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCancelSpecialOrderNotification extends Notification
{
    use Queueable;

    private $special_order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($special_order)
    {
        $this->special_order = $special_order;
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
        if ($this->special_order->type === 'chef') {
            $name = $this->special_order->kitchen->user->name;
        }else {
            $name = $this->special_order->customer->name;
        }
        return [
            'title'=> trans("notifications.titles.cancel_order"),
            'body'=> trans("notifications.messages.order-cancel",['user' => $name , 'order_id' => $this->special_order->id]),
            'type'=> NotificationModel::SPECIALORDER_TYPE,
            'id'=> $this->special_order->id,
            'notification_id' => $this->id,
        ];
    }
    public function toArray($notifiable)
    {
        return [
            'special_order_id' => $this->special_order->id,
            'user_id' => $this->special_order->user_id,
            "kitchen_id" => $this->special_order->kitchen_id,
            "type" => NotificationModel::SPECIALORDER_TYPE,
        ];
    }
}
