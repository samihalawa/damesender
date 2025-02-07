<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\CrmAgile;
use DB;

class ClearAgile implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $crm = new CrmAgile();
         $response = $crm->searchPerson($this->email);

        if ($response) {
            $deleta = $crm->deletePerson($response->id);
            $log =  DB::table('logs')->insert(
                [
                'name' => "delete bounced" . $this->email,
                'type' => "delete",
                'create_at' => date("Y-m-d h:i:s"),
                ]
            );
        }
    }
}
