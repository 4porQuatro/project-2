<?php


namespace App\Classes\Ui\Constants;


class Attributes extends ConstantAbstract
{
    public $routes = [
        'cms.attributes.index',
        'cms.attributes.create',
        'cms.attributes.edit',
    ];

    public function data()
    {
        return [
            'cms.attributes.index'=>[
                'title'=>Trans('store::cms.attributes_list')
            ],

            'cms.attributes.create'=>[
                'title'=>Trans('store::cms.create_new_attribute'),
                'back_link'=>[
                    'link'=>route('cms.attributes.index'),
                    'text'=>Trans('store::cms.attributes_list')
                ]
            ],

            'cms.attributes.edit'=>[
                'title'=>Trans('store::cms.edit_attribute'),
                'back_link'=>[
                    'link'=>route('cms.attributes.index'),
                    'text'=>Trans('store::cms.attributes_list')
                ]
            ],
        ];
    }
}
