<?php

namespace Packages\Voucher\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Voucher\app\Http\Requests\VoucherRequest;
use Packages\Voucher\app\Models\Voucher;

class VouchersController extends Controller {

    public function store(VoucherRequest $request)
    {
        session()->put('voucher_code', $request->code);
        return response(__('voucher::app.voucher_sucess'));
    }

    public function get()
    {
        $cart = new Cart(session());
        $voucher = Voucher::where('code', session()->get('voucher_code'))->first();
        $total_discount = $voucher->getOrderDiscount($cart->getContent());

        return ['total_discount'=>$total_discount];

    }

}
