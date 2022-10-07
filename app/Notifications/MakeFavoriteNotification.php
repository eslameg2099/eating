<?php
# Using Bootstrap 3


namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MakeFavoriteNotification extends Notification
{
    use Queueable;

    private $favorite;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($favorite)
    {
        $this->favorite = $favorite;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

}
