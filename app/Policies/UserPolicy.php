<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any roles.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('user_index');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('user_show');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('user_store');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user, User $user_to_update)
    {
        return $user_to_update->isSuperUser() ? false : $user->hasPermission('user_update');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user, User $user_to_delete)
    {
        return $user_to_delete->isSuperUser() ? false : $user->hasPermission('user_destroy');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param User $user
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param User $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
