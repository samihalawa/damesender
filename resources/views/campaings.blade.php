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
                <th>Delivered </th>
                <th>Open</th>
                <th>bounced </th>
            </tr>
        </thead>
        <tbody>
             @forelse($campaings as $campaing)
            <tr>
                <th style="color:black" >{{ $campaing->name }}</th>
                <th style="color:black" >{{ General::getInfo($campaing->id) }}</th>
                <th style="color:black" >{{General::getDeliveri($campaing->id) }} </th>
                <th style="color:black" >{{General::getOpen($campaing->id) }}</th>
                <th style="color:black" >{{General::getBounced($campaing->id) }}</th>
                 
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
                <th>Bounced</th>

            </tr>
        </tfoot>
    </table>

    {{ $campaings->links() }}
@endsection
