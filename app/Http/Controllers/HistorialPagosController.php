<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialPagosController extends Controller
{
    public function index(){
        $historial = DB::table('services')
        
        ->join('user_services','user_services.services_id','services.id')
        ->join('users','users.id','user_services.users_id')
        ->join('payments','payments.users_id','users.id')
        ->join('methods_of_payments','methods_of_payments.id','payments.methods_of_payments_id')
        ->select('users.name as nombreUsuario','users.phone','users.email','payments.quantity',
        'methods_of_payments.name as MethodsOfPayments','services.name','user_services.requested_amount')
        ->where('gift_service','0') ->get();
        return view("historial_payment",compact('historial'));
    }
}
