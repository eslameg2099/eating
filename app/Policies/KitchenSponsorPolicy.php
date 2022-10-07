<?php


namespace App\Policies;

use App\Models\Kitchen;
use App\Models\KitchenSponsor;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class KitchenSponsorPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchenSponsor');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function view(User $user, KitchenSponsor $kitchenSponsor)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchenSponsor');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchenSponsor');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function update(User $user, KitchenSponsor $kitchenSponsor)
    {

        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        return ($user->isAdmin() )&& ! $this->trashed($kitchenSponsor);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function delete(User $user, KitchenSponsor $kitchenSponsor)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchenSponsor')
            )
            && ! $this->trashed($kitchenSponsor);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function reject(User $user, KitchenSponsor $kitchenSponsor)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchenSponsor')
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
                || $user->hasPermissionTo('manage.kitchenSponsor')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function viewTrash(User $user, KitchenSponsor $kitchenSponsor)
    {
        return $this->view($user, $kitchenSponsor) && $this->trashed($kitchenSponsor);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function restore(User $user, KitchenSponsor $kitchenSponsor)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchenSponsor')
            )
            && $this->trashed($kitchenSponsor);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function accept(User $user, KitchenSponsor $kitchenSponsor)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchenSponsor')
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\KitchenSponsor $kitchenSponsor
     * @return mixed
     */
    public function forceDelete(User $user, KitchenSponsor $kitchenSponsor)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchenSponsor')
            )
            && $this->trashed($kitchenSponsor)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $kitchen
     * @return bool
     */
    public function trashed($kitchen)
    {
        return $this->hasSoftDeletes() && method_exists($kitchen, 'trashed') && $kitchen->trashed();
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
            array_keys((new \ReflectionClass(KitchenSponsor::class))->getTraits())
        );
    }
}
