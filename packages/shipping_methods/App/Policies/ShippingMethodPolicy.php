<?php

namespace Packages\shipping_methods\App\Policies;

use Packages\shipping_methods\App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingMethodPolicy
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
        return $user->hasPermission('shipping_method_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\shipping_methods\App\Models\ShippingMethod  $shipping_method
     * @return mixed
     */
    public function view(User $user, ShippingMethod $shipping_method)
    {
        return $user->hasPermission('shipping_method_index');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('shipping_method_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\shipping_methods\App\Models\ShippingMethod  $shipping_method
     * @return mixed
     */
    public function update(User $user, ShippingMethod $shipping_method)
    {
        return $user->hasPermission('shipping_method_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\shipping_methods\App\Models\ShippingMethod  $shipping_method
     * @return mixed
     */
    public function delete(User $user, ShippingMethod $shipping_method)
    {
        return $user->hasPermission('shipping_method_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\shipping_methods\App\Models\ShippingMethod  $shipping_method
     * @return mixed
     */
    public function restore(User $user, ShippingMethod $shipping_method)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\shipping_methods\App\Models\ShippingMethod  $shipping_method
     * @return mixed
     */
    public function forceDelete(User $user, ShippingMethod $shipping_method)
    {
        //
    }
}
