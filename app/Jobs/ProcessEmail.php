<?php

/**
 * Created by ProcessEmail
 */

namespace App\Jobs;

use App\Models\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
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
    protected $nameEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($subject, $body, $email, $from, $name, $user, $campaing, $nameEmail)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->from = $from;
        $this->name = $name;
        $this->user = $user;
        $this->campaing = $campaing;
        $this->nameEmail = $nameEmail;

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
        $mensxx = "";

        $hash = Hash::make($this->email);

        $hash = str_replace("/", "A", $hash);

        $hash = str_replace("$", "S", $hash);

        $unsubscribe_link = "https://damesender.com/unsuscribe/campaing/" . $this->campaing . "/" . $hash;

        //$unsuscribe = SendEmail::where(["to_email_address" => $this->email, "unsuscribe"=> 1])->first();

        $unsuscribe = SendEmail::where('to_email_address', $this->email)
            ->where(function ($query) {
                $query->orWhere('unsuscribe', 1)
                    ->orWhere('bounced', 1)
                })
            ->first();

        if (!$unsuscribe) {
            Mail::send("emails." . $this->nameEmail, ['unsubscribe_link' => $unsubscribe_link], function ($message) use (&$headers, $info) {
                $message->to($info->to_email_address)
                    ->from($info->infofrom, $info->infoname)
                    ->subject($info->subject);
                $headers = $message->getHeaders();
            });

            $message_id = $headers->get('X-SES-Message-ID')->getValue();

            if ($message_id) {
                $sentEmail = new SendEmail;
                $sentEmail->to_email_address = $info->to_email_address;
                //$sentEmail->subject = $info->subject;
                $sentEmail->message = $mensxx;
                $sentEmail->hash = $hash;
                $sentEmail->aws_message_id = $message_id;
                $sentEmail->campaing_id = $this->campaing;
                $sentEmail->save();
            }
        }
    }
}
