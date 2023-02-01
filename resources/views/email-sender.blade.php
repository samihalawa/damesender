@extends('layouts.dashboard')

@section('header')
    Users
@endsection('header')

@section('content')
<a class="btn btn-link" href="{{ route('emails.create') }}">
    Crear Nuevo email dinámico 
</a>
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Email</th>
                <th>Status</th>
                <th>Accion</th>
            </tr>
        </thead>
        
        <tbody>
            @forelse($emails as $email)
            <tr>
                <th>{{ $email->email }}</th>
                <th>{{ $email->status }}</th>
                <th>
                    <a class="btn" href="/emails/{{$email->id}}/edit">Editar</a>
                   
                </th>
            </tr>
            @empty
            <h1>No hay registros</h1>
            @endforelse
        </tbody>

    </table>
                                    
@endsection