<?php


namespace Packages\Orders\App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Layout;
use App\Models\Seo;
use Packages\Orders\App\Models\Order;


class PaymentController extends Controller {

    public function show($order_uuid)
    {
        $result = Order::where('uuid', $order_uuid)->first();
        $sections = $result->paymentMethod->sections()->active()->orderBy('sectionables.priority', 'asc')->get();
        $layout = $result->paymentMethhod->layout ?? Layout::where('default', 1)->first();
        $seo = new Seo();
        $seo->title = 'Payment';
        return view($layout->getPath(), compact('result', 'sections', 'seo', 'layout'));
    }

    public function success()
    {

    }
}
