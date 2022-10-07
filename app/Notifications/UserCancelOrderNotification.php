<?php

namespace App\Notifications;

use App\Models\Customer;
use App\Models\Notification as NotificationModel;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Channels\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCancelOrderNotification extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
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
     * Get the pusher representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPusher($notifiable)
    {
        if ($this->order->type === User::CHEF_TYPE) {
            $name = $this->order->kitchen->user->name;
        }else {
            $name = $this->order->customer->name;
        }
        return [
            'title'=> trans("notifications.titles.cancel_order"),
            'body'=> trans("notifications.messages.order-cancel",['user' => $name , 'order_id' => $this->order->id]),
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
