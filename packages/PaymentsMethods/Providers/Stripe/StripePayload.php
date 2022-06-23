<?php

namespace Packages\PaymentsMethods\Providers\Stripe;

use Illuminate\Support\Facades\Log;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\App\Models\Order;
use Packages\PaymentsMethods\App\Models\PaymentProviders;
use Stripe\Event;

class StripePayload {

    public function __construct()
    {
        $this->credencials = (new PaymentProviders())->getDataProvider(Stripe::class);
        \Stripe\Stripe::setApiKey($this->credencials['api_key']);
        Log::debug("Passed construtor!");
    }

    public function check()
    {
        //$this->validation();

        $payload = @file_get_contents('php://input');

        try {
            $event = Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object->id; // contains a \Stripe\PaymentIntent

                return ['success'=>true,'field'=>'provider_payment_data', 'condition'=>'LIKE', 'data'=>'%'.$paymentIntent.'%'];

                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                break;
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);

    }


    public function validation()
    {
        //criar
        $endpoint_secret = 'whsec_fcf89591e1aef8a331a6b0c326b9a8d90d90248bc241e7bc6f30a18d1e2846ac';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        Log::debug("Passed signature verification!");
        http_response_code(200);
    }
}
