<?php


namespace App\Classes\Ui\Constants;


class Tokens extends ConstantAbstract
{
    public $routes = [
        'cms.api_tokens.index'
    ];


    protected function data()
    {
        return [
            'cms.api_tokens.index'=>[
                'title'=>Trans('cms.list_tokens')
            ]
        ];
    }
}
