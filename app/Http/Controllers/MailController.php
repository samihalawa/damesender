<?php

namespace App\Http\Controllers;
use App\Http\Requests\MailRequest;
use App\Jobs\ProcessEmail;
use Illuminate\Support\Facades\Redirect;

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
        $body = "Feliz año desde beanktald";
        $from = "atencion@megacursos.com";
        $name = "Megacursos";
        //envio de email por colas
        $delay=10;
        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
            ->delay(now()->addSeconds($delay+5));
        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
            ->delay(now()->addSeconds($delay+5));

        return "i";


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

        $filePath = $request->file('recipients')->getRealPath();
       // $filePath="/var/www/damesender/megacursos_CONTACT.csv";

        $contacts = array_map('str_getcsv', file($filePath));

       // $suma=0;
        $delay=10;

        if ($contacts) {

            $body = ($request->type == 0 ? $request->content : $request->plain);
            $subject = $request->subject;
            $from = $request->email;
            $name = $request->name;

            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                   // $email = $contact[4];
                   // echo $email;
                   if($contact[4]!=" "){
                         $delay+5;
                         $email = $contact[4];
                         $user = $contact[0] . " " . $contact[1];
                         //procesamient de emails por colas
                         ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
                             ->delay(now()->addSeconds($delay+15));   
                              
                    }
                }
            }
           // return $suma;
            return Redirect::to('/email')->with('data', "Campaña en cola de envio satisfacorio!");

        } else {
            return redirect::back()->withErrors("Error:ingrese correctamente el archivo .csv.");
        }
    }
}
