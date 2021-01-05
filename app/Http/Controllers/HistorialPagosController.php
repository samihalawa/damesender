<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistorialPagosController extends Controller
{
    public function index(){

        return view("historial_payment");
    }
}
