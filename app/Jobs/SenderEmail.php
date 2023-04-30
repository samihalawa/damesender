<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ProcessEmail;
use App\Models\Customer;
use App\Models\CampaingCustomer;
use App\Models\FileContact;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SenderEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public const PAGINATE = 3000;
    //public const PAGINATE = 1;
    public const MAX_EMAILS_SENDER = 5;

    public $timeout = 2400;

    protected $subject;
    protected $body;
    protected $from;
    protected $name;
    protected $campaign;
    protected $file;
    protected $sendDate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $from, $name, $campaign, $file, $sendDate)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->from = $from;
        $this->name = $name;
        $this->campaign = $campaign;
        $this->file = $file;
        $this->sendDate = $sendDate;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Log::info('from: ' . $this->from);
        //Log::info('body: ' . $this->body);
        //Log::info('name: ' . $this->name);
        //Log::info('subject: ' . $this->subject);
        //Log::info('nacampaignme: ' . $this->campaign);
        //Log::info('file: ' . $this->file);
        //Log::info('date: ' . $this->sendDate);

        $contactos = FileContact::select("email", "name")->where('file_id', $this->file)->paginate(self::PAGINATE, ['*'], 'page', 1);

        $total = $contactos->total();

        $cont = 1;
        $add = 1;
        foreach ($contactos as $contact) {
            if ($cont >= self::MAX_EMAILS_SENDER) {
                $cont = 1;
                //$add++;
                $this->sendDate = $this->sendDate->addSeconds($add);
            }
            //Log::info('cont: ' . $cont);
            $this->verifica($contact, $this->campaign, $this->sendDate, $this->body, $this->subject, $this->from, $this->name);
            $cont++;
        }

        if ($total <= self::PAGINATE) {
            return 1;
        }

        $total = $total - self::PAGINATE;
        $paginas = $total / self::PAGINATE;
        $paginas = ceil($paginas);
        for ($i = 2; $i <= $paginas; $i++) {
            sleep(1);
            $contactos = FileContact::select("email", "name")->where('file_id', $this->file)->paginate(self::PAGINATE, ['*'], 'page', $i);
            foreach ($contactos as $contact) {
                if ($cont >= self::MAX_EMAILS_SENDER) {
                    $cont = 1;
                    //$add++;
                    $this->sendDate = $this->sendDate->addSeconds($add);
                }
                //Log::info('cont: ' . $cont);
                $this->verifica($contact, $this->campaign, $this->sendDate, $this->body, $this->subject, $this->from, $this->name);
                $cont++;
            }
        }
    }

    /**
     * Verifica el envio
     *
     * @param contact contacto a verificar
     * @param $campaign id de la campana
     * @param $sendDate fecha de envio
     * @param $body cuerpo del email
     * @param $subject asunto del email
     * @param $from email de envio
     * @param $name nombre de la campana
     */
    public function verifica($contact, $campaign, $sendDate, $body, $subject, $from, $name)
    {
        //Log::info('date: ' . $sendDate);
        $customer = Customer::select('first_name', 'email', 'id', 'bounced', 'unsuscribe', 'complaint')
            ->where('email', $contact->email)
            ->first();
        //Log::info($customer);
        if ($customer) {
            if (($customer->bounced) || ($customer->unsuscribe) || ($customer->complaint)) {
                // no envia el email
                //Log::info("no envio por bounced, complaint");
                return 0;
            }
        } else {
            // crea el customer
            $customer = new Customer();
            $customer->email = $contact->email;
            $customer->first_name = $contact->name ?? "";
            $customer->save();
        }

        $guardar = new CampaingCustomer();
        $guardar->campaign_id = $campaign->id;
        $guardar->customer_id = $customer->id;
        $guardar->aws_message_id = "";
        $guardar->sent = 1;
        $guardar->hash = "";
        $guardar->save();

        $user = $contact->name ?? "";
        $email = $contact->email;
        $nameEmail = $campaign->name;
        // envio local
        //date_default_timezone_set('America/Caracas');
        //$sendDate = Carbon::now();

        ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaign->id, $nameEmail, $guardar->id)
            ->delay($sendDate);
    }
}
