<?php

namespace App\Notifications;

use App\Models\Chef;
use App\Models\Vote;
use App\Notifications\Channels\PusherChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Notification as NotificationModel;
use Illuminate\Notifications\Messages\MailMessage;

class MakeReviewNotification extends Notification
{
    use Queueable;

    private $vote;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vote)
    {
        $this->vote = $vote;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
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
        return [
            'title'=> trans("notifications.titles.vote"),
            'body'=> trans("notifications.messages.vote"),
            'type'=> NotificationModel::VOTE_TYPE,
            'id'=> $this->vote->id,
            'notification_id' => $this->id,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return array_filter( [
            "vote_id" => $this->vote->id,
            "user_id" => $this->vote->user_id,
            "kitchen_id" => $this->vote->kitchen_id,
            "meal_id" => $this->vote->meal_id ,
            "special_order_id" => $this->vote->special_order_id ?? null,
            "rate" => $this->vote->rate,
            "type" => NotificationModel::VOTE_TYPE,
        ]);
    }
}
