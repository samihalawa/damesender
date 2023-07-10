@extends('layouts.dashboard')

@section('header')
    AWS
@endsection('header')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Datos SMTP y SES</div>

                <!-- mostrar sucess -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                        <p>Para enviar correos a través de AWS SES, debe verificar el dominio y la dirección de correo electrónico en AWS SES.</p>
                        <p>Para verificar el dominio, debe crear un registro TXT en el DNS de su dominio.</p>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ url('setting') }}">
                        @csrf
                        <!-- mail_host -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">SMTP_MAIL_HOST</label>
                            <div class="col-md-6">
                                <input id="mail_host" type="text" class="form-control @error('mail_host') is-invalid @enderror" name="mail_host" value="{{$setting->mail_host}}" value="{{ old('mail_host') }}" required >
                                @error('mail_host')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- mail_port -->
                        <!--
                        <div class="form-group row" style='display:none'>
                            <label for="name" class="col-md-4 col-form-label text-md-right">mail_port</label>
                            <div class="col-md-6">
                                <input id="mail_port" type="text" class="form-control @error('mail_port') is-invalid @enderror" name="mail_port" value="{{ old('mail_port') }}" >
                                @error('mail_port')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        -->
                        <!-- mail_username -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">SMTP_mail_username</label>
                            <div class="col-md-6">
                                <input id="mail_username" type="text" class="form-control @error('mail_username') is-invalid @enderror" name="mail_username" value="{{$setting->mail_username}}" value="{{ old('mail_username') }}" >
                                @error('mail_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- mail_password -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">SMTP_mail_password</label>
                            <div class="col-md-6">
                                <input id="mail_password" type="text" class="form-control @error('mail_password') is-invalid @enderror" name="mail_password" value="{{$setting->mail_password}}" value="{{ old('mail_password') }}" >
                                @error('mail_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- mail_encryption -->
                        <!--
                        <div class="form-group row" style='display:none'>
                            <label for="name" class="col-md-4 col-form-label text-md-right">mail_encryption</label>
                            <div class="col-md-6">
                                <input id="mail_encryption" type="text" class="form-control @error('mail_encryption') is-invalid @enderror" name="mail_encryption" value="{{ old('mail_encryption') }}" required >
                                @error('mail_encryption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        -->

                        <!-- aws_access_key_id -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">AWS_ACCESS_KEY_ID</label>
                            <div class="col-md-6">
                                <input id="aws_access_key_id" type="text" class="form-control @error('aws_access_key_id') is-invalid @enderror" name="aws_access_key_id" value="{{$setting->aws_access_key_id}}" value="{{ old('aws_access_key_id') }}" required >
                                @error('aws_access_key_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- aws_secret_access_key -->
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">AWS_SECRET_ACCESS_KEY</label>
                            <div class="col-md-6">
                                <input id="aws_secret_access_key" type="text" class="form-control @error('aws_secret_access_key') is-invalid @enderror" name="aws_secret_access_key" value="{{$setting->aws_secret_access_key}}" value="{{ old('aws_secret_access_key') }}" required autocomplete="aws_secret_access_key" autofocus>
                                @error('aws_secret_access_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar Datos
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
