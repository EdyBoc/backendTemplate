@extends('plantillas.acceso')

@section('titulo', 'Cambiar clave')

@section('contenido')
    <h1>Cambiar clave</h1>
    @if (auth()->user()->cambiarClave)
        <p class="textoAyuda">Debe cambiar la clave genérica antes de continuar.</p>
    @endif

    <form method="POST" action="{{ route('configuracion.guardarClave') }}">
        @csrf
        <div class="campo">
            <label for="claveActual">Clave actual</label>
            <input id="claveActual" name="claveActual" type="password" required>
        </div>
        <div class="campo">
            <label for="claveNueva">Clave nueva</label>
            <input id="claveNueva" name="claveNueva" type="password" required>
        </div>
        <div class="campo">
            <label for="claveNueva_confirmation">Confirmar clave nueva</label>
            <input id="claveNueva_confirmation" name="claveNueva_confirmation" type="password" required>
        </div>
        <button type="submit">Guardar clave</button>
    </form>
@endsection
