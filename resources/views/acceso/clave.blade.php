@extends('plantillas.acceso')

@section('titulo', 'Ingresar clave')

@section('contenido')
    <h1>Ingresar clave</h1>
    <p class="textoAyuda">{{ $correoElectronico }}</p>

    <form method="POST" action="{{ route('acceso.iniciarSesion') }}">
        @csrf
        <div class="campo">
            <label for="clave">Clave</label>
            <input id="clave" name="clave" type="password" required autofocus>
        </div>
        <button type="submit">Ingresar</button>
        <a class="boton botonSecundario" href="{{ route('acceso.correo') }}">Cambiar correo</a>
    </form>
@endsection
