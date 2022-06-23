<?php

namespace App\Policies;

use App\Models\ModelSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelSettingPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ModelSetting  $modelSetting
     * @return mixed
     */
    public function view(User $user, ModelSetting $modelSetting = null)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ModelSetting  $modelSetting
     * @return mixed
     */
    public function update(User $user, ModelSetting $modelSetting = null)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ModelSetting  $modelSetting
     * @return mixed
     */
    public function delete(User $user, ModelSetting $modelSetting)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ModelSetting  $modelSetting
     * @return mixed
     */
    public function restore(User $user, ModelSetting $modelSetting)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ModelSetting  $modelSetting
     * @return mixed
     */
    public function forceDelete(User $user, ModelSetting $modelSetting)
    {
        //
    }
}
