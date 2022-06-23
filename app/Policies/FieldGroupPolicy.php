<?php

namespace App\Policies;

use App\Models\FieldGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldGroupPolicy
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
        return $user->hasPermission('field_group_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FieldGroup  $fieldGroup
     * @return mixed
     */
    public function view(User $user, FieldGroup $fieldGroup)
    {
        return $user->hasPermission('field_group_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('field_group_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FieldGroup  $fieldGroup
     * @return mixed
     */
    public function update(User $user, FieldGroup $fieldGroup)
    {
        return $user->hasPermission('field_group_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FieldGroup  $fieldGroup
     * @return mixed
     */
    public function delete(User $user, FieldGroup $fieldGroup)
    {
        return $user->hasPermission('field_group_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FieldGroup  $fieldGroup
     * @return mixed
     */
    public function restore(User $user, FieldGroup $fieldGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FieldGroup  $fieldGroup
     * @return mixed
     */
    public function forceDelete(User $user, FieldGroup $fieldGroup)
    {
        //
    }
}
