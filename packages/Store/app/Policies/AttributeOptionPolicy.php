<?php

namespace Packages\Store\app\Policies;

use Packages\Store\app\Models\AttributeOption;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeOptionPolicy
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
        return $user->hasPermission('attribute_option_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttributeOption  $attributeOption
     * @return mixed
     */
    public function view(User $user, AttributeOption $attributeOption)
    {
        return $user->hasPermission('attribute_option_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('attribute_option_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttributeOption  $attributeOption
     * @return mixed
     */
    public function update(User $user, AttributeOption $attributeOption)
    {
        return $user->hasPermission('attribute_option_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttributeOption  $attributeOption
     * @return mixed
     */
    public function delete(User $user, AttributeOption $attributeOption)
    {
        return $user->hasPermission('attribute_option_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttributeOption  $attributeOption
     * @return mixed
     */
    public function restore(User $user, AttributeOption $attributeOption)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttributeOption  $attributeOption
     * @return mixed
     */
    public function forceDelete(User $user, AttributeOption $attributeOption)
    {
        //
    }
}
