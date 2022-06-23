<?php


namespace Packages\PaymentsMethods\Providers\Stripe;


use App\Classes\Providers\ProviderInterface;
use Packages\PaymentsMethods\App\Models\PaymentProviders;
use Packages\PaymentsMethods\Providers\Customer;
use Packages\PaymentsMethods\Providers\Order;
use Packages\PaymentsMethods\Providers\PaymentInterface;

class Stripe implements PaymentInterface, ProviderInterface {

    public function __construct()
    {
        $this->credencials = (new PaymentProviders())->getDataProvider(self::class);
    }

    public function generatePayment(Order $order, Customer $customer, $method)
    {
        \Stripe\Stripe::setApiKey($this->credencials['api_key']);
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Your order in '.env('APP_NAME'),
                    ],
                    'unit_amount' => $order->total()*100,
                ],
                'quantity' => 1,
            ]],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => route('payment.show', ['order_uuid'=>$order->order_uuid,'status'=>'success']),
            'cancel_url' => route('payment.show', ['order_uuid'=>$order->order_uuid ,'status'=>'error']),
        ]);

        return ['url'=>$checkout_session->url, 'payment_intent'=>$checkout_session->payment_intent];

    }

    public function avaliableMethods()
    {
        return [
            'card'=>'Cartão de crédito'
        ];
    }

    public function authenticationData()
    {
        return ['api_key'=>'Chave api'];
    }

    public function transformDataClass()
    {
        return StripeDataTransform::class;
    }

    public function pathBladeHelp()
    {
        return 'payment_methods::cms.help.stripe';
    }
}
