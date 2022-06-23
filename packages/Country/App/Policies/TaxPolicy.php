<?php

namespace Packages\Country\App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Packages\Country\App\Models\Tax;

class TaxPolicy
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
        return $user->hasPermission('tax_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Tax\App\Models\Tax  $tax
     * @return mixed
     */
    public function view(User $user, Tax $tax)
    {
        return $user->hasPermission('tax_show');

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('tax_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Tax\App\Models\Tax  $tax
     * @return mixed
     */
    public function update(User $user, Tax $tax)
    {
        return $user->hasPermission('tax_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Tax\App\Models\Tax  $tax
     * @return mixed
     */
    public function delete(User $user, Tax $tax)
    {
        return $user->hasPermission('tax_destroy');

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Tax\App\Models\Tax  $tax
     * @return mixed
     */
    public function restore(User $user, Tax $tax)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Tax\App\Models\Tax  $tax
     * @return mixed
     */
    public function forceDelete(User $user, Tax $tax)
    {
        //
    }
}
