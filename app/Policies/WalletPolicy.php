<?php


namespace App\Policies;

use App\Models\Kitchen;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.wallets');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.wallets');
    }

    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.wallets');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function update(User $user, Wallet $wallet)
    {

        return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        return ($user->isAdmin() )&& ! $this->trashed($wallet);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function delete(User $user, Wallet $wallet)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.wallets')
            )
            && ! $this->trashed($wallet);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function reject(User $user, Wallet $wallet)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.wallets')
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
                || $user->hasPermissionTo('manage.wallets')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function viewTrash(User $user, Wallet $wallet)
    {
        return $this->view($user, $wallet) && $this->trashed($wallet);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function restore(User $user, Wallet $wallet)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.wallets')
            )
            && $this->trashed($wallet);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function accept(User $user, Wallet $wallet)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.wallets')
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wallet $wallet
     * @return mixed
     */
    public function forceDelete(User $user, Wallet $wallet)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.wallets')
            )
            && $this->trashed($wallet)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $wallet
     * @return bool
     */
    public function trashed($wallet)
    {
        return $this->hasSoftDeletes() && method_exists($wallet, 'trashed') && $wallet->trashed();
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
            array_keys((new \ReflectionClass(Wallet::class))->getTraits())
        );
    }
}
