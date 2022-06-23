<?php


namespace Packages\Orders\App\Http\Controllers;


use Packages\Orders\App\Models\Order;

class OrdersController {

    public function get()
    {
        $user = auth()->user();
        return Order::where('user_id', $user->id)->orderBy('id', 'desc')->with('items')->get();
    }
}
