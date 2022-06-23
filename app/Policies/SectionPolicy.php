<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
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
        return $user->hasPermission('section_index');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function view(User $user, Section $section)
    {
        return $user->hasPermission('section_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('section_store');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function update(User $user, Section $section)
    {
        return $user->hasPermission('section_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function delete(User $user, Section $section)
    {
        return $user->hasPermission('section_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function restore(User $user, Section $section)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param  \App\Models\Section  $section
     * @return mixed
     */
    public function forceDelete(User $user, Section $section)
    {
        //
    }
}
