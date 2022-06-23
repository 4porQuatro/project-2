<?php


namespace App\Classes\Ui\Constants;


class Checkouts extends ConstantAbstract
{
    public $routes = [
        'cms.checkout.index',
        'cms.checkout.create',
        'cms.checkout.edit',
    ];

    public function data()
    {
        return[
            'cms.checkout.index'=>[
                'title'=>Trans('order::cms.list_checkout')
            ],

            'cms.checkout.create'=>[
                'title'=>Trans('order::cms.create_new_checkout'),
                'back_link'=>[
                    'link'=>route('cms.checkout.index'),
                    'text'=>Trans('order::cms.list_checkout')
                ]
            ],

            'cms.checkout.edit'=>[
                'title'=>Trans('order::cms.checkout_edit'),
                'back_link'=>[
                    'link'=>route('cms.checkout.index'),
                    'text'=>Trans('order::cms.list_checkout')
                ]
            ]
        ];
    }
}
