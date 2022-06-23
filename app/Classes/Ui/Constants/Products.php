<?php


namespace App\Classes\Ui\Constants;


class Products extends ConstantAbstract
{
    public $routes = [
        'cms.products.index',
        'cms.products.create',
        'cms.products.edit',
    ];

    public function data()
    {
        return [
            'cms.products.index'=>[
                'title'=>Trans('store::cms.products_list'),
            ],

            'cms.products.create'=>[
                'title'=>Trans('store::cms.create_new_product'),
                'back_link'=>[
                    'link'=>route('cms.products.index'),
                    'text'=>Trans('store::cms.products_list'),
                ]
            ],

            'cms.products.edit'=>[
                'title'=>Trans('store::cms.edit_product'),
                'back_link'=>[
                    'link'=>route('cms.products.index'),
                    'text'=>Trans('store::cms.products_list'),
                ]
            ]
        ];
    }
}
