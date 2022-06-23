<?php

namespace App\Mail;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormSubmitedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $form;
    public $submission;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Form $form, FormSubmission $submission)
    {
        $this->form = $form;
        $this->submission = $submission;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ( ! empty($this->form->email_receivers))
        {
            return $this->from($this->emailFrom())->to($this->form->email_receivers)->subject($this->form->name)->markdown('emails.form.submited');
        }
    }

    private function emailFrom()
    {
        if ( ! filter_var(env('MAIL_USERNAME'), FILTER_VALIDATE_EMAIL))
        {
            return 'info@dev.pt';
        }

        return env('MAIL_USERNAME');
    }
}
