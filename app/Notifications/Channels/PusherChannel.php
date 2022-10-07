<?php

namespace App\Notifications\Channels;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;
use Pusher\PushNotifications\PushNotifications;

class PusherChannel
{
    /**
     * Send the given notification.
     *
     * @param $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toPusher')) {
            throw new \Exception('method "toPusher" not found in "'.get_class($notification).'"');
        }

        $data = $notification->toPusher($notifiable) + ['click_action' => 'com.delitechno.homez_chef'];

        $this->getPushNotifications($notifiable->type)
            ->publishToUsers($this->getInterests($notifiable, $notifiable), [
                // sayed
                "fcm" => [
                    //"notification" => $data,
                    "data" => $data,
                ],
                // abdelhamid
                "apns" => [
                    "aps" => [
                        "alert" => $data,
                        "sound" => 'default',
                    ],
                ],
            ]);
    }

    /**
     * Get the interests of the notification.
     *
     * @param $notifiable
     * @param $notification
     * @return \Illuminate\Support\Collection|mixed|string[]
     */
    protected function getInterests($notifiable, $notification)
    {
        $interests = collect(Arr::wrap($notifiable->routeNotificationFor('PusherNotification')))
            ->map(function ($interest) {
                return (string) $interest;
            })->toArray();

        return method_exists($notification, 'pusherInterests')
            ? $notification->pusherInterests($notifiable)
            : ($interests ?: ["{$notifiable->id}"]);
    }

    /**
     * Create PushNotification instance.
     *
     * @throws \Exception
     * @return \Pusher\PushNotifications\PushNotifications
     */
    protected function getPushNotifications($type): PushNotifications
    {
        $config = config('services.pusher');
        switch ($type)
        {
            case User::CUSTOMER_TYPE:
                return new PushNotifications([
                    'instanceId' => $config['user_beams_instance_id'],
                    'secretKey' => $config['user_beams_secret_key'],
                ]);

            case User::CHEF_TYPE:
                return new PushNotifications([
                    'instanceId' => $config['chef_beams_instance_id'],
                    'secretKey' => $config['chef_beams_secret_key'],
                ]);

        }

    }
}
