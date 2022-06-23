<?php


namespace App\Classes\Ui\Constants;


class ProductVariants extends ConstantAbstract
{
    public $routes = [
        'cms.product-variants.create',
        'cms.product-variants.edit',
    ];

    public function data()
    {
        return [
            'cms.product-variants.create'=>[
                'title'=>Trans('store::cms.new_variant'),
                'back_link'=>[
                    'link'=>$this->backLink(),
                    'text'=>$this->backText(),
                ]
            ],

            'cms.product-variants.edit'=>[
                'title'=>Trans('store::cms.edit_variant'),
                'back_link'=>[
                    'link'=>$this->backLink(),
                    'text'=>$this->backText(),
                ]
            ]
        ];
    }

    public function getProduct()
    {
        return request('product');
    }

    public function backLink()
    {
        $product = $this->getProduct();

        return route('cms.products.edit', ['product'=>$product->id]);
    }

    public function backText()
    {
        $product = $this->getProduct();

        return $product->title;
    }
}
