<?php

namespace Packages\Orders\App\Mail;

use App\Mail\FormSubmitedMail;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;

class ShippingMethodOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailFrom())->to($this->order->shippingMethod->emails)->subject('You have a new order to send')->markdown('order::emails.order.shipping_method');
    }

    private function emailFrom()
    {
        if ( ! filter_var(env('MAIL_FROM_ADDRESS'), FILTER_VALIDATE_EMAIL))
        {
            return 'info@dev.pt';
        }

        return env('MAIL_FROM_ADDRESS');
    }
}
