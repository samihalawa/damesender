<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountSMSAndEmailsController extends Controller
{
    public function index(Request $request){
        
        $gift = DB::table('services')
        ->join('user_services','user_services.services_id', 'services.id')
        ->join('users','users.id','user_services.users_id')
        ->select('users.name as nombreUsuario','users.phone','users.email','services.name','user_services.requested_amount')
        ->where('gift_service','1')
        ->get();

        return view('sms_emails', compact('gift'));
    }
}
