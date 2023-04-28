<?php

namespace App\Http\Controllers;

use App\CrmAgile;
use App\Http\Requests\UnsuscribeRequest;
use App\Models\SendEmail;
use DB;
use Illuminate\Http\Request;

class UnsuscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteEmail($email)
    {

        $crm = new CrmAgile();
        $tags = ["unsuscribe"];
        $tag = json_encode($tags);
        $response = $crm->add_agiletags($email, $tag);

        return view("end");

        return abort(404);
    }

    public function index($campaing = null, $code = null)
    {

        $email = SendEmail::select("to_email_address")->where(['campaing_id' => $campaing, "hash" => $code])->first();

        if ($email) {
            return view('unsuscribe', ['campaing' => $campaing, "code" => $code]);
        } else {
            return abort(404);
        }
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
    public function unsuscribe(UnsuscribeRequest $request)
    {
        $email = SendEmail::select("to_email_address", "id")->where(['campaing_id' => $request->campaing, "hash" => $request->code])->first();

        if ($email) {
            $affected = DB::table('send_emails')
                ->where('id', $email->id)
                ->update(['unsuscribe' => true]);

            $crm = new CrmAgile();
            $tags = ["unsuscribe", $request->motive];
            $tag = json_encode($tags);

            $response = $crm->add_agiletags($email->to_email_address, $tag);

            return view("end");
        } else {
            return redirect()->back();
        }
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
