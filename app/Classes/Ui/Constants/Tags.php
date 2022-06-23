<?php


namespace App\Classes\Ui\Constants;


class Tags extends ConstantAbstract
{
    public $routes = [
        'cms.tags.index',
        'cms.tags.edit',
    ];

    protected function data()
    {
        return [
            'cms.tags.index'=>[
                'title'=>Trans('cms.tags'),
            ],

            'cms.tags.edit'=>[
                'title'=>Trans('cms.tag_edit'),
                'back_link'=>[
                    'link'=>route('cms.tags.index'),
                    'text'=>Trans('cms.tags'),
                ]
            ]
        ];
    }
}
