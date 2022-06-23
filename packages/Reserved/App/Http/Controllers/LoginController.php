<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Classes\Traits\LoginRedirectTrait;
use App\Http\Controllers\Controller;
use App\Rules\SlugRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Packages\Orders\App\Constants\CheckoutTypes;
use Packages\Orders\App\Models\Checkout;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;

class LoginController extends Controller
{
    use LoginRedirectTrait;

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::guard()->attempt($request->only('email', 'password'), $request->filled('remember')))
        {
            $request->session()->regenerate();

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->to($this->getRedirectPage($request->route()->getPrefix()));
        }
        else
        {
            return  $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->back()->withErrors([
                    'email' =>  [trans('auth.failed')],
                ]);
        }

    }

}
