<?php

namespace App\Http\Controllers;
use App\Models\SendEmail;
use App\Http\Requests\MailRequest;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessNotification;
use App\Jobs\ClearAgile;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\CrmAgile;
use DB;

//use Illuminate\Support\HtmlString;
//['html' => new HtmlString($html)

class MailController extends Controller
{
    public function __construct()
    {
        // Persmisos para acceder a estos metodos
        $this->middleware('auth');
       // $this->middleware('roledSMS');
        // $this->middleware(['auth'], ['only' => 'index', 'store','sendTest']);

    }

    public function sendTest()
    {

        $unsuscribe = SendEmail::where(function($query) {
            $query->orWhere('unsuscribe', 1)
                ->orWhere('bounced', 1);	
        })
        ->orderby("created_at","desc")
        ->paginate(200);

        foreach($unsuscribe as $x){


            try{

            $user=DB::table('send_emails')
            ->where('to_email_address', $x->to_email_address)
            ->where("id","<>",$x->id)
            ->delete();

            }catch(Exception $e){
                echo "error";

            }

           // echo json_encode($user);
            //echo "<br>";

        }

        return "ok";

        //return $unsuscribe;

        return "true";


       ClearAgile::dispatch('kndasdnasdk@gmail.com')->delay(now()->addSeconds(2));
        //return "ok";
         $crm = new CrmAgile();
         //$response = $crm->contacts();
         $response = $crm->searchPerson("kndasdnasdk@gmail.com");

         if($response){
             //return $response->id;
            $deleta = $crm->deletePerson($response->id);
            return json_encode($response);
         }
         return "no";

       

         $deleta = $crm->deletePerson($response->id);

         dd($deleta);

        $validator = Validator::make(['email' => 'houltman@gmail.com'], [
            'email' => 'required|email',
        ]);

        // dd($validator->fails());

        $email = "houltman@gmail.com";
        $user = "Gabriel Houltman";
        $subject = "Este año Black Friday y Navidad los presentamos juntos la primera semana del año";
        $body = "Prueba beanstalkd y ses notification";
        $from = "atencion@megacursos.com";
        $name = "Megacursos";
        //envio de email por colas
        $delay = 5;
        $campaing = "Febrero 2021";


        ProcessNotification::dispatch($subject, $body, $email, $from, $name, $user)->delay(now()->addSeconds($delay));

        return "ok";

        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
            ->delay(now()->addSeconds($delay + 5));

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
        $sentEmail->campaing_id=1;
        $sentEmail->save();
        // return redirect('/sent_emails')->with('success', 'Email Sent');
        }
         */

        return $message_id;

        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
            ->delay(now()->addSeconds($delay + 5));

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
        $filePath = $request->file('recipients')->getRealPath();
        $contacts = array_map('str_getcsv', file($filePath));

        $delay = 12;


        if ($contacts) {

            $body = ($request->type == 0 ? $request->content : $request->plain);

            $campaingx=str_replace(" ", "", $request->campaing);
            $campaingx=str_replace(".", "", $campaingx);

            $nameEmail=$campaingx."-".date("Y-m-d h:i:s");

            $nameEmail= str_replace(" ", "", $nameEmail);

            $nameEmail= str_replace("/", "S", $nameEmail);

          
            $path = base_path('resources/views/emails/'.$nameEmail.'.blade.php');

            $file = fopen($path, "a+");

            fputs($file, $body);
    
            fclose($file);

            $campaing = new Campaign;
                $campaing->name =$nameEmail;
                $campaing->tipo = "Email";
                $campaing->user_id = Auth::user()->id;
            $campaing->save();

            $subject = $request->subject;
            $from = $request->email;
            $name = $request->name;
            $sum = 1;

            //return $request->copia;
            ProcessEmail::dispatch("Inicio ".$subject, $body, $request->copia, $from, $name, $request->copia,$campaing->id,$nameEmail)->delay(now()->addSeconds(1));
            //return "ok";
            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                    try {
                        if ($contact[4]) {
                            $delay = $delay + 0.16;
                            $email = $contact[4];
                            $user = $contact[0] . " " . $contact[1];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);

                            if (!$validator->fails()) {
                                 ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user,$campaing->id,$nameEmail)
                                 ->delay(now()->addSeconds($delay));
                                $sum++;

                            }
                        }
                        if ($contact[3]) {
                            $delay = $delay + 0.16;
                            $email = $contact[3];
                            $user = $contact[0] . " " . $contact[1];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);

                            if (!$validator->fails()) {
                                 ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user,$campaing->id,$nameEmail)
                                 ->delay(now()->addSeconds($delay));
                                $sum++;

                            }
                        }
                    } catch (Exception $e) {
                        //capturar error

                    }
                }
            }

             ProcessEmail::dispatch("Final ".$subject, $body, $request->copia, $from, $name, $request->copia,$campaing->id,$nameEmail)->delay(now()->addSeconds(1));

            //return $sum;
            return Redirect::to('/email')->with('data', "Campaña en cola de envio satisfactorio!");

        } else {
            return redirect::back()->withErrors("Error:ingrese correctamente el archivo .csv.");
        }
    }

    public function bounced(){
        $bounced=SendEmail::where("bounced",1)->select("to_email_address","bounced")->get();

        $delay=40;
        $suma=2;
        foreach($bounced as $b){
          $info[]= $b->to_email_address;
            $delay=$delay+$suma;
            ClearAgile::dispatch($b->to_email_address)->delay(now()->addSeconds($delay));
            $suma=$suma+1;
        }
        return $info;
    }
    public function complaint(){
        $complaint =SendEmail::where("complaint",1)->select("to_email_address")->get();
        return $complaint ;
    }

}
