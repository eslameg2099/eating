<?php


namespace App\Policies;

use App\Models\Kitchen;
use App\Models\KitchenSponsor;
use App\Models\SponsorDurations;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SponsorDurationsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any kitchen.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.SponsorDurations');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function view(User $user, SponsorDurations $sponsorDurations)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.SponsorDurations');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.SponsorDurations');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function update(User $user, SponsorDurations $sponsorDurations)
    {

        return $user->isAdmin() || $user->hasPermissionTo('manage.SponsorDurations');

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function delete(User $user, SponsorDurations $sponsorDurations)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations')
            )
            && ! $this->trashed($sponsorDurations);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function reject(User $user, SponsorDurations $sponsorDurations)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations')
            );
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function viewTrash(User $user, SponsorDurations $sponsorDurations)
    {
        return $this->view($user, $sponsorDurations) && $this->trashed($sponsorDurations);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function restore(User $user, SponsorDurations $sponsorDurations)
    {
        return ($user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations'))

            && $this->trashed($sponsorDurations);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function accept(User $user, SponsorDurations $sponsorDurations)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations')
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SponsorDurations $sponsorDurations
     * @return mixed
     */
    public function forceDelete(User $user, SponsorDurations $sponsorDurations)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.SponsorDurations')
            )
            && $this->trashed($sponsorDurations)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $sponsorDurations
     * @return bool
     */
    public function trashed($sponsorDurations)
    {
        return $this->hasSoftDeletes() && method_exists($sponsorDurations, 'trashed') && $sponsorDurations->trashed();
    }

    /**
     * Determine wither the model use soft deleting trait.
     *
     * @return bool
     */
    public function hasSoftDeletes()
    {
        return in_array(
            SoftDeletes::class,
            array_keys((new \ReflectionClass(SponsorDurations::class))->getTraits())
        );
    }
}
