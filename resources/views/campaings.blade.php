@extends('layouts.dashboard')

@section('header')
    Campaigs
@endsection('header')

@section('content')
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Campaña</th>
                <th>Send</th>
                <th>Delibery</th>
                <th>Open</th>
            </tr>
        </thead>
        <tbody>
             @forelse($campaings as $campaing)
            <tr>
                <th style="color:black" >{{ $campaing->name }}</th>
                <th style="color:black" >{{ $campaing->sends->count() }}</th>
                <th style="color:black" ></th>
                <th style="color:black" ></th>
            </tr>
            @empty
            <h1>No hay registros</h1>
            @endforelse 
        </tbody>
        <tfoot>
            <tr>
                <th>Campaña</th>
                <th>Send</th>
                <th>Delibery</th>
                <th>Open</th>

            </tr>
        </tfoot>
    </table>
@endsection
