<?php


namespace App\Classes\Ui\Constants;


class Providers extends ConstantAbstract
{
    public $routes = [
        'cms.form.providers.index',
        'cms.form.providers.create',
    ];

    protected function data()
    {
        return [
            'cms.form.providers.index'=>[
                'title'=>Trans('cms.form_providers')
            ],

            'cms.form.providers.create'=>[
                'title'=>Trans('cms.create_new_provider'),
                'back_link'=>[
                    'link'=>route('cms.form.providers.index'),
                    'text'=>Trans('cms.form_providers')
                ],
            ]
        ];
    }
}
