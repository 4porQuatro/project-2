<?php


namespace App\Classes\Ui\Constants;


class Menus extends ConstantAbstract
{
    public $routes = [
        'cms.menus.index',
        'cms.menus.create',
        'cms.menus.edit',
        'cms.menu-items.index',
        'cms.menu-items.create',
        'cms.menu-items.edit',
    ];

    public function data()
    {
        $data = [
            'cms.menus.index'=>[
                'title'=>Trans('cms.menus_list'),
            ],

            'cms.menus.create'=>[
                'title'=>Trans('cms.create_new_menu'),
                'back_link'=>[
                    'link'=>route('cms.menus.index'),
                    'text'=>Trans('cms.menus_list'),
                ],
            ],

            'cms.menus.edit'=>[
                'title'=>Trans('cms.menu_data'),
                'back_link'=>[
                    'link'=>route('cms.menus.index'),
                    'text'=>Trans('cms.menus_list'),
                ],
            ],

            'cms.menu-items.index'=>[
                'title'=>$this->menuItemsIndexTitle(),
                'back_link'=>[
                    'link'=>route('cms.menus.index'),
                    'text'=>Trans('cms.menus_list'),
                ],
            ],

            'cms.menu-items.create'=>[
                'title'=>self::menuItemsCreateTitle(),
                'back_link'=>[
                    'link'=>$this->menuItemsIndexLink(),
                    'text'=>$this->menuItemsIndexTitle(),
                ],
            ],

            'cms.menu-items.edit'=>[
                'title'=>self::menuItemsEditTitle(),
                'back_link'=>[
                    'link'=>$this->menuItemsIndexLink(),
                    'text'=>$this->menuItemsIndexTitle(),
                ],
            ]
        ];

        return $data;
    }

    public function getMenu()
    {
        return request('menu');
    }

    public function menuItemsIndexTitle()
    {
        $menu = self::getMenu();

        if($menu)
        {
            return Trans('cms.menu_items_list').': '.$menu->name;
        }

        return '';
    }


    public function menuItemsIndexLink()
    {
        $menu = self::getMenu();
        if($menu) {
            return route('cms.menu-items.index', ['menu' => $menu->id]);
        }

        return '';
    }

    public function menuItemsCreateTitle()
    {
        $menu = self::getMenu();
        if($menu) {
            return Trans('cms.create_item_for_menu') . ': ' . $menu->name;
        }

        return '';
    }

    public function menuItemsEditTitle()
    {
        $menu = self::getMenu();
        if($menu){
            return Trans('cms.edit_item_for_menu').': '.$menu->name;
        }

        return '';
    }
}
