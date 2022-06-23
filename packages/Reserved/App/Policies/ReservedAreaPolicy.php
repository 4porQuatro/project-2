<?php

namespace Packages\Reserved\App\Policies;

use App\Models\User;
use Packages\Reserved\App\Models\ReservedArea;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservedAreaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('reserved_area_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Reserved\App\Models\  $reserved_area
     * @return mixed
     */
    public function view(User $user, ReservedArea $reserved_area = null)
    {
        return $user->hasPermission('reserved_area_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('reserved_area_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Reserved\App\Models\  $reserved_area
     * @return mixed
     */
    public function update(User $user, ReservedArea $reserved_area = null)
    {
        return $user->hasPermission('reserved_area_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Reserved\App\Models\  $reserved_area
     * @return mixed
     */
    public function delete(User $user, ReservedArea $reserved_area = null)
    {
        return $user->hasPermission('reserved_area_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param \Packages\Reserved\App\Models\  $reserved_area
     * @return mixed
     */
    public function restore(User $user, ReservedArea $reserved_area)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Reserved\App\Models\  $reserved_area
     * @return mixed
     */
    public function forceDelete(User $user, ReservedArea $reserved_area)
    {
        //
    }
}
