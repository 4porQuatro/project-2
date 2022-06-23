<?php


namespace App\Classes\Ui\Constants;


class ShippingMethodsZones extends ConstantAbstract
{
    public $routes = [
        'cms.shipping_methods.zones.index',
        'cms.shipping_methods.zones.edit',
    ];

    public function data()
    {
        return [
            'cms.shipping_methods.zones.index'=>[
                'title'=>$this->getIndexTitle(),
                'back_link'=>[
                    'link'=>route('cms.shipping_methods.index'),
                    'text'=>Trans('shipping_methods::cms.list')
                ]
            ],

            'cms.shipping_methods.zones.edit'=>[
                'title'=>Trans('shipping_methods::cms.add_zones'),
                'back_link'=>[
                    'link'=>$this->getLinkToIndex(),
                    'text'=>$this->getIndexTitle()
                ]
            ]
        ];
    }

    public function getShippingMethod()
    {
        return request('shipping_method');
    }

    public function getIndexTitle()
    {
        $shipping_method = $this->getShippingMethod();

        return Trans('shipping_methods::cms.list_of_zones_for').': '.$shipping_method->name;
    }

    public function getLinkToIndex()
    {
        $shipping_method = $this->getShippingMethod();

        return route('cms.shipping_methods.zones.index', ['shipping_method'=>$shipping_method->id]);
    }
}
