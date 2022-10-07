<?php

namespace App\Models\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Pusher\Pusher;

trait UserHelpers
{
    /**
     * Determine whether the user type is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type == User::ADMIN_TYPE;
    }

    /**
     * Determine whether the user type is chef.
     *
     * @return bool
     */
    public function isChef()
    {
        return $this->type == User::SUPERVISOR_TYPE;
    }

    /**
     * Determine whether the user type is customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->type == User::CUSTOMER_TYPE;
    }

    /**
     * Set the user type.
     *
     * @return $this
     */
    public function setType($type)
    {
        if (Gate::allows('updateType', $this)
            && in_array($type, array_keys(trans('users.types')))) {
            $this->forceFill([
                'type' => $type,
            ])->save();
        }

        return $this;
    }

    /**
     * Determine whether the user can access dashboard.
     *
     * @return bool
     */
    public function canAccessDashboard()
    {
        return $this->isAdmin() || $this->isChef();
    }

    /**
     * The user profile image url.
     *
     * @return bool
     */
    public function getAvatar()
    {
        return $this->getFirstMediaUrl('avatars');
    }

    /**
     * The user profile image url.
     *
     * @param string $channelName
     * @return bool
     * @throws \Pusher\PusherException
     */
    public function subscribedTo(string $channelName): bool
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        $response = $pusher->get("/channels/presence-{$channelName}/users");

        $users = [];

        if ($response && $response['status'] == 200) {
            $users = array_map(function ($user) {
                return $user->id;
            }, json_decode($response['body'])->users);
        }

        return in_array($this->getKey(), $users);
    }
}
