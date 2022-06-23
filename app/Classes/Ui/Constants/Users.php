<?php


namespace App\Classes\Ui\Constants;


class Users extends ConstantAbstract
{
    public $routes = [
        'cms.roles.index',
        'cms.roles.create',
        'cms.roles.edit',
        'cms.users.index',
        'cms.users.create',
        'cms.users.edit',
    ];

    public function data()
    {
        $data = [
            'cms.roles.index'=>[
                'title'=>Trans('cms.users_types'),
            ],
            'cms.roles.create'=>[
                'title'=>Trans('cms.create_new_user_type'),
                'back_link'=>[
                    'link'=>route('cms.roles.index'),
                    'text'=>Trans('cms.users_types'),
                ],
            ],
            'cms.roles.edit'=>[
                'title'=>Trans('cms.type_data'),
                'back_link'=>[
                    'link'=>route('cms.roles.index'),
                    'text'=>Trans('cms.users_types'),
                ],
            ],
            'cms.users.index'=>[
                'title'=>Trans('cms.users_list'),
            ],

            'cms.users.create'=>[
                'title'=>Trans('cms.new_user'),
                'back_link'=>[
                    'link'=>route('cms.users.index'),
                    'text'=>Trans('cms.users_list'),
                ],
            ],
            'cms.users.edit'=>[
                'title'=>Trans('cms.user_data'),
                'back_link'=>[
                    'link'=>route('cms.users.index'),
                    'text'=>Trans('cms.users_list'),
                ],
            ]
        ];

        return $data;
    }
}
