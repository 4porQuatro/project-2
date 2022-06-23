<?php

namespace App\Events\Listners;

use App\Events\ContactReceived;
use App\Mail\NewContactMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContactReceived  $event
     * @return void
     */
    public function handle(ContactReceived $event)
    {
        Mail::send(new NewContactMail($event->data));
    }
}
