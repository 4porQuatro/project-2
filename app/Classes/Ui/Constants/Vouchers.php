<?php

namespace App\Classes\Ui\Constants;

class Vouchers extends ConstantAbstract
{
    public $routes = [
        'cms.vouchers.index',
        'cms.vouchers.create',
        'cms.vouchers.edit',
    ];

    public function data()
    {
        return [
            'cms.vouchers.index'=>[
                'title'=>Trans('voucher::cms.vouchers_list'),
            ],

            'cms.vouchers.create'=>[
                'title'=>Trans('voucher::cms.voucher_create'),
                'back_link'=>[
                    'link'=>route('cms.vouchers.index'),
                    'text'=>Trans('voucher::cms.vouchers_list'),
                ]
            ],

            'cms.vouchers.edit'=>[
                'title'=>Trans('voucher::cms.voucher_edit'),
                'back_link'=>[
                    'link'=>route('cms.vouchers.index'),
                    'text'=>Trans('voucher::cms.vouchers_list'),
                ]
            ]
        ];
    }
}
