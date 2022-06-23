<?php


namespace App\Classes\Ui\Constants;


class ShippingMethodsPrices extends ConstantAbstract
{
    public $routes = [
        'cms.shipping_prices.index',
        'cms.shipping_prices.create',
        'cms.shipping_prices.edit',
    ];

    public function data()
    {
        return [
            'cms.shipping_prices.index'=>[
                'title'=>Trans('shipping_methods::cms.shipping_prices_list'),
                'back_link'=>[
                    'link'=>$this->getIndexBackLink(),
                    'text'=>$this->getIndexBackLinkText(),
                ]
            ],

            'cms.shipping_prices.create'=>[
                'title'=>Trans('shipping_methods::cms.shipping_price_create'),
                'back_link'=>[
                    'link'=>$this->getIndexLink(),
                    'text'=>Trans('shipping_methods::cms.shipping_prices_list'),
                ]
            ],

            'cms.shipping_prices.edit'=>[
                'title'=>Trans('shipping_methods::cms.edit_shipping_price'),
                'back_link'=>[
                    'link'=>$this->getIndexLink(),
                    'text'=>Trans('shipping_methods::cms.shipping_prices_list'),
                ]
            ]
        ];
    }

    public function getShippingMethod()
    {
        return request('shipping_method');
    }

    public function getIndexBackLink()
    {
        $shipping_method = $this->getShippingMethod();

        return route('cms.shipping_methods.zones.index', ['shipping_method'=>$shipping_method->id]);
    }

    public function getIndexBackLinkText()
    {
        $shipping_method = $this->getShippingMethod();

        return Trans('shipping_methods::cms.list_of_zones_for').': '.$shipping_method->name;
    }

    public function getIndexLink()
    {
        $shipping_method = $this->getShippingMethod();
        $priceable_type = $this->getPriceableType();
        $priceable_id = $this->getPriceableId();

        return route('cms.shipping_prices.index', [
            'shipping_method'=>$shipping_method->id,
            'priceable_id'=>$priceable_id,
            'priceable_type'=>$priceable_type,
        ]);
    }

    public function getPriceableType()
    {
        if(empty(request('shipping_price')))
        {
            return request('priceable_type');
        }

        $shipping_price = request('shipping_price');
        return $shipping_price->priceable_type;
    }

    public function getPriceableId()
    {
        if(empty(request('shipping_price')))
        {
            return request('priceable_id');
        }

        $shipping_price = request('shipping_price');
        return $shipping_price->priceable_id;
    }
}
