<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Traits\LoginRedirectTrait;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Packages\Reserved\App\Models\ReservedArea;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;
    use LoginRedirectTrait;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectTo()
    {
        if(env('APP_RESERVED') && !empty(auth()->user()->reserved_area_id))
        {
            return $this->getRedirectPage(ReservedArea::find(auth()->user()->reserved_area_id)->prefix);
        }
        return '/';
    }
}
