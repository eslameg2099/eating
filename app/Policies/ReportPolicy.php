<?php


namespace App\Policies;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.Reports');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Reports');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Reports');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {

        //return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        $status_array = [
          Order::DELIVERED_STATUS,
          Order::CUSTOMER_CANCEL,
          Order::CHEF_CANCEL,
          Order::ADMIN_CANCEL,
        ];
        return ($user->isAdmin() ) && ! $this->trashed($report) && ! in_array($report->status, $status_array);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Reports')
            )
            && ! $this->trashed($report);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function reject(User $user)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Reports')
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
                || $user->hasPermissionTo('manage.Reports')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function viewTrash(User $user, Report $report)
    {
        return $this->view($user, $report) && $this->trashed($report);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Reports')
            )
            && $this->trashed($report);
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Report $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Reports')
            )
            && $this->trashed($report)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $report
     * @return bool
     */
    public function trashed($report)
    {
        return $this->hasSoftDeletes() && method_exists($report, 'trashed') && $report->trashed();
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
            array_keys((new \ReflectionClass(Report::class))->getTraits())
        );
    }
}
