<?php

/**
 * Sender
 *
 * Envia los emails
 */

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SenderEvent;
use Illuminate\Support\Facades\Log;
use App\Models\FileContact;
use App\Models\CampaingCustomer;
use App\Models\Customer;
use App\Jobs\ProcessEmail;
use Carbon\Carbon;

class Sender implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    //use InteractsWithQueue;

    public const MAX_EMAILS_SENDER = 10; // maximo de emails por segundo

    public const PAGINATE = 1000; // cantidad de emails por pagina

    //protected $from;

    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SenderEvent $event)
    {

        Log::info('from: ' . $this->from);
        Log::info('body: ' . $event->body);
        Log::info('name: ' . $event->name);
        Log::info('subject: ' . $event->subject);
        Log::info('nacampaignme: ' . $event->campaign);
        Log::info('file: ' . $event->file);

        $this->file_id = $event->file;

        $contactos = FileContact::select("email", "name")->where('file_id', $this->file)->paginate(self::PAGINATE, ['*'], 'page', 1);

        $total = $contactos->total();
        $senDate = $event->senDate;

        $cont = 1;
        $add = 1;
        foreach ($contactos as $contact) {
            if ($cont >= self::MAX_EMAILS_SENDER) {
                $cont = 1;
                //$add++;
                $senDate = $senDate->addSeconds($add);
            }
            //Log::info('cont: ' . $cont);
            $this->verifica($contact, $event->campaign, $senDate, $event->body, $event->subject, $event->from, $event->name);
            $cont++;
        }

        $total = $total - self::PAGINATE;
        $paginas = $total / self::PAGINATE;
        $paginas = ceil($paginas);
        for ($i = 2; $i <= $paginas; $i++) {
            sleep(1);
            $contactos = FileContact::select("email", "name")->where('file_id', $event->file_id)->paginate(self::PAGINATE, ['*'], 'page', $i);
            foreach ($contactos as $contact) {
                if ($cont >= self::MAX_EMAILS_SENDER) {
                    $cont = 1;
                    //$add++;
                    $senDate = $senDate->addSeconds($add);
                }
                //Log::info('cont: ' . $cont);
                $this->verifica($contact, $event->campaign, $senDate, $event->body, $event->subject, $event->from, $event->name);
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
        Log::info('date: ' . $sendDate);
        $customer = Customer::select('first_name', 'email', 'id', 'bounced', 'unsuscribe', 'complaint')
            ->where('email', $contact->email)
            ->first();
        //Log::info($customer);
        if ($customer) {
            if (($customer->bounced) || ($customer->unsuscribe) || ($customer->complaint)) {
                // no envia el email
                Log::info("no envio por bounced, complaint");
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

        //ProcessEmail::dispatch($subject, $body, $email, $from, $name, $user, $campaign->id, $nameEmail, $guardar->id)
          //  ->delay($sendDate);
    }
}
