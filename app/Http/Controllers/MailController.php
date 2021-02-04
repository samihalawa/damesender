<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessNotification;
use App\Models\SendEmail;
use Illuminate\Support\Facades\Redirect;
use Mail;
use DB;

class MailController extends Controller
{
    public function __construct()
    {
        // Persmisos para acceder a estos metodos
        $this->middleware('auth');
        $this->middleware('roledSMS');
        // $this->middleware(['auth'], ['only' => 'index', 'store','sendTest']);

    }

    public function sendTest()
    {

        $email = "houltman@gmail.com";
        $user = "Gabriel Houltman";
        $subject = "Este año Black Friday y Navidad los presentamos juntos la primera semana del año";
        $body = "Prueba beanstalkd y ses notification";
        $from = "atencion@megacursos.com";
        $name = "Megacursos";
        //envio de email por colas
        $delay = 10;

       
        ProcessNotification::dispatch($subject, $body, $email, $from, $name, $user)
        ->delay(now()->addSeconds($delay+5));

        return now();
        return "Ok";
        
/*
        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
        ->delay(now()->addSeconds($delay+5));

        
         return "Ok";
        /*
        $headers = "";
        $data = "sss";
        $info = (object) [
            'to_email_address' => "houltman@gmail.com",
            'subject' => 'hola probando ses notificacion',
        ];
        $mensxx="probando";
        Mail::send('emails.enero', ['data' => $data], function ($message) use (&$headers, $info) {
            $message->to($info->to_email_address)->subject($info->subject);
            $headers = $message->getHeaders();
        });

        $message_id = $headers->get('X-SES-Message-ID')->getValue();

        // Log::info($message_id);
        if ($message_id) {
            $sentEmail = new Sendemail;
            $sentEmail->to_email_address = $info->to_email_address;
            $sentEmail->subject = $info->subject;
            $sentEmail->message = $mensxx;
            $sentEmail->aws_message_id = $message_id;
            $sentEmail->save();
           // return redirect('/sent_emails')->with('success', 'Email Sent');
        }

        return $message_id;*/
        
        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
        ->delay(now()->addSeconds($delay+5));
         
        return "ok";

    }
    public function index()
    {
        $files = array_diff(scandir('../public/templates/img'), ['..', '.']);

        $templates = [];

        foreach ($files as $file) {
            $filename = str_replace('_', ' ', explode('.', $file)[0]);

            $templates[] = [
                'dir' => 'templates/img/' . $file,
                'name' => $filename,
            ];
        }

        return view('mail', ['templates' => $templates]);
    }

    public function store(MailRequest $request)
    {

        //$filePath = $request->file('recipients')->getRealPath();
       // $filePath="/var/www/damesender/megacursos_CONTACT_20212.csv";//archivo fijo

        $filePath="/var/www/damesender/info.csv";//archivo fijo

       // megacursos_CONTACT_20212.csv

        $contacts = array_map('str_getcsv', file($filePath));

        $delay = 30;

        if ($contacts) {

            $body = ($request->type == 0 ? $request->content : $request->plain);
            $subject = $request->subject;
            $from = $request->email;
            $name = $request->name;
            $sum=1;
            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                    if ($contact[4] != " ") {
                        $delay + 5;
                        $email = $contact[4];
                        $user = $contact[0] . " " . $contact[1];
                        $sum++;
                        //procesamient de emails por colas
                        
                        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
                            ->delay(now()->addSeconds($delay + 40));
                            

                    }
                }
            }
             return $sum;
            return Redirect::to('/email')->with('data', "Campaña en cola de envio satisfacorio!");

        } else {
            return redirect::back()->withErrors("Error:ingrese correctamente el archivo .csv.");
        }
    }
}
