<?php

namespace Packages\Store\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Http\Requests\CartRequest;

class CartController extends Controller
{
    public function index($type = null)
    {
        $cart = new Cart(session(), $type);

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }

    public function share($uuid)
    {
        $cart = \Packages\Store\app\Models\Cart::where('uuid', $uuid)->first();

        return $cart->data;
    }

    public function store(CartRequest $request, $type = null)
    {
        $cart = new Cart(session(), $type);

        $cart->add($request->product, $request->quantity);

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }

    public function patch(CartRequest $request, $type = null)
    {
        $cart = new Cart(session(), $type);

        $cart->update($request->product->id, $request->quantity);

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }

    public function remove($product_id, $type = null)
    {
        $cart = new Cart(session(), $type);

        $cart->remove($product_id);

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }
}
