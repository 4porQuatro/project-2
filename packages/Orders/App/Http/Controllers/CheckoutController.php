<?php


namespace Packages\Orders\App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\App\Http\Requests\CheckoutRequest;
use Packages\Orders\App\Mail\AdminNewOrderMail;
use Packages\Orders\App\Mail\UserNewOrderMail;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;
use Packages\Orders\Classes\Repositories\PublishOrder;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Store\app\Models\Product;

class CheckoutController extends Controller {


    public function show(Checkout $checkout)
    {
        if(! $this->validAccess($checkout))
        {
            auth()->logout();
            return redirect()->to($checkout->reservedArea->loginPage->path());
        }
        $sections = $checkout->sections()->active()->orderBy('sectionables.priority', 'asc')->get();
        $cart = $this->getCart();
        $layout_path = !empty($checkout->layout) ? $checkout->layout->path : 'order::front.core.layout';
        $seo = (new Seo());
        $seo->title = 'Checkout';
        return view($layout_path, compact('checkout', 'sections', 'cart', 'seo'));
    }

    public function store(CheckoutRequest $request, Checkout $checkout)
    {
        $order = (new PublishOrder($checkout, $request))->save();
        if(env('APP_ENV') !=  'testing')
        {
            $order->generatePaymentData();
        }
        (new Cart(session()))->destroy();
        if(! empty($checkout->email_receivers))
            Mail::send(new AdminNewOrderMail($order, $checkout));

        Mail::send(new UserNewOrderMail($order, $checkout));

        return redirect()->route('payment.show', ['order_uuid'=>$order->uuid]);
    }

    private function getCart()
    {
        $cart = new Cart(session());

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }

    /**
     * @param Checkout $checkout
     * @return bool
     */
    private function validAccess(Checkout $checkout): bool
    {
        return  empty($checkout->reservedArea)  ||  (auth()->check() && $checkout->reserved_area_id == auth()->user()->reserved_area_id);
    }


}
