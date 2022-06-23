<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Traits\LoginRedirectTrait;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Packages\Reserved\App\Models\ReservedArea;

class ResetPasswordController extends Controller
{
    use LoginRedirectTrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';


    public function redirectTo()
    {
        if(env('APP_RESERVED') && !empty(auth()->user()->reserved_area_id))
        {
            return $this->getRedirectPage(ReservedArea::find(auth()->user()->reserved_area_id)->prefix);
        }
        return '/';
    }
}
