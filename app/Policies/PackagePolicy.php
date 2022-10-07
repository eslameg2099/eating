<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any packages.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.packages');
    }

    /**
     * Determine whether the user can view the package.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function view(User $user, Package $package)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.packages');
    }

    /**
     * Determine whether the user can create packages.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.packages');
    }

    /**
     * Determine whether the user can update the package.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function update(User $user, Package $package)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.packages'))
            && ! $this->trashed($package);
    }

    /**
     * Determine whether the user can delete the package.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function delete(User $user, Package $package)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.packages'))
            && ! $this->trashed($package);
    }

    /**
     * Determine whether the user can view trashed packages.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.packages'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed package.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function viewTrash(User $user, Package $package)
    {
        return $this->view($user, $package)
            && $package->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function restore(User $user, Package $package)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.packages'))
            && $this->trashed($package);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function forceDelete(User $user, Package $package)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.packages'))
            && $this->trashed($package)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given package is trashed.
     *
     * @param $package
     * @return bool
     */
    public function trashed($package)
    {
        return $this->hasSoftDeletes() && method_exists($package, 'trashed') && $package->trashed();
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
            array_keys((new \ReflectionClass(Package::class))->getTraits())
        );
    }
}
