<?php


namespace Packages\PaymentsMethods\Providers\Eupago;


use App\Classes\Providers\ProviderInterface;
use Packages\PaymentsMethods\App\Models\PaymentProviders;
use Packages\PaymentsMethods\Providers\Customer;
use Packages\PaymentsMethods\Providers\Order;
use Packages\PaymentsMethods\Providers\PaymentInterface;

class EuPago implements PaymentInterface, ProviderInterface {

    public $order;
    public $customer;
    private $credencials;


    public function __construct()
    {
        $this->credencials = (new PaymentProviders())->getDataProvider(self::class);
    }

    public function generatePayment(Order $order, Customer $customer, $method)
    {
        $this->order = $order;
        $this->customer = $customer;
        if ($method == 'DB')
        {
            return $this->generateCC();
        }
        if ($method == 'PA-MBWAY')
        {
            return $this->generateMBWay();
        }
        if ($method == 'PA-MB')
        {
            return $this->generateReferenceMb();
        }
    }

    private function client()
    {
        try
        {
            return $client = new \SoapClient(config('eupago.end_point'), array('cache_wsdl' => WSDL_CACHE_NONE));
        } catch (\SoapFault $e)
        {
            die('Aconteceu um erro inesperado.');
        }
    }


    private function generateReferenceMb()
    {
        $result = $this->client()->gerarReferenciaMB(
           [
               'chave'=>$this->credencials['api_key'],
               'valor'=>$this->order->total(),
               'id'=>$this->order->getOrderId()
           ]
        );
        //Verifica erros na execução do serviço e exibe o resultado
        if (is_soap_fault($result)) {
            trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring:{$result->faultstring})", E_ERROR);
        }
        else {
            //estados possíveis: 0 sucesso. -10 Chave inválida. -9 Valores incorretos
            return (array) $result;
        }
    }


    private function generateCC()
    {
        $arraydados = array(
           'chave'=>$this->credencials['api_key'],
           'valor'=>$this->order->total(),
           'id'=>$this->order->getOrderId(),
           "url_retorno"=> env('APP_URL'),
            'comentario'=>$this->order->getDescription(),
            'url_logotipo'=>env('APP_URL').'/front/media/svgs/logo.svg',
            'lang'=>app()->getLocale(),
            'nome'=>$this->customer->getName(),
            'email'=>$this->customer->getEmail(),
            'tds'=>1

            );
        $result = $this->client()->pedidoCC($arraydados);

        return (array) $result;
    }

    private function generateMBWay()
    {
        $arraydados = array(
            'chave'=>$this->credencials['api_key'],
            'valor'=>$this->order->total(),
            'id'=>$this->order->getOrderId(),
            "alias"=>$this->customer->getPhone(),
        );
        $result = $this->client()->pedidoMBW($arraydados);
        return (array) $result;

    }

    public function avaliableMethods()
    {
        return ['DB'=>'Cartão de crédito', 'PA-MBWAY'=>'MBway', 'PA-MB'=>'Referência multibanco'];
    }

    public function authenticationData()
    {
        return ['api_key'=>'Chave api'];
    }

    public function transformDataClass()
    {
        return EuPagoDataTransform::class;
    }

    public function pathBladeHelp()
    {
        return 'payment_methods::cms.help.eupago';
    }
}
