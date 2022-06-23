<?php


namespace Packages\PaymentsMethods\Providers\Stripe;


use Packages\PaymentsMethods\Providers\PaymentDataTransform;

class StripeDataTransform implements PaymentDataTransform {

    public function getData($data_received, $method, $total)
    {
        if(!empty($data_received) && !empty(json_decode($data_received, true)))
            return ['url'=>json_decode($data_received, true)['url'], 'method'=>'card_stripe', 'identifier'=>json_decode($data_received, true)['payment_intent']];
        return [];
    }
}
