<?php


namespace App\Classes\Ui\Constants;


class ShippingMethods extends ConstantAbstract
{
    public $routes = [
        'cms.shipping_methods.index',
        'cms.shipping_methods.create',
        'cms.shipping_methods.edit',
    ];

    public function data()
    {
        return [
            'cms.shipping_methods.index'=>[
                'title'=>Trans('shipping_methods::cms.list')
            ],

            'cms.shipping_methods.create'=>[
                'title'=>Trans('shipping_methods::cms.create'),
                'back_link'=>[
                    'link'=>route('cms.shipping_methods.index'),
                    'text'=>Trans('shipping_methods::cms.list')
                ]
            ],

            'cms.shipping_methods.edit'=>[
                'title'=>Trans('shipping_methods::cms.edit'),
                'back_link'=>[
                    'link'=>route('cms.shipping_methods.index'),
                    'text'=>Trans('shipping_methods::cms.list')
                ]
            ]
        ];
    }
}
