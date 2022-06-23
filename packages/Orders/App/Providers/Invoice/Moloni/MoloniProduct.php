<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use Illuminate\Support\Facades\Http;
use Packages\Store\app\Models\Product;

class MoloniProduct {

    public $company_id;
    public $token;

    public function __construct($company_id)
    {
        $this->token =  (new MoloniClient())->token;
        $this->company_id = $company_id;
    }

    public function getWithQty(Product $product, $qty)
    {
        $result = $this->getProduct($product->id);
        if(empty($result))
            $this->createProduct($product);
            $result = $this->getProduct($product->id)[0];

        $m_product = [];
        $m_product['product_id'] =  $result->product_id;
        $m_product['name'] = $result->name;
        $m_product['qty'] = $qty;
        $m_product['price'] = $product->getPriceWithoutTax();
        $m_product['taxes'] = $this->getTaxes($product->getTaxIncluded());

        return $m_product;
    }

    public function getProduct($id)
    {
        $data = ['reference'=>$id, 'company_id'=>$this->company_id];
        $response = Http::asForm()->post(config('moloni.end_point') . '/products/getByReference/?access_token=' . $this->token, $data);
        return json_decode($response->body());
    }


    private function createProduct($product)
    {
        $data = [];
        $data['company_id'] = $this->company_id;
        $data['type'] = 1;
        $data['category_id'] = $this->getCategory();
        $data['name'] = $product->title;
        $data['summary'] = $product->small_description;
        $data['reference']=$product->id;
        $data['ean'] = '';
        $data['price'] = ($product->price / (1+$product->getTaxIncluded()));
        $data['unit_id'] = $this->getMeasurementUnits();
        $data['has_stock'] = 0;
        $data['stock'] = 0;
        $data['exemption_reason'] = '';
        $data['taxes'] = $this->getTaxes($product->getTaxIncluded());
        $response = Http::asForm()->post(config('moloni.end_point').'/products/insert/?access_token=' . $this->token, $data);
    }

    private function getCategory()
    {
        $response = Http::asForm()->post(config('moloni.end_point') . '/productCategories/getAll/?access_token=' . $this->token, ['company_id'=>$this->company_id, 'parent_id'=>0]);
        $data = json_decode($response->body());
        if(empty($data))
        {
            $new_cate = ['company_id'=>$this->company_id, 'parent_id'=>'', 'name'=>'Default', 'description'=>'', 'pos_enabled'=>''];
            $response = Http::asForm()->post(config('moloni.end_point') . '/productCategories/insert/?access_token=' . $this->token, $new_cate);
            $data = json_decode($response->body());
            return $data->category_id;
        } else {
            return $data[0]->category_id;
        }
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
}
