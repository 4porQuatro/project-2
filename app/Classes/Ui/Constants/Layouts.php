<?php


namespace App\Classes\Ui\Constants;


class Layouts extends ConstantAbstract
{
    public $routes = [
        'cms.layouts.index',
        'cms.layouts.create',
        'cms.layouts.edit',
    ];

    public function data()
    {
        $data = [
            'cms.layouts.index'=>[
                'title'=>Trans('cms.layouts_list'),
            ],
            'cms.layouts.create'=>[
                'title'=>Trans('cms.create_new_layout'),
                'back_link'=>[
                    'link'=>route('cms.layouts.index'),
                    'text'=>Trans('cms.layouts_list')
                ],
            ],

            'cms.layouts.edit'=>[
                'title'=>Trans('cms.layout_data'),
                'back_link'=>[
                    'link'=>route('cms.layouts.index'),
                    'text'=>Trans('cms.layouts_list')
                ],
            ]
        ];

        return $data;
    }
}
