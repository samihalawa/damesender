@extends('layouts.dashboard')

@section('header')
    Subir Archivos
@endsection('header')

<!-- link subir archivo -->

@section('content')
    <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre del archivo" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Nombre del archivo</small>
        </div>
        <!--
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Tipo de archivo" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Tipo de archivo</small>
        </div>
        -->
        <!--
        <div class="form-group">
            <label for="ubicacion">Ubicacion</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control" placeholder="Ubicacion del archivo" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Ubicacion del archivo</small>
        </div>
        -->
        <div class="form-group">
            <label for="file">Archivo</label>
            <input type="file" name="file" id="file" accept=".csv" class="form-control" placeholder="Archivo" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Archivo</small>
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>
@endsection
