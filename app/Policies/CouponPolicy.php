<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any coupons.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.coupons');
    }

    /**
     * Determine whether the user can view the coupon.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function view(User $user, Coupon $coupon)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.coupons');
    }

    /**
     * Determine whether the user can create coupons.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.coupons');
    }

    /**
     * Determine whether the user can update the coupon.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function update(User $user, Coupon $coupon)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.coupons'))
            && ! $this->trashed($coupon);
    }

    /**
     * Determine whether the user can delete the coupon.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function delete(User $user, Coupon $coupon)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.coupons'))
            && ! $this->trashed($coupon);
    }

    /**
     * Determine whether the user can view trashed coupons.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.coupons'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed coupon.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function viewTrash(User $user, Coupon $coupon)
    {
        return $this->view($user, $coupon)
            && $coupon->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function restore(User $user, Coupon $coupon)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.coupons'))
            && $this->trashed($coupon);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Coupon $coupon
     * @return mixed
     */
    public function forceDelete(User $user, Coupon $coupon)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.coupons'))
            && $this->trashed($coupon)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given coupon is trashed.
     *
     * @param $coupon
     * @return bool
     */
    public function trashed($coupon)
    {
        return $this->hasSoftDeletes() && method_exists($coupon, 'trashed') && $coupon->trashed();
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
            array_keys((new \ReflectionClass(Coupon::class))->getTraits())
        );
    }
}
