<?php

namespace Packages\Orders\App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Packages\Orders\App\Models\Checkout;

class CheckoutPolicy
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
        return $user->hasPermission('checkout_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Order\App\Models\  $checkout
     * @return mixed
     */
    public function view(User $user, Checkout $checkout = null)
    {
        return $user->hasPermission('checkout_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('checkout_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Order\App\Models\  $checkout
     * @return mixed
     */
    public function update(User $user, Checkout $checkout = null)
    {
        return $user->hasPermission('checkout_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Order\App\Models\  $checkout
     * @return mixed
     */
    public function delete(User $user, Checkout $checkout = null)
    {
        return $user->hasPermission('checkout_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param \Packages\Order\App\Models\  $checkout
     * @return mixed
     */
    public function restore(User $user, Checkout $checkout)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\Order\App\Models\  $checkout
     * @return mixed
     */
    public function forceDelete(User $user, Checkout $checkout)
    {
        //
    }
}
