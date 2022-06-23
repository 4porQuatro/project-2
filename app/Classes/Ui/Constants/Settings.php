<?php


namespace App\Classes\Ui\Constants;


class Settings extends ConstantAbstract
{
    public $routes = [
        'cms.settings.langs.index',
        'cms.settings.langs.create',
        'cms.settings.scripts.index',
    ];

    public function data()
    {
        $data = [
            'cms.settings.langs.index'=>[
                'title'=>Trans('cms.active_languages'),
            ],
            'cms.settings.langs.create'=>[
                'title'=>Trans('cms.add_new_language'),
                'back_link'=>[
                    'link'=>route('cms.settings.langs.index'),
                    'text'=>Trans('cms.active_languages')
                ]
            ],
            'cms.settings.scripts.index'=>[
                'title'=>Trans('cms.global_scripts'),
            ]
        ];

        return $data;
    }
}
