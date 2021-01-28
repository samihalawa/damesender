<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;
    public $fromx;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $fromx, $name)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->fromx = $fromx;
        $this->name = $name;
    }

    public function build()
    {

        return $this->from($this->fromx, $this->name)
            ->html($this->body);
    }

}
