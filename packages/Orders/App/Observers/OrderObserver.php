<?php

namespace Packages\Orders\App\Observers;

use Illuminate\Support\Facades\Mail;
use Packages\Orders\App\Constants\OrderStatus;
use Packages\Orders\App\Mail\AdminNewOrderMail;
use Packages\Orders\App\Mail\ShippingMethodOrderMail;
use Packages\Orders\App\Models\InvoiceProvider;
use Packages\Orders\App\Models\Order;

class OrderObserver {

    /**
     * Handle the Order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->statusHistories()->create(['status'=>$order->fresh()->status]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        $status_note = $order->isDirty('status_note') ? $order->status_note : '';
        if($order->isDirty('status')){
            if(!empty($order->shippingMethod) && !empty($order->shippingMethod->emails))
            {
                Mail::send(new ShippingMethodOrderMail($order));
            }
            if($this->checkGenerateInvoice($order))
            {
                $this->generateInvoice($order);
            } else {
                $order->statusHistories()->create(['status'=>$order->status, 'text'=>$status_note]);

            }
        }

    }

    /**
     * @param Order $order
     * @return bool
     */
    private function checkGenerateInvoice(Order $order): bool
    {
        return in_array($order->status, [OrderStatus::AWAITING_FULFILLMENT, OrderStatus::AWAITING_SHIPPMENT, OrderStatus::PARTIALY_SHIPPED, OrderStatus::SHIPPED, OrderStatus::COMPLETED]) && InvoiceProvider::exists() && empty($order->invoice_data) && env('APP_ENV') === 'production';
    }

    /**
     * @param Order $order
     * @return void
     */
    private function generateInvoice(Order $order): void
    {
        $provider = InvoiceProvider::get()->data[0]['provider'];
        $client = new $provider($order);
        $order->invoice_data = $client->createInvoice();
        $order->save();
    }
}
