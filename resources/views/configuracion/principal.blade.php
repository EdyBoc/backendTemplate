@extends('plantillas.principal')

@section('titulo', 'Configuración')

@section('contenido')
    <h1>Configuración</h1>
    <div class="acciones">
        <a class="boton" href="{{ route('configuracion.cambiarClave') }}">Cambiar clave</a>
        <a class="boton" href="{{ route('dobleFactor') }}">Autenticación de doble factor</a>
    </div>
@endsection
