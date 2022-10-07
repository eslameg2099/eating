<?php


namespace App\Policies;

use App\Models\Kitchen;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class KitchenPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchens');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function view(User $user, Kitchen $kitchen)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchens');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchens');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function update(User $user, Kitchen $kitchen)
    {

        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        return ($user->isAdmin() )&& ! $this->trashed($kitchen);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function delete(User $user, Kitchen $kitchen)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchens')
            )
            && ! $this->trashed($kitchen);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function reject(User $user, Kitchen $kitchen)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchens')
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
                || $user->hasPermissionTo('manage.kitchens')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function viewTrash(User $user, Kitchen $kitchen)
    {
        return $this->view($user, $kitchen) && $this->trashed($kitchen);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function restore(User $user, Kitchen $kitchen)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchens')
            )
            && $this->trashed($kitchen);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function accept(User $user, Kitchen $kitchen)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchens')
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Kitchen $kitchen
     * @return mixed
     */
    public function forceDelete(User $user, Kitchen $kitchen)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.kitchens')
            )
            && $this->trashed($kitchen)
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
            array_keys((new \ReflectionClass(Kitchen::class))->getTraits())
        );
    }
}
