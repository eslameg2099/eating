<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chef;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChefPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any chefs.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.chefs');
    }

    /**
     * Determine whether the user can view the chef.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function view(User $user, Chef $chef)
    {
        return $user->isAdmin()
            || $user->is($chef)
            || $user->hasPermissionTo('manage.chefs');
    }

    /**
     * Determine whether the user can create chefs.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.chefs');
    }

    /**
     * Determine whether the user can update the chef.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function update(User $user, Chef $chef)
    {
        return (
                $user->isAdmin()
                || $user->is($chef)
                || $user->hasPermissionTo('manage.chefs')
            )
            && ! $this->trashed($chef);
    }

    /**
     * Determine whether the user can update the type of the chef.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function updateType(User $user, Chef $chef)
    {
        return $user->isAdmin()
            && $user->isNot($chef)
            || $user->hasPermissionTo('manage.chefs');
    }

    /**
     * Determine whether the user can delete the chef.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function delete(User $user, Chef $chef)
    {
        return (
                $user->isAdmin()
                && $user->isNot($chef)
                || $user->hasPermissionTo('manage.chefs')
            )
            && ! $this->trashed($chef);
    }

    /**
     * Determine whether the user can view trashed chefs.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.chefs')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed chef.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function viewTrash(User $user, Chef $chef)
    {
        return $this->view($user, $chef) && $this->trashed($chef);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function restore(User $user, Chef $chef)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.chefs')
            )
            && $this->trashed($chef);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Chef $chef
     * @return mixed
     */
    public function forceDelete(User $user, Chef $chef)
    {
        return (
                $user->isAdmin()
                && $user->isNot($chef)
                || $user->hasPermissionTo('manage.chefs')
            )
            && $this->trashed($chef)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given chef is trashed.
     *
     * @param $chef
     * @return bool
     */
    public function trashed($chef)
    {
        return $this->hasSoftDeletes()
            && method_exists($chef, 'trashed')
            && $chef->trashed();
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
            array_keys((new \ReflectionClass(Chef::class))->getTraits())
        );
    }
}
