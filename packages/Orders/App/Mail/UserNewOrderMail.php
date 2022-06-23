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

class UserNewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $checkout;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, Checkout $checkout)
    {
        $this->order = $order;
        $this->checkout = $checkout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailFrom())->to($this->order->billing_address_data['billing_email'])->subject('Your order')->markdown('order::emails.order.user_success');
    }

    private function emailFrom()
    {
        if(!empty(env('MAIL_FROM_ADDRESS')))
        {
            return env('MAIL_FROM_ADDRESS');
        }

        if ( ! filter_var(env('MAIL_USERNAME'), FILTER_VALIDATE_EMAIL))
        {
            return 'info@dev.pt';
        }
        return env('MAIL_USERNAME');
    }
}
