<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public function index() {
        return view('sms');
    }

    public function store(Request $request) {
        $filePath = $request->file('recipients')->getRealPath();

        $numbers = array_map('str_getcsv', file($filePath));
        /* echo json_encode($numbers);
         echo $request->content;
         exit;*/
       
        $sid = 'AC5ac49d7a04baa34212dc4f524e4aa72a';
        $token = '8725345a1c0befb5a0153df8184cbe4a';
        $client = new Client($sid, $token);

       foreach($numbers as $index => $number){
           if($index > 0){
              // var_dump($number[5]);
              // echo "<br>";
               $data['recipient'] = $number[5];

               $response = $client->messages->create(
           
                $data['recipient'], //Destino
                [
                    'from' => '+16593480483',
                    'body' => $request->content,
                ]
            );
           }
       }
        
        
        echo $response;
    }
}
