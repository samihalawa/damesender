<?php

namespace App\Http\Controllers;

use App\Mail\CustomMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\OrderPromocion;
use App\Jobs\ProcessEmail;

class MailController extends Controller
{
    public function __construct(){
        // Persmisos para acceder a estos metodos
        $this->middleware('auth');
        $this->middleware('roledSMS');
       // $this->middleware(['auth'], ['only' => 'index', 'store','sendTest']);

    }

   
    public function sendTest(){

        /*
        $data["email"]="houltman@gmail.com";
        $data["user"]="Gabriel Houltman";
        $data["subject"]="Este año Black Friday y Navidad los presentamos juntos la primera semana del año";
        $data["body"] ="Feliz año";
        $data["from"]="atencion@megacursos.com";
        $data["name"]="Megacursos";

        Mail::send(
            [],
            [],
            function ($message) use ($data) {
                $message
               // ->to($data['recipient'])
                ->to($data["email"], $data["user"])
                ->subject($data["subject"])
                ->from($data["from"],$data["name"])
               // ->from($data['email'], $data['name'])
                ->setBody($data["body"], 'text/html');
            }
        );
        */
        $email="houltman@gmail.com";
        $user="Gabriel Houltman";
        $subject="Este año Black Friday y Navidad los presentamos juntos la primera semana del año";
        $body ="Feliz año desde beanktald";
        $from="atencion@megacursos.com";
        $name="Megacursos";
        //envio de email por colas
        ProcessEmail::dispatch($subject, $body,$email,$from,$name,$user)
        ->delay(now()->addSeconds(1));

    }
    public function index() {
        $files = array_diff(scandir('../public/templates/img'), ['..', '.']);

        $templates = [];

        foreach ($files as $file) {
            $filename = str_replace('_' , ' ', explode('.', $file)[0]);
            
            $templates[] = [
                'dir' => 'templates/img/' . $file,
                'name' => $filename
            ];
        }
        
        return view('mail', ['templates' => $templates]);
    }

   
    public function store(Request $request) {
        $filePath = $request->file('recipients')->getRealPath();

        $contacts = array_map('str_getcsv', file($filePath));

        if ($contacts) {  

            $body = ($request->type == 0? $request->content : $request->plain);
            $subject = $request->subject;
            $from = $request->email;
            $name = $request->name;
            
            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                    $email = $contact[4];
                    $user =$contact[0]." ".$contact[1];
                    //procesamient de emails por colas
                    ProcessEmail::dispatch($subject, $body,$email,$from,$name,$user)
                    ->delay(now()->addSeconds(1));
                    return Redirect::to('/email')->with('data', "Campaña en cola de envio satisfacorio!");                 
                    /*
                    Mail::send(
                        [],
                        [],
                        function ($message) use ($data) {
                            $message->to($data['recipient'])
                            ->subject($data['subject'])
                            ->from($data['email'], $data['name'])
                            ->setBody($data['body'], 'text/html');
                        }
                    );
                    */
                }
            }

        } else {
            return redirect::back()->withErrors("Error:ingrese correctamente el archivo .csv.");
        }
    }
}
