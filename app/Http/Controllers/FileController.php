<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\FileContact;
use App\Models\Campaign;
use Validator;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // listado de archivos

        $files = File::paginate(10);
        return view('files.index', compact('files'));
    }

    public function estadisticas()
    {
        $campaings = Campaign::orderBy("id", "desc")->paginate(10);

        return view('campaignew', compact('campaings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required|file|mimes:csv,txt|max:32768',
        ]);
        $file = $request->file('file');
        $name = time() . date("Y-h-i") . $file->getClientOriginalName();
        $file->move(public_path() . '/files/', $name);

        $_file = new File();
        $_file->name = $request->name . date("Y-h-i");
        $_file->tipo = $request->file->getClientOriginalExtension();
        $_file->ubicacion = public_path() . '/files/' . $name;
        $_file->save();

        // leer archivo . csc
        $file = fopen(public_path() . '/files/' . $name, "r");
        // guardar archivo
        $i = 0;
        while (($datos = fgetcsv($file, 1000, ",")) !== false) {
            $i++;
            if ($i > 1) {
                $this->validaLinea($datos, $_file->id);
            }
        }

        return redirect()->route('archivos.index')
            ->with('success', 'File created successfully.');
    }

    public function validaLinea($info, $id)
    {
        $count = 0;
        $count = count($info);
        //$count = 10;
        for ($i = $count; $i >= 1; $i--) {
            $email = $info[$i - 1];
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email',
            ]);

            if (!$validator->fails()) {
                $user = explode("@", $email);
                $user = $user[0];
                $file_contact = new FileContact();
                    $file_contact->email = $email;
                    $file_contact->name = $user;
                    $file_contact->file_id = $id;
                $file_contact->save();
            }
        }

        //return $info;
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
        $file = File::find($id);
        if ($file) {
            // borrar archivo
            unlink($file->ubicacion);
            $file->delete();
            return redirect()->route('archivos.index')
            ->with('success', 'File deleted successfully.');
        }
    }
}
