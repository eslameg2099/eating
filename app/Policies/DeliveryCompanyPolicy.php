<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryCompany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryCompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any delivery companies.
     *
     * @param \App\Models\User|null $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies');
    }

    /**
     * Determine whether the user can view the delivery company.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function view(User $user, DeliveryCompany $delivery_company)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies');
    }

    /**
     * Determine whether the user can create delivery companies.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies');
    }

    /**
     * Determine whether the user can update the delivery company.
     *
     * @param \App\Models\User $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function update(User $user, DeliveryCompany $delivery_company)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies'))
            && ! $this->trashed($delivery_company);
    }

    /**
     * Determine whether the user can delete the delivery company.
     *
     * @param \App\Models\User $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function delete(User $user, DeliveryCompany $delivery_company)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies'))
            && ! $this->trashed($delivery_company);
    }

    /**
     * Determine whether the user can view trashed delivery_companies.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAnyTrash(User $user)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies'))
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view the trashed delivery_company.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function viewTrash(User $user, DeliveryCompany $delivery_company)
    {
        return $this->view($user, $delivery_company)
            && $delivery_company->trashed();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function restore(User $user, DeliveryCompany $delivery_company)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies'))
            && $this->trashed($delivery_company);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\DeliveryCompany $delivery_company
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryCompany $delivery_company)
    {
        return ($user->isAdmin() || $user->hasPermissionTo('manage.delivery_companies'))
            && $this->trashed($delivery_company)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given delivery_company is trashed.
     *
     * @param $delivery_company
     * @return bool
     */
    public function trashed($delivery_company)
    {
        return $this->hasSoftDeletes() && method_exists($delivery_company, 'trashed') && $delivery_company->trashed();
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
            array_keys((new \ReflectionClass(DeliveryCompany::class))->getTraits())
        );
    }
}
