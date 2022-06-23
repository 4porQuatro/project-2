<?php

namespace Packages\shipping_methods\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;

class ShippmentMethodsController extends Controller {

    public function get()
    {
        $zones = $this->getZones()->pluck('id')->toArray();

        $cart_instance = new Cart(session());

        $shipping_methods = ShippingMethod::getPricedForZonesAndCart($zones, $cart_instance);

        return $shipping_methods;

    }

    public function getZones()
    {
        $zones = collect([]);
        if (request()->has('country')) $zones = $zones->merge(Country::find(request()->get('country'))->zones()->get());

        if (request()->has('region')) $zones = $zones->merge(Region::find(request()->get('region'))->zones()->get());

        return $zones;
    }
}
