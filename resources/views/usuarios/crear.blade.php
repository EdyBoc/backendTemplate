@extends('plantillas.principal')

@section('titulo', 'Crear usuario')

@section('contenido')
    <h1>Crear usuario</h1>
    <p class="textoAyuda">El usuario se creará con la clave genérica configurada en el archivo .env y deberá cambiarla en su primer acceso.</p>

    <form method="POST" action="{{ route('usuarios.guardar') }}">
        @csrf
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="campo">
            <label for="correoElectronico">Correo electrónico</label>
            <input id="correoElectronico" name="correoElectronico" type="email" value="{{ old('correoElectronico') }}" required>
        </div>
        <button type="submit">Crear usuario</button>
    </form>
@endsection
