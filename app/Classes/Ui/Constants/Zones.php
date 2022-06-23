<?php


namespace App\Classes\Ui\Constants;


class Zones extends ConstantAbstract
{
    public $routes = [
        'cms.zones.index',
        'cms.zones.create',
        'cms.zones.edit',
    ];

    public function data()
    {
        return [
            'cms.zones.index'=>[
                'title'=>Trans('country::cms.list_zones'),
            ],

            'cms.zones.create'=>[
                'title'=>Trans('country::cms.create_zone'),
                'back_link'=>[
                    'link'=>route('cms.zones.index'),
                    'text'=>Trans('country::cms.list_zones'),
                ]
            ],

            'cms.zones.edit'=>[
                'title'=>Trans('country::cms.edit_zone'),
                'back_link'=>[
                    'link'=>route('cms.zones.index'),
                    'text'=>Trans('country::cms.list_zones'),
                ]
            ]
        ];
    }
}
