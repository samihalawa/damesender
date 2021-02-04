<?php

namespace App\Listeners;

use DB;
use Log;

class LogSentMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::info('MESSAGE ID: ' . $event->message->getId());

        $sesMessageId = $event->message
            ->getHeaders()->get('X-SES-Message-ID')->getValue();

        $log = DB::table('logs')->insert(
            [
                'name' => "send" . $sesMessageId,
                'create_at' => date("Y-m-d h:i:s"),
            ]
        );

    }
}
