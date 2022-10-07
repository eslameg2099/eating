<?php

namespace App\Notifications;

use App\Models\Notification as NotificationModel;
use App\Models\Order;
use App\Notifications\Channels\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserReceiveOrderNotification extends Notification
{
    use Queueable;

    private $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        return [
            'title'=> trans("notifications.titles.receive_order"),
            'body'=> trans("notifications.messages.receive_order",['user' => $this->order->customer->name , 'order_id' => $this->order->id]),
            'type'=> NotificationModel::ORDER_TYPE,
            'id'=> $this->order->id,
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
            "order_id" => $this->order->id,
            "user_id" => $this->order->user_id,
            "kitchen_id" => $this->order->kitchen_id,
            "type" => NotificationModel::ORDER_TYPE,
        ];
    }
}
