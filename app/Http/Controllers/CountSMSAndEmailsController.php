<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountSMSAndEmailsController extends Controller
{
    public function index(Request $request){
        $contadorSMS = 8;
        $contadorEmails = 25;
        return view(
            "dashboard.sms_emails",
            [
                'contadorSMS' => $contadorSMS ,
                'contadorEmail' => $contadorEmails
            ]
        );
    }
}
