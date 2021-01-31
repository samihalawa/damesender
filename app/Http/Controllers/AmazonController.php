<?php

namespace App\Http\Controllers;

use App\Models\SendEmail;
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
                    $bounce = $message['bounce'];
                    $email = SendEmail::where('aws_message_id', $message_id)->first();
                    $email->bounced = true;
                    $email->save();
                    // foreach ($bounce['bouncedRecipients'] as $bouncedRecipient){
                    //     $emailAddress = $bouncedRecipient['emailAddress'];
                    //     $emailRecord = WrongEmail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Bounce']);
                    //     if($emailRecord){
                    //         $emailRecord->increment('repeated_attempts',1);
                    //     }
                    // }
                    break;
                case 'Complaint':
                    $complaint = $message['complaint'];
                    $email = SendEmail::where('aws_message_id', $message_id)->first();
                    $email->complaint = true;
                    $email->save();
                    // foreach($complaint['complainedRecipients'] as $complainedRecipient){
                    //     $emailAddress = $complainedRecipient['emailAddress'];
                    //     $emailRecord = WrongEmail::firstOrCreate(['email' => $emailAddress, 'problem_type' => 'Complaint']);
                    //     if($emailRecord){
                    //         $emailRecord->increment('repeated_attempts',1);
                    //     }
                    // }
                    break;
                case 'Open':
                    $open = $message['open'];
                    $email = SendEmail::where('aws_message_id', $message_id)->first();
                    $email->opened = true;
                    $email->save();
                    break;
                case 'Delivery':
                    $delivery = $message['delivery'];
                    $email = SendEmail::where('aws_message_id', $message_id)->first();
                    $email->delivered = true;
                    $email->save();
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
