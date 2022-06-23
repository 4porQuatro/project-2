<?php


namespace Packages\PaymentsMethods\App\Models;


use App\Classes\Providers\Provider;
use App\Models\Setting;
use Packages\PaymentsMethods\Providers\Easypay\EasyPay;
use Packages\PaymentsMethods\Providers\Eupago\EuPago;
use Packages\PaymentsMethods\Providers\Stripe\Stripe;

class PaymentProviders extends Provider{

    public $avaliable_providers = [
        EasyPay::class => 'EasyPay',
        EuPago::class => 'EuPago',
        Stripe::class =>'Stripe'
    ];

    public $setting_name = 'payment_methods';


    public function getSettingName()
    {
        return $this->setting_name;
    }

    public function getAvaliableProviders()
    {
       return $this->avaliable_providers;
    }
}
