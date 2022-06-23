<?php


namespace App\Classes\Ui\Constants;


class Orders extends ConstantAbstract
{
    public $routes = [
        'cms.order.index',
        'cms.order.show',
        'cms.provider.invoice.index',
        'cms.provider.invoice.create'
    ];

    public function data()
    {
        return [
            'cms.order.index'=>[
                'title'=>Trans('order::cms.order_list')
            ],

            'cms.order.show'=>[
                'title'=>Trans('order::cms.order_details'),
                'back_link'=>[
                    'link'=>route('cms.order.index'),
                    'text'=>Trans('order::cms.order_list')
                ]
            ],

            'cms.provider.invoice.index'=>[
                'title'=>trans('order::cms.provider_invoice')
            ],
            'cms.provider.invoice.create'=>[
                'title'=>Trans('order::cms.provider_invoice_create'),
                'back_link'=>[
                    'link'=>route('cms.provider.invoice.index'),
                    'text'=>Trans('order::cms.provider_invoice')
                ]
            ],
        ];
    }
}
