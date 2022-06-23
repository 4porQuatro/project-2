<?php


namespace Packages\Orders\Classes\Repositories;


use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Currency;
use Packages\Country\App\Models\Region;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\App\Http\Requests\CheckoutRequest;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Packages\Voucher\app\Models\Voucher;

class PublishOrder {

    private $checkout;
    private $order;
    private $request;

    public function __construct(Checkout $checkout, CheckoutRequest $request)
    {
        $this->order = new Order();
        $this->order->checkout_id = $checkout->id;
        $this->request = $request;
        $this->order->total_discount = 0;
    }

    public function save()
    {
        $this->setTotal();
        $this->setTotalShipping();
        $this->setPaymentMethod();
        $this->setPercentageTaxes();
        $this->setShippingKeys();
        $this->setBillingKeys();
        $this->setTotalTaxes();
        $this->setVoucher();
        $this->setRate();
        $this->setStatus();
        $this->setBillingData();
        $this->setShippingData();
        $this->setGrandTotal();
        $this->order->save();
        $this->saveOrderItems();
        $this->saveUser();
        return $this->order;
    }

    private function setVoucher()
    {
        $voucher = session()->has('voucher_code') ? Voucher::where('code', session()->get('voucher_code'))->first() : null;
        $this->order->voucher_object = session()->has('voucher_code') ? $voucher->toArray() : [];
        $this->order->voucher_discount = session()->has('voucher_code') ? $voucher->getOrderDiscount($this->getCart()['content']) : 0;
        $this->order->total_discount += $this->order->voucher_discount;
        session()->forget('voucher_code');
    }

    private function setRate()
    {
        $active_currency = (new Currency());
        $this->order->currency_id = $active_currency->getActiveCurrency()->id;
        $this->order->currency_rate = $active_currency->getActiveCurrency()->rate;
    }


    private function setTotal()
    {
        $cart = (new Cart(session()))->getContent();
        $this->order->total = round($cart->sum(function($item){
            return $item->qty*$item->getBuyablePrice();
        }),2);
    }

    private function saveUser()
    {
        if(auth()->check() && !empty(auth()->user()->reserved_area_id))
        {
            $this->order->user_id = auth()->user()->id;
            $this->order->save();
        }
    }
    private function setStatus()
    {
        $this->order->status = OrderStatus::PENDING;
    }

    private function setTotalTaxes()
    {
        $this->setPercentageTaxes();
        $this->setTotal();
        if($this->priceHasTaxesIncluded())
        {
            $this->order->total_taxes = $this->order->total - round($this->order->total/(1+$this->order->percentage_taxes/100),2);

        } else {
            throw new \Exception('A desenvolver');;

        }
    }

    private function setGrandTotal()
    {
        $this->order->grand_total = round($this->order->total+ $this->order->total_shipping - $this->order->total_discount,2);
    }

    private function setTotalShipping()
    {
        $this->order->shipping_method_id = $this->request->get('shipping_method_id');
        $shipping_method = ShippingMethod::find($this->request->get('shipping_method_id'));
        $zones = array_merge(Country::find($this->request->shipping_country)->zones->pluck('id')->toArray(), Region::find($this->request->shipping_region)->zones->pluck('id')->toArray());
        $shipping_method->setShippingPriceByAttributesAndCountry($zones, $this->getCartInstance()->getShippmentWeight(), $this->getCartInstance()->getShippmentVolume());
        $this->order->total_shipping = $shipping_method->default_free_order_price > 0 && $shipping_method->default_free_order_price <= $this->order->total ? 0 : $shipping_method->price;
        $this->order->original_shipping_method = $shipping_method->toArray();
    }


    private function setBillingData()
    {
        $data  = [];
        foreach($this->request->all() as $key=>$item)
        {
            if(explode('_', $key)[0] == 'billing')
            {
                $data[$key] = $item;
            }
        }
        $this->order->billing_address_data = $data;
    }

    private function setShippingData()
    {
        $data  = [];
        foreach($this->request->all() as $key=>$item)
        {

            if(explode('_', $key)[0] == 'shipping' && last(explode('_', $key)) !== 'id')
            {
                $data[$key] = $item;
            }
        }
        $this->order->shipping_address_data = $data;
    }

    private function setBillingKeys()
    {
        $this->order->billing_address_keys = $this->order->checkout->billingForm()->fields->pluck('label', 'name');
    }

    private function setPercentageTaxes()
    {
        $this->order->percentage_taxes = Region::find($this->request->get('shipping_region'))->defaultTax();
        $this->order->country_id = $this->request->shipping_country;
        $this->order->region_id = $this->request->shipping_region;
    }


    private function setShippingKeys()
    {
        $this->order->shipping_address_keys = $this->order->checkout->shippingForm()->fields->pluck('label', 'name');
        return $this->order;
    }

    private function setPaymentMethod()
    {
        $this->order->payment_method_id = $this->request->get('payment_method_id');
        $this->order->original_payment_method = PaymentMethod::find($this->request->get('payment_method_id'))->toArray();
    }


    private function saveOrderItems()
    {

        $order = $this->order;
        $cart = (new Cart(session()))->getContent();
        $cart->each(function($item) use ($order) {
            $order->items()->create([
                'itemable_type'=>get_class($item),
                'itemable_id'=>$item->id,
                'original_itemable_data'=>$item->toArray(),
                'price'=>$item->getBuyablePrice(),
                'quantity'=>$item->qty,
            ]);
            $item->stock -= $item->qty;
            unset($item->qty);
            $item->save();
        });
    }



    private function getCart()
    {
        $cart = $this->getCartInstance();

        return [
            'content' => $cart->getContent(),
            'content_count' => $cart->count(),
            'total' => $cart->total()
        ];
    }

    public function getCartInstance()
    {
        return new Cart(session());
    }

    public function priceHasTaxesIncluded()
    {
        $product_settings = Cache::rememberForever('product_settings', function (){
            return Setting::getByName('product_settings')->data;
        });

        return (bool) $product_settings['taxes_included'];
    }

}
