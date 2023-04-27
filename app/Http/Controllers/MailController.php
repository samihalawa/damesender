<?php

/**
 * Created by ProcessEmail
 */

namespace App\Http\Controllers;

use App\CrmAgile;
use App\Http\Requests\MailRequest;
use App\Jobs\ClearAgile;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessNotification;
use App\Models\Campaign;
use App\Models\SendEmail;
use App\Models\UserEmail;
use App\Models\FileContact;
use App\Models\Customer;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;

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

    public function verifica($info)
    {
        foreach ($info as $x) {
            $email = $x->to_email_address;
            try {
                $customer = new Customer();
                $customer->email = $email;
                $customer->bounced = $x->bounced;
                $customer->complaint = $x->complaint;
                $customer->unsuscribe = $x->unsuscribe;
                $customer->save();
            } catch (Exception $e) {
                if ($x->bounced) {
                    $customer = Customer::where('email', $email)->first();
                    $customer->bounced = $x->bounced;
                    $customer->save();
                }
                if ($x->complaint) {
                    $customer = Customer::where('email', $email)->first();
                    $customer->complaint = $x->complaint;
                    $customer->save();
                }
                if ($x->unsuscribe) {
                    $customer = Customer::where('email', $email)->first();
                    $customer->unsuscribe = $x->unsuscribe;
                    $customer->save();
                }
                //echo json_encode($e->getMessage());
            }
            //break;
        }
    }

    public function sendTest()
    {
        $paginator = 500;
        // count get page total
        $get = SendEmail::select('to_email_address', 'bounced', 'complaint', 'unsuscribe')->paginate($paginator, ['*'], 'page', 1);

        $total = $get->total();
        $paginas = ceil($total / $paginator);

        $this->verifica($get);

        for ($i = 2; $i <= $paginas; $i++) {
            $get = SendEmail::select('to_email_address', 'bounced', 'complaint', 'unsuscribe')->paginate($paginator, ['*'], 'page', $i);
            $this->verifica($get);
        }

        return $paginas;

        // page next
        $get = SendEmail::select('to_email_address', 'bounced', 'complaint', 'unsuscribe')->paginate(500, ['*'], 'page', 2);

        // page next
        $get = SendEmail::select('to_email_address', 'bounced', 'complaint', 'unsuscribe')->paginate(500, ['*'], 'page', 3);
        //pagina siguiente
        $get = SendEmail::select('to_email_address', 'bounced', 'complaint', 'unsuscribe')->paginate(500, ['*'], 'page', 4);

        return $get;
        $unsuscribe = SendEmail::where(function ($query) {
            $query->orWhere('unsuscribe', 1)
                ->orWhere('bounced', 1);
        })
            ->orderby("created_at", "desc")
            ->paginate(200);

        foreach ($unsuscribe as $x) {
            try {
                $user = DB::table('send_emails')
                    ->where('to_email_address', $x->to_email_address)
                    ->where("id", "<>", $x->id)
                    ->delete();
            } catch (Exception $e) {
                echo "error";
            }
        }

        return "ok";

        //return $unsuscribe;

        return "true";

        ClearAgile::dispatch('kndasdnasdk@gmail.com')->delay(now()->addSeconds(2));
        //return "ok";
        $crm = new CrmAgile();
        //$response = $crm->contacts();
        $response = $crm->searchPerson("kndasdnasdk@gmail.com");

        if ($response) {
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

        $email   = "houltman@gmail.com";
        $user    = "Gabriel Houltman";
        $subject = "Este año Black Friday y Navidad los presentamos juntos la primera semana del año";
        $body    = "Prueba beanstalkd y ses notification";
        $from    = "atencion@megacursos.com";
        $name    = "Megacursos";
        //envio de email por colas
        $delay    = 5;
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

        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user)
            ->delay(now()->addSeconds($delay + 5));

        return "ok";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        date_default_timezone_set('Europe/Madrid');

        $files     = array_diff(scandir('../public/templates/img'), ['..', '.']);
        $emails    = UserEmail::where('status', 1)->get();
        $templates = [];

        foreach ($files as $file) {
            $filename = str_replace('_', ' ', explode('.', $file)[0]);

            $templates[] = [
                'dir'  => 'templates/img/' . $file,
                'name' => $filename,
            ];
        }

        return view('mail', ['templates' => $templates, 'emails' => $emails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(MailRequest $request)
    {
        $filePath = $request->file('recipients')->getRealPath();
        $contacts = array_map('str_getcsv', file($filePath));
        $sendDate = Carbon::createFromDate($request->datetime);
        //$sendDate = Carbon::now();
        date_default_timezone_set('Europe/Madrid');

        $date = date("Y-m-d H:i:s");
        $now  = Carbon::createFromDate($date);

        if ($sendDate < $now) {
            return redirect::back()->withErrors("Error:en fecha zona Europa/Madrid, debe ser mayor que " . Carbon::now());
        }
        $delay = 10;

        if ($contacts) {
            $body = ($request->type == 0 ? $request->content : $request->plain);

            $campaingx = str_replace(" ", "", $request->campaing);
            $campaingx = str_replace(".", "", $campaingx);
            $nameEmail = $campaingx . "-" . date("Y-m-d h:i:s");
            $nameEmail = str_replace(" ", "", $nameEmail);
            $nameEmail = str_replace("/", "S", $nameEmail);
            $path      = base_path('resources/views/emails/' . $nameEmail . '.blade.php');
            $file      = fopen($path, "a+");
            fputs($file, $body);
            fclose($file);
            $campaing          = new Campaign();
            $campaing->name    = $nameEmail;
            $campaing->tipo    = "Email";
            $campaing->user_id = Auth::user()->id;
            $campaing->save();
            $subject = $request->subject;
            $from    = $request->email;
            $name    = $request->name;
            $sum     = 1;

            ProcessEmail::dispatch("Inicio " . $subject, $body, $request->copia, $from, $name, $request->copia, $campaing->id, $nameEmail)
                ->delay($sendDate->addSeconds(1));

            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                    try {
                        if (isset($contact[0])) {
                            $delay     = $delay + 0.18;
                            $email     = $contact[0];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);
                            if (!$validator->fails()) {
                                // explode email
                                $user = explode("@", $email);
                                $user = $user[0];
                                ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaing->id, $nameEmail)
                                    ->delay($sendDate->addSeconds($delay));
                                $sum++;
                                continue;
                            }
                        }
                        if (isset($contact[1])) {
                            $delay     = $delay + 0.16;
                            $email     = $contact[1];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);
                            if (!$validator->fails()) {
                                $user = explode("@", $email);
                                $user = $user[0];
                                ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaing->id, $nameEmail)
                                    ->delay($sendDate->addSeconds($delay));
                                $sum++;
                                continue;
                            }
                        }
                        if (isset($contact[2])) {
                            $delay     = $delay + 0.16;
                            $email     = $contact[2];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);
                            if (!$validator->fails()) {
                                $user = explode("@", $email);
                                $user = $user[0];
                                ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaing->id, $nameEmail)
                                    ->delay($sendDate->addSeconds($delay));
                                $sum++;
                                continue;
                            }
                        }
                        if (isset($contact[3])) {
                            $delay     = $delay + 0.16;
                            $email     = $contact[3];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);
                            if (!$validator->fails()) {
                                $user = explode("@", $email);
                                $user = $user[0];
                                ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaing->id, $nameEmail)
                                    ->delay($sendDate->addSeconds($delay));
                                $sum++;
                                continue;
                            }
                        }
                        if (isset($contact[4])) {
                            $delay     = $delay + 0.16;
                            $email     = $contact[4];
                            $validator = Validator::make(['email' => $email], [
                                'email' => 'required|email',
                            ]);

                            if (!$validator->fails()) {
                                $user = explode("@", $email);
                                $user = $user[0];
                                ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaing->id, $nameEmail)
                                    ->delay($sendDate->addSeconds($delay));
                                continue;
                                $sum++;
                            }
                        }

                        //$sendDate = $sendDate->addSeconds(1);
                    } catch (Exception $e) {
                        //echo json_encode($e->getMessage());
                        //capturar error
                    }
                }
            }

            ProcessEmail::dispatch("Final " . $subject, $body, $request->copia, $from, $name, $request->copia, $campaing->id, $nameEmail)
                ->delay($sendDate->addSeconds($delay));

            return Redirect::to('/email')->with('data', "Campaña en cola de envio satisfactorio!");
        } else {
            return redirect::back()->withErrors("Error:ingrese correctamente el archivo .csv.");
        }
    }

    public function bounced()
    {
        $bounced = SendEmail::where("bounced", 1)->select("to_email_address", "bounced")->get();

        $delay = 40;
        $suma  = 2;
        foreach ($bounced as $b) {
            $info[] = $b->to_email_address;
            $delay  = $delay + $suma;
            ClearAgile::dispatch($b->to_email_address)->delay(now()->addSeconds($delay));
            $suma = $suma + 1;
        }
        return $info;
    }
    public function complaint()
    {
        $complaint = SendEmail::where("complaint", 1)->select("to_email_address")->get();
        return $complaint;
    }
}
