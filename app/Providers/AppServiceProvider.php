<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//procesando jobs
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::before(function (JobProcessing $event) {
           // DB::beginTransaction();
            /*
            $info=[
                "conection"=>$event->connectionName,
                "job"=>$event->job,
                "payload"=>$event->job->payload()
            ];
            */
/*
            $log=  DB::table('testemail')->insert(
                [
                'job' =>json_encode($event->job->payload()),
                'info'=>"antes",
                ]
            );
            */
            
           // DB::commit();
            
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
            /*
            $log=  DB::table('testemail')->insert(
                [
                'job' =>json_encode($event->job->payload()),
                'info'=>"despues",
                ]
            );
            */
            
        }); 
    }
}
