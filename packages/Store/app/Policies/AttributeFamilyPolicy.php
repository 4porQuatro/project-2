<?php

namespace Packages\Store\app\Policies;

use Packages\Store\app\Models\AttributeFamily;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributeFamilyPolicy
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
        return $user->hasPermission('attribute_family_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Store\app\Models\AttributeFamily  $attributeFamily
     * @return mixed
     */
    public function view(User $user, AttributeFamily $attributeFamily)
    {
        return $user->hasPermission('attribute_family_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('attribute_family_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Store\app\Models\AttributeFamily  $attributeFamily
     * @return mixed
     */
    public function update(User $user, AttributeFamily $attributeFamily)
    {
        return $user->hasPermission('attribute_family_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Store\app\Models\AttributeFamily  $attributeFamily
     * @return mixed
     */
    public function delete(User $user, AttributeFamily $attributeFamily)
    {
        return $user->hasPermission('attribute_family_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Store\app\Models\AttributeFamily  $attributeFamily
     * @return mixed
     */
    public function restore(User $user, AttributeFamily $attributeFamily)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Store\app\Models\AttributeFamily  $attributeFamily
     * @return mixed
     */
    public function forceDelete(User $user, AttributeFamily $attributeFamily)
    {
        //
    }
}
