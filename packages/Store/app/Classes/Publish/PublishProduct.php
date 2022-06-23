<?php


namespace Packages\Store\app\Classes\Publish;


use Packages\Store\app\Models\Product;

class PublishProduct {

    public $product;

    public function __construct(Product $product = null)
    {
        $this->product = ! empty($product) ? new Product() : $product;
    }

    public function save()
    {
        return $this->product->save();
    }

    public function setSku($sku)
    {
        $this->product->sku = $sku;
    }

    public function setRef($ref)
    {
        $this->product->ref = $ref;
    }

    public function setPrice(float $price)
    {
        $this->product->price = $price;
    }

    public function setPromotedPrice(float $price)
    {
        $this->product->promoted_price = $price;
    }

    public function setActiveStatus(bool $active)
    {
        $this->product->active = $active;
    }

    public function setHasVariants(bool $has_variants)
    {
        $this->product->has_variants = $has_variants;
    }

    public function setAttributeFamilyId(int $family_id)
    {
        $this->attribute_family_id = $family_id;
    }

    public function fromArray(array $product_array)
    {
        foreach($product_array as $key =>$item)
        {
            if(! is_array($item)){
                $this->product->{$key} = $item;
            }
        }
    }



}
