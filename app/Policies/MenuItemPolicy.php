<?php

namespace App\Policies;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuItemPolicy
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
        return $user->hasPermission('menu_item_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuItem  $menuItem
     * @return mixed
     */
    public function view(User $user, MenuItem $menuItem)
    {
        return $user->hasPermission('menu_item_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('menu_item_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuItem  $menuItem
     * @return mixed
     */
    public function update(User $user, MenuItem $menuItem)
    {
        return $user->hasPermission('menu_item_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuItem  $menuItem
     * @return mixed
     */
    public function delete(User $user, MenuItem $menuItem)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuItem  $menuItem
     * @return mixed
     */
    public function restore(User $user, MenuItem $menuItem)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuItem  $menuItem
     * @return mixed
     */
    public function forceDelete(User $user, MenuItem $menuItem)
    {
        //
    }
}
