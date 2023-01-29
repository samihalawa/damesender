<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //  $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('index');
  }

  public function sendEmail(Request $request)
  {
    $email = 'chenggong2649@gmail.com';
    //$email='houltman@gmail.com';
    try {
      $info = (object) [
        'to_email_address' => $email,
        'subject'          => "My offer for Domain " . $request->domain,
        'infofrom'         => 'info@damesender.com',
        'infoname'         => $request->name,
        'body'             => "My offer for Domain",

      ];

      Mail::send("emails.domain", ['name' => $request->name, 'email' => $request->email, 'domain' => $request->domain, 'phone' => $request->phone, 'price' => $request->price, 'comments' => $request->comments], function ($message) use (&$headers, $info) {
        $message->to($info->to_email_address)
          ->from($info->infofrom, $info->infoname)
          ->subject($info->subject);
        $headers = $message->getHeaders();
      });
      return ["success" => 'ok'];

    } catch (Exception $e) {
      return ["success" => 'error'];
    }

  }
}
