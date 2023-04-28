<?php

namespace App\Http\Controllers;

use App\Models\SendEmail;
use App\Models\CampaingCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;
use Mail;
use DB;

class AmazonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function emailNotifications(Request $request)
    {
      //  Log::info(request()->json()->all());

        $data = $request->json()->all();

        if ($data['Type'] == 'SubscriptionConfirmation') {
            file_get_contents($data['SubscribeURL']);
        } elseif ($data['Type'] == 'Notification') {
            $message = json_decode($data['Message'], true);
            // Log::info($message);
            if ($message == 'test') {
                return response('OK', 200);
            }
            $message_id = $message['mail']['messageId'];
            switch ($message['eventType']) {
                case 'Bounce':
                    //$bounce = $message['bounce'];
                    $entrega = CampaingCustomer::where('aws_message_id', $message_id)->first();
                    $entrega->bounced = true;
                    $entrega->save();

                    $customer = Customer::where('id', $entrega->customer_id)->first();
                    $customer->bounced = true;
                    $customer->save();

                    $log =  DB::table('logs')->insert(
                        [
                        'name' => "Bounce",
                        'type' => "bounce",
                        'create_at' => date("Y-m-d h:i:s"),
                        ]
                    );

                    break;
                case 'Complaint':
                    //$complaint = $message['complaint'];
                    $entrega = CampaingCustomer::where('aws_message_id', $message_id)->first();
                    $entrega->complaint = true;
                    $entrega->save();

                    $customer = Customer::where('id', $entrega->customer_id)->first();
                    $customer->complaint = true;
                    $customer->save();

                    $log =  DB::table('logs')->insert(
                        [
                        'name' => "Complaint",
                        'type' => "complaint",
                        'create_at' => date("Y-m-d h:i:s"),
                        ]
                    );

                    break;
                case 'Open':
                    //$open = $message['open'];
                    $entrega = CampaingCustomer::where('aws_message_id', $message_id)->first();
                    $entrega->opened = true;
                    $entrega->save();

                    break;
                case 'Delivery':
                    //$delivery = $message['delivery'];
                    $entrega = CampaingCustomer::where('aws_message_id', $message_id)->first();
                    $entrega->delivered = true;
                    $entrega->save();

                    break;
                default:
                    // Do Nothing
                    break;
            }
        }

        return response('OK', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
