<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use Illuminate\Support\Facades\Http;
use Packages\Country\App\Models\Tax;
use Packages\Orders\App\Models\Order;

class MoloniShipping {

    public $order;
    private $token;
    private $company_id;

    public function __construct(Order $order, $company_id)
    {
        $this->token = (new MoloniClient())->token;
        $this->order = $order;
        $this->company_id = $company_id;
    }


    public function getLineDetail()
    {
        $result = $this->getShipping($this->order->shipping_method_id);
        if(empty($result))
            $this->createShipping();
            $result = $this->getShipping($this->order->shipping_method_id)[0];

        $m_product = [];
        $m_product['product_id'] =  $result->product_id;
        $m_product['name'] = $result->name;
        $m_product['qty'] = 1;
        $m_product['price'] = $this->order->total_shipping/(1+Tax::getDefault());
        $m_product['taxes'] = $this->getTaxes(Tax::getDefault());
        return $m_product;
    }


    public function createShipping()
    {
        $data = [];
        $data['company_id'] = $this->company_id;
        $data['type'] = 2;
        $data['category_id'] = $this->getCategory();
        $data['name'] = $this->order->shippingMethod->name;
        $data['summary'] = '';
        $data['reference']= 'shipping-'.$this->order->shipping_method_id;
        $data['ean'] = '';
        $data['price'] = $this->order->shippingMethod->default_price;
        $data['unit_id'] = $this->getMeasurementUnits();
        $data['has_stock'] = 0;
        $data['stock'] = 0;
        $data['exemption_reason'] = '';
        $data['taxes'] = $this->getTaxes(Tax::getDefault());
        $response = Http::asForm()->post(config('moloni.end_point').'/products/insert/?access_token=' . $this->token, $data);
    }


    private function getCategory()
    {
        $response = Http::asForm()->post(config('moloni.end_point') . '/productCategories/getAll/?access_token=' . $this->token, ['company_id'=>$this->company_id, 'parent_id'=>0]);
        $data = json_decode($response->body());
        $result = '';
        foreach($data as $cat)
        {
            if($cat->name == 'Shipping')
            {
                return $cat->category_id;
            }
        }
        $new_cate = ['company_id'=>$this->company_id, 'parent_id'=>'', 'name'=>'Shipping', 'description'=>'', 'pos_enabled'=>''];
        $response = Http::asForm()->post(config('moloni.end_point') . '/productCategories/insert/?access_token=' . $this->token, $new_cate);
        $data = json_decode($response->body());
        return $data->category_id;
    }

    private function getMeasurementUnits()
    {
        $response = Http::asForm()->post(config('moloni.end_point') . '/measurementUnits/getAll/?access_token=' . $this->token, ['company_id'=>$this->company_id]);
        foreach(json_decode($response->body()) as $unit)
        {
            if($unit->name === 'Unidade')
            {
                return $unit->unit_id;
            }
        }
    }

    private function getTaxes($default_tax)
    {
        $response = Http::asForm()->post(config('moloni.end_point') . '/taxes/getAll/?access_token=' . $this->token, ['company_id'=>$this->company_id]);
        foreach(json_decode($response->body()) as $tax)
        {
            if($tax->value/100 === $default_tax)
            {
                $result = ['tax_id'=>$tax->tax_id, 'value'=>$tax->value, 'order'=>1, 'cumulative'=>0];
            }
        }
        if(empty($result))
        {
            foreach(json_decode($response->body()) as $tax)
            {
                if($tax->value === 23)
                {
                    $result = ['tax_id'=>$tax->tax_id, 'value'=>$tax->value, 'order'=>1, 'cumulative'=>0];
                }
            }
        }

        return [$result];

    }

    public function getShipping($id)
    {
        $data = ['reference'=>'shipping-'.$id, 'company_id'=>$this->company_id];
        $response = Http::asForm()->post(config('moloni.end_point') . '/products/getByReference/?access_token=' . $this->token, $data);
        return json_decode($response->body());
    }
}
