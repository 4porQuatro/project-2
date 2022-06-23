<?php


namespace App\Classes\Ui\Constants;


class Zoneables extends ConstantAbstract
{
    public $routes = [
        'cms.zoneables.index',
        'cms.zoneables.edit',
    ];

    public function data()
    {
        return [
            'cms.zoneables.index'=>[
                'title'=>$this->indexTitle(),
                'back_link'=>[
                    'link'=>route('cms.zones.index'),
                    'text'=>Trans('country::cms.list_zones'),
                ]
            ],

            'cms.zoneables.edit'=>[
                'title'=>$this->editTitle(),
                'back_link'=>[
                    'link'=>$this->getIndexLink(),
                    'text'=>Trans('country::cms.list_countries'),
                ]
            ]
        ];
    }

    public function getZone()
    {
        return request('zone');
    }

    public function indexTitle()
    {
        $zone = $this->getZone();

        return Trans('country::cms.list_countries').': '.$zone->name;
    }

    public function editTitle()
    {
        $zone = $this->getZone();

        return Trans('country::cms.add_zoneables').': '.$zone->name;
    }

    public function getIndexLink()
    {
        $zone = $this->getZone();

        return route('cms.zoneables.index', ['zone'=>$zone->id]);
    }
}
