<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEmail;

use App\CrmAgile;

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
         //$response = $crm->contacts();
         $response = $crm->searchPerson($email);

         if($response){
             //return $response->id;
            $deleta = $crm->deletePerson($response->id);
            return json_encode($response);
         }
         return abort(404);
    }

    public function unsuscribe($campaing=null,$code=null){

        
       $email=SendEmail::select("to_email_address")->where(['campaing_id'=>$campaing,"hash"=>$code])->first();

       if($email){

          return view('unsuscribe', ['email' => $email]);

       }else{

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
    public function store(Request $request)
    {
        //
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
