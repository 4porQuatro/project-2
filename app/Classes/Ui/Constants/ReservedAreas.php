<?php


namespace App\Classes\Ui\Constants;


class ReservedAreas extends ConstantAbstract
{
    public $routes = [
        'cms.reserved_area.index',
        'cms.reserved_area.create',
        'cms.reserved_area.show',
        'cms.reserved_area.edit',
    ];

    public function data()
    {
        return [
            'cms.reserved_area.index'=>[
                'title'=>Trans('reserved::cms.list_reserved')
            ],

            'cms.reserved_area.create'=>[
                'title'=>Trans('reserved::cms.new_reserved_area')
            ],

            'cms.reserved_area.show'=>[
                'title'=>$this->getShowTitle()
            ],

            'cms.reserved_area.edit'=>[
                'title'=>Trans('reserved::cms.edit_reserved_area'),
                'back_link'=>[
                    'link'=>$this->showLink(),
                    'text'=>$this->getShowTitle(),
                ]
            ]
        ];
    }

    public function getReservedArea()
    {
        return request('reserved_area');
    }

    public function getShowTitle()
    {
        $reserved_area = $this->getReservedArea();
        if($reserved_area)
        {
            return Trans('reserved::cms.details_reserved_area').': '.$reserved_area->name;
        }
    }

    public function showLink()
    {
        $reserved_area = $this->getReservedArea();
        if($reserved_area)
        {
            return route('cms.reserved_area.show', ['reserved_area'=>$reserved_area->id]);
        }
    }
}

