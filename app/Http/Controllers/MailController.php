<?php

namespace App\Http\Controllers;

use App\Mail\CustomMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class MailController extends Controller
{
    public function index() {
        $files = array_diff(scandir('../public/templates/img'), ['..', '.']);

        $templates = [];

        foreach ($files as $file) {
            $filename = str_replace('_' , ' ', explode('.', $file)[0]);
            
            $templates[] = [
                'dir' => 'templates/img/' . $file,
                'name' => $filename
            ];
        }
        
        return view('index', ['templates' => $templates]);
    }

    public function store(Request $request) {
        $filePath = $request->file('recipients')->getRealPath();

        $contacts = array_map('str_getcsv', file($filePath));

        if ($contacts) {            
            $data['body'] = ($request->type == 0? $request->content : $request->plain);
            $data['subject'] = $request->subject;
            $data['email'] = $request->email;
            $data['name'] = $request->name;
            
            foreach ($contacts as $index => $contact) {
                if ($index > 0) {
                    $data['recipient'] = $contact[4];
                    Mail::send(
                        [],
                        [],
                        function ($message) use ($data) {
                            $message->to($data['recipient'])
                            ->subject($data['subject'])
                            ->from($data['email'], $data['name'])
                            ->setBody($data['body'], 'text/html');
                        }
                    );
                }
            }

            if(count(Mail::failures()) > 0) {
                return redirect::back()->withErrors("Error sending mail.");
            } else {
                $data = 'Mail sent successfully!';
                return Redirect::to('/')->with('data', $data);
            }
        } else {
            return redirect::back()->withErrors("Error sending mail.");
        }
    }
}
