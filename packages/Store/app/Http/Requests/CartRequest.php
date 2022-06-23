<?php

namespace Packages\Store\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Models\Product;
use Packages\Store\app\Rules\BuyableRule;

class CartRequest extends FormRequest
{
    public $product;
    public $desire_quantity;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->product = Product::where('id', $this->product_id)->with('attributeOptions.attribute')->first();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->desire_quantity = $this->getDesireQuantity();

        return [
            'product_id'=>['required', 'exists:products,id', new BuyableRule($this->product, $this->desire_quantity)],
            'quantity'=>'required|min:1'
        ];
    }

    private function getDesireQuantity()
    {
        $cart = new Cart(session());
        $content = $cart->getContent();

        if($this->getMethod() == 'POST' && $content->has($this->product_id))
        {
            return $content->get($this->product_id)->qty + $this->quantity;
        }

        return $this->quantity;
    }
}
