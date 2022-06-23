<?php

namespace Packages\PaymentsMethods\App\Policies;

use App\Models\User;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
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
        return $user->hasPermission('payment_methods_index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\PaymentsMethods\App\Models\  $payment_methods
     * @return mixed
     */
    public function view(User $user, PaymentMethod $payment_methods = null)
    {
        return $user->hasPermission('payment_methods_show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->hasPermission('payment_methods_store');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\PaymentsMethods\App\Models\  $payment_methods
     * @return mixed
     */
    public function update(User $user, \Packages\PaymentsMethods\App\Models\PaymentMethod $payment_methods = null)
    {
        return $user->hasPermission('payment_methods_update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\PaymentsMethods\App\Models\  $payment_methods
     * @return mixed
     */
    public function delete(User $user, \Packages\PaymentsMethods\App\Models\PaymentMethod $payment_methods = null)
    {
        return $user->hasPermission('payment_methods_destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param \Packages\PaymentsMethods\App\Models\  $payment_methods
     * @return mixed
     */
    public function restore(User $user, \Packages\PaymentsMethods\App\Models\PaymentMethod $payment_methods)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Packages\PaymentsMethods\App\Models\  $payment_methods
     * @return mixed
     */
    public function forceDelete(User $user, \Packages\PaymentsMethods\App\Models\PaymentMethod $payment_methods)
    {
        //
    }
}
