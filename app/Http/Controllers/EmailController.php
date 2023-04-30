<?php

namespace App\Http\Controllers;

use App\Models\UserEmail;
use Illuminate\Http\Request;
use Redirect;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roledSMS');
    }

    public function index()
    {
        // return "si";
        $emails = UserEmail::all();

        return view("email-sender", compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("email-sender-create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada
        $this->validate($request, [
            'email' => 'required|email|unique:user_emails|max:255',
        ]);

        $sender          = new UserEmail();
        $sender->email    = $request->email;
        $sender->save();

        return Redirect::to('/emails')->with('data', "Email Gardado correctamente!");
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
        $sender = UserEmail::find($id);
        if ($sender) {
            return view("email-sender-update", compact('sender'));
        }

        return Redirect::to('/emails')->with('data', "Email Gardado correctamente!");
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
        $sender = UserEmail::find($id);

        if ($sender) {
            $sender->email    = $request->email;
            $sender->status   = $request->status ? 1 : 0;
            $sender->save();

            return Redirect::to('/emails')->with('data', "Actualización correcta");
        }
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
