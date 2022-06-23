<?php


namespace App\Classes\Ui\Constants;


class PaymentProviders extends ConstantAbstract
{
    public $routes = [
        'cms.payment_methods.providers.index',
        'cms.payment_methods.providers.create',
    ];

    public function data()
    {
        return [
            'cms.payment_methods.providers.index'=>[
                'title'=>Trans('payment_methods::cms.apis'),
            ],

            'cms.payment_methods.providers.create'=>[
                'title'=>Trans('payment_methods::cms.create_new_provider'),
                'back_link'=>[
                    'link'=>route('cms.payment_methods.providers.index'),
                    'text'=>Trans('payment_methods::cms.apis'),
                ]
            ]
        ];
    }
}
