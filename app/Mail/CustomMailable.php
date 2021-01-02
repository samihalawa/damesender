<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;
    public $from;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body,$from)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.template');
    }
}
