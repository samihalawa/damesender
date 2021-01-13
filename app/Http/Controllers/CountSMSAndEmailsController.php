<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CountSMSAndEmailsController extends Controller
{

   
    public function index(Request $request){
        $id =Auth::user()->id;
        if(Auth::user()->type == 'Cliente'){
            $gift = DB::table('users')
            ->join('payments','payments.user_id','users.id')
            ->join('services','services.id','payments.service_id')
        ->select('users.name as nombreUsuario','users.phone','users.email','services.name','requested_amount')
        ->where('users.id',$id)->where('gift_service','1')->get();
        }else{
            $gift = DB::table('users')
            ->join('payments','payments.user_id','users.id')
            ->join('services','services.id','payments.service_id')
        ->select('users.name as nombreUsuario','users.phone','users.email','services.name','requested_amount')
        ->where('users.id',$id)->where('gift_service','1')->get();
        }

        return view('sms_emails', compact('gift'));
    }
}
