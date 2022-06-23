<?php

namespace App\Policies;

use App\Models\Field;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
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
        return $user->hasPermission('field_index');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\Field  $field
     * @return mixed
     */
    public function view(User $user, Field $field)
    {
        return $user->hasPermission('field_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('field_store');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\Field  $field
     * @return mixed
     */
    public function update(User $user, Field $field)
    {
        return $user->hasPermission('field_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\Field  $field
     * @return mixed
     */
    public function delete(User $user, Field $field)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  \App\Models\Field  $field
     * @return mixed
     */
    public function restore(User $user, Field $field)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  \App\Models\Field  $field
     * @return mixed
     */
    public function forceDelete(User $user, Field $field)
    {
        //
    }
}
