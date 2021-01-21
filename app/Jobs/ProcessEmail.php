<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPromocion;

class ProcessEmail implements ShouldQueue
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

    public function __construct($subject, $body,$email,$from,$name,$user)
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
        Mail::to($this->email,$this->user)
         ->send(new OrderPromocion($this->subject,$this->body,$this->from,$this->name));
    }
}
