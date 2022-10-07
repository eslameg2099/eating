<?php


namespace App\Policies;

use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
     * @param \App\Models\Order $order
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
     * @param \App\Models\Order $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {

        //return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        $status_array = [
          Order::DELIVERED_STATUS,
          Order::CUSTOMER_CANCEL,
          Order::CHEF_CANCEL,
          Order::ADMIN_CANCEL,
        ];
        return ($user->isAdmin() ) && ! $this->trashed($order) && ! in_array($order->status, $status_array);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Order $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && ! $this->trashed($order);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Order $order
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
     * @param \App\Models\Order $order
     * @return mixed
     */
    public function viewTrash(User $user, Order $order)
    {
        return $this->view($user, $order) && $this->trashed($order);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Order $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && $this->trashed($order);
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Order $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Orders')
            )
            && $this->trashed($order)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $order
     * @return bool
     */
    public function trashed($order)
    {
        return $this->hasSoftDeletes() && method_exists($order, 'trashed') && $order->trashed();
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
