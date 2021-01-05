@extends('layouts.dashboard')

@section('content')

<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuario as $item)
            <tr>
                <th>{{ $item->name }}</th>
                <th>{{ $item->email }}</th>
                <th>{{ $item->phone }}</th>
            </tr>
            @empty
            <h1>No hay registros</h1>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                
            </tr>
        </tfoot>
    </table>
                                    
@endsection