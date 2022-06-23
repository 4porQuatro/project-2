<?php


namespace Packages\Orders\App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Orders\App\Models\Order;

class OrdersController extends Controller {

    public function index()
    {
        $orders = Order::with(['country', 'region', 'items']);

        if(request()->has('status'))
        {
            $orders = $orders->where('status', request()->get('status'));
        }

        return response()->json($orders->orderBy('created_at', 'desc')->get(), 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['status'=>'integer', 'tracking_code_url'=>'url']);

        $data = $request->only(['status', 'tracking_code_url', 'tracking_code', 'status_note']);
        $order = Order::where('id',$id)->first();
        $order->update($data);

        return response($order, 200);

    }
}
