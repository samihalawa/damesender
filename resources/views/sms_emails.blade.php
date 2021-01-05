@extends('layouts.dashboard')

@section('content')
   <p> Cantidad de SMS: {{ $contadorSMS }}<br>
    Cantidad de Emails: {{ $contadorEmail }}<br>
    </p>
@endsection
