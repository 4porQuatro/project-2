<?php


namespace Packages\PaymentsMethods\Providers\Easypay;

use App\Classes\Providers\ProviderInterface;
use GuzzleHttp\Client;
use Packages\PaymentsMethods\App\Models\PaymentProviders;
use Packages\PaymentsMethods\Providers\Customer;
use Packages\PaymentsMethods\Providers\Order;
use Packages\PaymentsMethods\Providers\PaymentInterface;

class EasyPay implements PaymentInterface, ProviderInterface {

    private $order;
    private $customer;
    private $credencials;
    private $method;
    public $response;

    public function __construct()
    {
        $this->credencials = (new PaymentProviders())->getDataProvider(self::class);
    }

    public function generatePayment(Order $order, Customer $customer, $method)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->method = $method;
        $this->response = $this->client()->request('POST', 'single')->getBody()->getContents();
        return $this->response;
        //return 'Multibanco refs';
    }

    public function getResult()
    {

    }

    public function getDetails()
    {
        return [
            'type'=>['redirect', 'json'],
        ];
    }


    private function headersApi()
    {
        return $this->credencials;
    }

    private function client()
    {
        return new Client(['base_uri' => config('easypay.end_point'), 'headers' => $this->headersApi(), 'body'=>$this->body()]);

    }

    private function body()
    {
        $body = [
            "key" => env('APP_NAME'),
            "method" => $this->method,
            "type" => "sale",
            "value" => $this->order->total(),
            "currency" => "EUR",
            "expiration_time" => "",
            "customer" => $this->customer->getData(),
            "capture" =>  ["transaction_key" => $this->order->getOrderId(),
                "descriptive" => $this->order->getDescription(),
                "capture_date" => $this->order->getOrderDate()->toDateString(),
            ]
            ];

        return json_encode($body);
    }


    public function avaliableMethods()
    {
        return ["mb"=>'Referência multibanco', "cc"=>'Cartão de crédito', "mbw"=>'MBway'];
    }

    public function authenticationData()
    {
        return [
            'accountId'=>'Identificador da conta',
            'ApiKey'=>'Chave API',
        ];
    }

    public function transformDataClass()
    {
        return EasyPayDataTransform::class;
    }

    public function pathBladeHelp()
    {
        return 'payment_methods::cms.help.easypay';
    }
}
