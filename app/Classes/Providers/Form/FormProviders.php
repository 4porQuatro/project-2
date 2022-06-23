<?php


namespace App\Classes\Providers\Form;


use App\Classes\Providers\Provider;
use App\Models\Setting;
use Packages\PaymentsMethods\Providers\EasyPay\EasyPay;
use Packages\PaymentsMethods\Providers\EuPago\EuPago;
use Packages\PaymentsMethods\Providers\Stripe\Stripe;

class FormProviders extends Provider {

    public $avaliable_providers = [
        Recaptcha::class => 'Recaptcha V3',
    ];

    public $setting_name = 'form_providers';


    public function getSettingName()
    {
        return $this->setting_name;

    }

    public function getAvaliableProviders()
    {
        return $this->avaliable_providers;
    }
}
