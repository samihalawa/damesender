<?php

/**
 * Created by ProcessEmail
 */

namespace App\Jobs;

use App\Models\SendEmail;
use App\Models\CampaingCustomer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $subject;
    protected $body;
    protected $email;
    protected $from;
    protected $name;
    protected $user;
    protected $campaing;
    protected $nameEmail;
    protected $guardar;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($subject, $body, $email, $from, $name, $user, $campaing, $nameEmail, $guardar)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->email = $email;
        $this->from = $from;
        $this->name = $name;
        $this->user = $user;
        $this->campaing = $campaing;
        $this->nameEmail = $nameEmail;
        $this->guardar = $guardar;
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

            Mail::send("emails." . $this->nameEmail, ['unsubscribe_link' => $unsubscribe_link], function ($message) use (&$headers, $info) {
                $message->to($info->to_email_address)
                    ->from($info->infofrom, $info->infoname)
                    ->subject($info->subject);
                $headers = $message->getHeaders();
            });

            $message_id = $headers->get('X-SES-Message-ID')->getValue();

        if ($message_id) {
            $mensxx = CampaingCustomer::where('id', $this->guardar)->first();
            $mensxx->aws_message_id = $message_id;
            $mensxx->aws = 1;
            $mensxx->hash = $hash;
            $mensxx->save();
        }
    }
}
