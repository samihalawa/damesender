<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Redirect;


class SMSController extends Controller
{
    public function __construct(){
        // Persmisos para acceder a estos metodos
        //$this->middleware('auth');
       // $this->middleware('roledSMS');
    }

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
        $token = 'f0240fb2ccdfcf9d0361bee2fdaf9ad2';
        $client = new Client($sid, $token);

       foreach($numbers as $index => $number){
           if($index > 0){
          
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
       if(!$response){
        return redirect::back()->withErrors("Error sending SMS.");
       }else{
        $data = 'SMS sent successfully!';
        return Redirect::to('/sms')->with('data', $data);
       }
           
      
    }
}
