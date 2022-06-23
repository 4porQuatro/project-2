<?php

namespace Packages\Store\app\Http\Controllers;

use App\Classes\Front\QueryBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Packages\Store\app\Models\Product;

class ProductsController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $attribute_options = request('attribute_options');

        $variation = $product->variations();

        foreach ($attribute_options as $attribute_option)
        {
            $variation = $variation->whereHas('attributeOptions', function ($q) use ($attribute_option){
                $q->where('attribute_option_id', $attribute_option);
            });
        }

        return $variation->withStock()->firstOrFail()->append('attributesOptions');
    }

    public function get()
    {
        $products = Product::primary()->with(['translations', 'categories.translations'])->active()->filter(request()->except('_token'));
        if(request()->has('items_per_page'))
        {
            return $products->paginate(request()->get('items_per_page'));
        }
        return ['data'=>$products->get()];
    }
}
