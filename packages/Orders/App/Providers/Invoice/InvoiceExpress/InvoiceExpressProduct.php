<?php

namespace Packages\Orders\App\Providers\Invoice\InvoiceExpress;

class InvoiceExpressProduct {

    private $items;

    public function get($items)
    {
        $products = [];

        foreach($items as $item)
        {
            $products[] = $this->getItem($item);
        }

        return $products;
    }

    /**
     * {
    "name": "Item Name",
    "description": "Item Description",
    "unit_price": "100",
    "quantity": "5",
    "unit": "service",
    "discount": "50"
    }
     * @param $item
     * @return void
     */

    public function getItem($item)
    {
        $product = $item->itemable;
        $data = [];
        $data['name']= $product->title;
        $data['description'] = $product->title;
        $data['unit_price'] = $product->getPriceWithoutTax();
        $data['quantity'] = $item->quantity;
        $data['unit'] = 'service';
        $data['discount'] = 0;
        return $data;
    }




}
