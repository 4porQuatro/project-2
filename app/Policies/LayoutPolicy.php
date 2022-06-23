<?php

namespace App\Policies;

use App\Models\Layout;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutPolicy
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
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('layout_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function view(User $user, Layout $layout)
    {
        return $user->hasPermission('layout_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('layout_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function update(User $user, Layout $layout)
    {
        return $user->hasPermission('layout_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function delete(User $user, Layout $layout)
    {
        return $user->hasPermission('layout_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function restore(User $user, Layout $layout)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Layout  $layout
     * @return mixed
     */
    public function forceDelete(User $user, Layout $layout)
    {
        //
    }
}
