<?php

namespace App\Policies;

use App\Models\Component;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('component_index');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\Component  $component
     * @return mixed
     */
    public function view(User $user, Component $component)
    {
        return $user->hasPermission('component_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('component_store');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\Component  $component
     * @return mixed
     */
    public function update(User $user, Component $component)
    {
        return $user->hasPermission('component_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\Component  $component
     * @return mixed
     */
    public function delete(User $user, Component $component)
    {
        return $user->hasPermission('component_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  \App\Models\Component  $component
     * @return mixed
     */
    public function restore(User $user, Component $component)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  \App\Models\Component  $component
     * @return mixed
     */
    public function forceDelete(User $user, Component $component)
    {
        //
    }
}
