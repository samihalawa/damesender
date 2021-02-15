<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject;
    protected $body;
    protected $email;
    protected $from;
    protected $name;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($subject, $body, $email, $from, $name, $user)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->from = $from;
        $this->name = $name;
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        $headers = "";
        $data = "sss";
        $info = (object) [
        'to_email_address' => "houltman@gmail.com",
        'subject' => 'hola probando ses notificacion',
        ];
        $mensxx = "probando";
        Mail::send('emails.enero', ['data' => $data], function ($message) use (&$headers, $info) {
        $message->to($info->to_email_address)->subject($info->subject);
        $headers = $message->getHeaders();
        });

        $message_id = $headers->get('X-SES-Message-ID')->getValue();

        if ($message_id) {
        $sentEmail = new SendEmail;
        $sentEmail->to_email_address = $info->to_email_address;
        $sentEmail->subject = $info->subject;
        $sentEmail->message = $mensxx;
        $sentEmail->aws_message_id = $message_id;
        $sentEmail->save();
        }
         */

        Mail::to($this->email, $this->user)
            ->send(new Notification($this->subject, $this->body, $this->from, $this->name));

    }

}
