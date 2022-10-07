<?php


namespace App\Policies;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laraeast\LaravelSettings\Facades\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class MealPolicy
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
        return $user->isAdmin() || $user->hasPermissionTo('manage.Meals');
    }

    /**
     * Determine whether the user can view the kitchen.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function view(User $user, Meal $meal)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Meals');
    }


    /**
     * Determine whether the user can create kitchen.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->hasPermissionTo('manage.Meals');
    }

    /**
     * Determine whether the user can update the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function update(User $user, Meal $meal)
    {

        //return $user->isAdmin() || $user->hasPermissionTo('manage.kitchen');
        return ($user->isAdmin() ) && ! $this->trashed($meal);

    }

    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function delete(User $user, Meal $meal)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Meals')
            )
            && ! $this->trashed($meal);
    }
    /**
     * Determine whether the user can delete the kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function reject(User $user, Meal $meal)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Meals')
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
                || $user->hasPermissionTo('manage.Meals')
            )
            && $this->hasSoftDeletes();
    }

    /**
     * Determine whether the user can view trashed kitchen.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function viewTrash(User $user, Meal $meal)
    {
        return $this->view($user, $meal) && $this->trashed($meal);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function restore(User $user, Meal $meal)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Meals')
            )
            && $this->trashed($meal);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function accept(User $user, Meal $meal)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Meals')
            );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Meal $meal
     * @return mixed
     */
    public function forceDelete(User $user, Meal $meal)
    {
        return (
                $user->isAdmin()
                || $user->hasPermissionTo('manage.Meals')
            )
            && $this->trashed($meal)
            && Settings::get('delete_forever');
    }

    /**
     * Determine wither the given kitchen is trashed.
     *
     * @param $meal
     * @return bool
     */
    public function trashed($meal)
    {
        return $this->hasSoftDeletes() && method_exists($meal, 'trashed') && $meal->trashed();
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
