<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SenderEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $file;
    public $subject;
    public $body;
    public $from;
    public $name;
    public $campaign;
    public $senDate;


    //public $delay;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $from, $name, $campaign, $file, $sendDate)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->from = $from;
        $this->name = $name;
        $this->campaign = $campaign;
        $this->file = $file;
        $this->senDate = $sendDate;
    }
}
