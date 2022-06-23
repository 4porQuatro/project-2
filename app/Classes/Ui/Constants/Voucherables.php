<?php

namespace App\Classes\Ui\Constants;

class Voucherables extends ConstantAbstract
{
    public $routes = [
        'cms.voucherables.index',
    ];

    public function data()
    {
        return [
            'cms.voucherables.index'=>[
                'title'=>Trans('voucher::cms.manage_voucherables'),
                'back_link'=>[
                    'link'=>route('cms.vouchers.index'),
                    'text'=>Trans('voucher::cms.vouchers_list'),
            ]
        ]];
    }
}
