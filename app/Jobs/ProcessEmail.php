<?php

namespace App\Jobs;

use App\Models\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subject;
    protected $body;
    protected $email;
    protected $from;
    protected $name;
    protected $user;
    protected $campaing;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($subject, $body, $email, $from, $name, $user, $campaing)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->from = $from;
        $this->name = $name;
        $this->user = $user;
        $this->campaing = $campaing;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $headers = "";
        $data = "";
        $info = (object) [
            'to_email_address' => $this->email,
            'subject' => $this->subject,
            'infofrom' => $this->from,
            'infoname' => $this->name,
            'body' => $this->body,

        ];
        $mensxx = "probando";

        Mail::send(
            [],
            [],
            function ($message) use (&$headers, $info) {
                $message->to($info->to_email_address)
                    ->subject($info->subject)
                    ->from($info->infofrom, $info->infoname)
                    ->setBody($info->body, 'text/html');
                $headers = $message->getHeaders();
            }
        );
        $message_id = $headers->get('X-SES-Message-ID')->getValue();

        if ($message_id) {
            $sentEmail = new SendEmail;
            $sentEmail->to_email_address = $info->to_email_address;
            $sentEmail->subject = $info->subject;
            $sentEmail->message = $mensxx;
            $sentEmail->aws_message_id = $message_id;
            $sentEmail->campaing_id = $this->campaing;
            $sentEmail->save();
        }
        /*
    Mail::to($this->email,$this->user)
    ->send(new OrderPromocion($this->subject,$this->body,$this->from,$this->name));
     */
    }
}
