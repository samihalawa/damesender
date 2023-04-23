@extends('layouts.dashboard')

@section('header')
    Files
@endsection('header')

<!-- link subir archivo -->

@section('content')
<a href="{{ route('archivos.create') }}" class="btn btn-primary">Subir Archivo</a>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicacion</th>
                <th>Contactos </th>
            </tr>
        </thead>
        <tbody>
             @forelse($files as $file)
            <tr>
                <th style="color:black" >{{$file->name }}</th>
                <th style="color:black" >{{$file->ubicacion}}</th>
                <th style="color:black" >{{General::getCountFile($file->id) }} </th>
            </tr>
            @empty
            <h1>No hay registros</h1>
            @endforelse 
        </tbody>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Ubicacion</th>
                <th>Contactos</th>
            </tr>
        </tfoot>
    </table>

    {{ $files->links() }}
@endsection
