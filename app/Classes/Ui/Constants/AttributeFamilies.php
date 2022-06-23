<?php


namespace App\Classes\Ui\Constants;


class AttributeFamilies extends ConstantAbstract
{
    public $routes = [
        'cms.attribute-families.index',
        'cms.attribute-families.create',
        'cms.attribute-families.edit',
    ];

    public function data()
    {
        return [
            'cms.attribute-families.index'=>[
                'title'=>Trans('store::cms.attribute_families_list')
            ],

            'cms.attribute-families.create'=>[
                'title'=>Trans('store::cms.create_new_attribute_family'),
                'back_link'=>[
                    'link'=>route('cms.attribute-families.index'),
                    'text'=>Trans('store::cms.attribute_families_list')
                ]
            ],

            'cms.attribute-families.edit'=>[
                'title'=>Trans('store::cms.edit_attribute_family'),
                'back_link'=>[
                    'link'=>route('cms.attribute-families.index'),
                    'text'=>Trans('store::cms.attribute_families_list')
                ]
            ]
        ];
    }
}
