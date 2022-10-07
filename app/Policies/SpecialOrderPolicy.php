<?php


namespace App\Policies;

use App\Models\Meal;
use App\Models\Order;
use App\Models\SpecialOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialOrderPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.Orders');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Orders');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Orders');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function update(User $user, SpecialOrder $special_order)
    {
        $statuses = [
          SpecialOrder::CHEF_CANCEL,
          SpecialOrder::USER_CANCEL,
          SpecialOrder::ADMIN_CANCEL,
          SpecialOrder::FINISHED_STATUS
        ];
        return ($user->isAdmin() ) && ! $this->trashed($special_order) && ! in_array($special_order->status,$statuses);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function delete(User $user, SpecialOrder $special_order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && ! $this->trashed($special_order);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function reject(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
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
                || $user->hasPermissionTo('manage.Orders')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function viewTrash(User $user, SpecialOrder $special_order)
    {
        return $this->view($user, $special_order) && $this->trashed($special_order);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function restore(User $user, SpecialOrder $special_order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && $this->trashed($special_order);
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\SpecialOrder $special_order
     * @return mixed
     */
    public function forceDelete(User $user, SpecialOrder $special_order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && $this->trashed($special_order)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $special_order
     * @return bool
     */
    public function trashed($special_order)
    {
        return $this->hasSoftDeletes() && method_exists($special_order, 'trashed') && $special_order->trashed();
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
            array_keys((new \ReflectionClass(Meal::class))->getTraits())
        );
    }
}
