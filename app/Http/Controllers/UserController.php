<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $usuario = User::get();
        return view('users', compact('usuario'));
    }
}
