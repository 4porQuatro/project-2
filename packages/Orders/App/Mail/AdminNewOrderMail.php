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

class AdminNewOrderMail extends Mailable
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
        if ( ! empty($this->checkout->email_receivers))
        {
            return $this->from($this->emailFrom())->to($this->checkout->email_receivers)->subject('You have received a new order')->markdown('order::emails.order.received');
        }
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
