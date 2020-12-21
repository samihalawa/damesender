<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function index() {
        return view('sms');
    }

    public function store() {
        // echo 'Enviando mensaje...';
        // exit;
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC6870684b47eaa926dd554f9304a1ff76';
        $token = '75ce39c7cf427db95f484b97fd7e72ba';
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $response = $client->messages->create(
            // the number you'd like to send the message to
            '+573165263438',
            [
                'from' => '+12517664989',
                'body' => 'TONCES MAMAGUEVO'
            ]
        );
        
        echo $response;
    }
}
