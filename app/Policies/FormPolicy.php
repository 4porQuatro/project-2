<?php

namespace App\Policies;

use App\Models\Form;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
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
        return $user->hasPermission('form_index');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function view(User $user, Form $form)
    {
        return $user->hasPermission('form_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('form_store');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function update(User $user, Form $form)
    {
        return $user->hasPermission('form_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function delete(User $user, Form $form)
    {
        return $user->hasPermission('form_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function restore(User $user, Form $form)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  \App\Models\Form  $form
     * @return mixed
     */
    public function forceDelete(User $user, Form $form)
    {
        //
    }
}
