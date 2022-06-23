<?php


namespace App\Classes\Traits;


use Packages\Orders\App\Constants\CheckoutTypes;
use Packages\Orders\App\Models\Checkout;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;

trait LoginRedirectTrait {

    private function getReservedArea($prefix)
    {
        return ReservedArea::where('prefix', $prefix)->first();
    }
    private function checkIfCheckoutNormalExists($prefix)
    {
        return Checkout::where('reserved_area_id', $this->getReservedArea($prefix)->id)->where('type', CheckoutTypes::NORMAL)->exists();
    }

    private function getNormalCheckout($prefix)
    {
        return Checkout::where('reserved_area_id', $this->getReservedArea($prefix)->id)->where('type', CheckoutTypes::NORMAL)->first();
    }

    public function getRedirectPage($prefix)
    {
        if(
            env('APP_STORE') && $this->checkCart() && $this->checkIfCheckoutNormalExists($prefix)

        )
        {
             return route('checkout.show', ['checkout'=>$this->getNormalCheckout($prefix)->id]);
        }

        return env('APP_URL').'/'.$prefix;
    }

    private function checkCart()
    {
        return (boolean) count((new Cart(session()))->getContent());
    }

}
