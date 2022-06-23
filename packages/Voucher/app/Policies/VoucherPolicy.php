<?php

namespace Packages\Voucher\app\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Packages\Voucher\app\Models\Voucher;

class VoucherPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('voucher_index');
    }

    public function store(User $user)
    {
        return $user->hasPermission('voucher_store');
    }

    public function update(User $user, Voucher $voucher)
    {
        return $user->hasPermission('voucher_update');
    }

    public function delete(User $user, Voucher $voucher)
    {
        return $user->hasPermission('voucher_destroy');
    }

}
