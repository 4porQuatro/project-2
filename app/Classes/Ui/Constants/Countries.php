<?php


namespace App\Classes\Ui\Constants;


class Countries extends ConstantAbstract
{
    public $routes = [
        'cms.country.index',
        'cms.country.region.index',
    ];

    public function data()
    {
        return [
            'cms.country.index'=>[
                'title'=>Trans('country::cms.list_countries'),
            ],

            'cms.country.region.index'=>[
                'title'=>$this->regionListTitle(),
                'back_link'=>[
                    'link'=>route('cms.country.index'),
                    'text'=>Trans('country::cms.list_countries'),
                ]
            ],
        ];
    }

    public function getCountry()
    {
        return request('country') ?? null;
    }

    public function regionListTitle()
    {
        $country = $this->getCountry();

        return $country ? Trans('country::cms.list_regions').': '.$country->name : '';
    }
}
