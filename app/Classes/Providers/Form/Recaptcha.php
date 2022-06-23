<?php


namespace App\Classes\Providers\Form;


use App\Classes\Providers\ProviderInterface;

class Recaptcha implements ProviderInterface {

    public function authenticationData()
    {
        return ['public_key'=>'Chave pública', 'private_key'=>'Chave privada'];
    }

    public function pathBladeHelp()
    {
        return '';
    }
}
