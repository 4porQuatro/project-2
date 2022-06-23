<?php

namespace Packages\Orders\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\App\Models\Order;
use Packages\PaymentsMethods\Providers\Eupago\EuPago;
use Packages\PaymentsMethods\Providers\Eupago\EuPagoPayload;
use Packages\PaymentsMethods\Providers\Stripe\StripePayload;

class PaymentPayloadController extends Controller {

    public $providers = [
        'stripe'=> StripePayload::class,
        'eupago'=>EuPagoPayload::class

    ];

    public function store(Request $request, $provider)
    {
        $provider = $this->providers[$provider];

        $result = (new $provider)->check();
        if(isset($result['success']) && $result['success'])
        {
            $order = Order::where($result['field'], $result['condition'], $result['data'])->first();
            $order->status = OrderStatus::AWAITING_SHIPPMENT;
            $order->save();

        }
    }

    public function get($provider)
    {

        $provider = $this->providers[$provider];

        $result = (new $provider)->check();
        if(isset($result['success']) && $result['success'])
        {
            $order = Order::where($result['field'], $result['condition'], $result['data'])->first();
            $order->status = OrderStatus::AWAITING_SHIPPMENT;
            $order->save();
        }
    }


}
