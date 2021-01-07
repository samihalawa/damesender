@extends('layouts.dashboard')

@section('header')
    Free SMS & Emails
@endsection('header')

@section('content')
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Servicio</th>
                <th>Cantidad requerida</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gift as $item)
            <tr>
                <th style="color:black" >{{ $item->nombreUsuario }}</th>
                <th style="color:black" >{{ $item->phone }}</th>
                <th style="color:black" >{{ $item->email }}</th>
                <th style="color:black" >{{ $item->name }}</th>
                <th style="color:black" >{{ $item->requested_amount }}</th>
            </tr>
            @empty
            <h1>No hay registros</h1>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Servicio</th>
                <th>Cantidad requerida</th>
                
            </tr>
        </tfoot>
    </table>
@endsection
