<?php


namespace App\Classes\Ui\Constants;


class PaymentMethods extends ConstantAbstract
{
    public $routes = [
        'cms.payment_methods.index',
        'cms.payment_methods.create',
        'cms.payment_methods.edit',
    ];

    public function data()
    {
        return [
            'cms.payment_methods.index'=>[
                'title'=>Trans('payment_methods::cms.list_payment_methods')
            ],

            'cms.payment_methods.create'=>[
                'title'=>Trans('payment_methods::cms.create_new_payment_method'),
                'back_link'=>[
                    'link'=>route('cms.payment_methods.index'),
                    'text'=>Trans('payment_methods::cms.list_payment_methods')
                ]
            ],

            'cms.payment_methods.edit'=>[
                'title'=>Trans('payment_methods::cms.edit_payment_method'),
                'back_link'=>[
                    'link'=>route('cms.payment_methods.index'),
                    'text'=>Trans('payment_methods::cms.list_payment_methods')
                ]
            ],
        ];
    }
}
