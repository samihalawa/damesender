<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPromocion extends Mailable
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
    public function __construct($subject, $body,$fromx,$name)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->fromx = $fromx;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromx,$this->name)
                    ->view('emails.template')
                    ->with([
                        //enviar variables
                        'body' => $this->body,
                        //'orderPrice' => $this->order->price,
                    ]);
                    //vista con email de campañas
                    //return $this->view('view.emails.enero');
    }
}
