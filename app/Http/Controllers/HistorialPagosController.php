<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HistorialPagosController extends Controller
{
    public function index()
    {
        /*
        $id =Auth::user()->id;
        if(Auth::user()->type == 'Cliente'){
            $historial = DB::table('users')
            ->join('payments','payments.user_id','users.id')
            ->join('services','services.id','payments.service_id')
        ->select('users.name as nombreUsuario','users.phone','users.email','payments.quantity',
        'method_of_payment as MethodsOfPayments','services.name','requested_amount')
        ->where('users.id',$id)->where('gift_service','0')->get();
        }else{
            $historial = DB::table('users')
            ->join('payments','payments.user_id','users.id')
            ->join('services','services.id','payments.service_id')
            ->select('users.name as nombreUsuario','users.phone','users.email','payments.quantity',
            'method_of_payment as MethodsOfPayments','services.name','requested_amount')
            ->where('gift_service','0')->get();
        }*/
        $historial = [];

        return view("historial_payment", compact('historial'));
    }
}
