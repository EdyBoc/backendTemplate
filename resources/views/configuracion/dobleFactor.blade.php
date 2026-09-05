@extends('plantillas.principal')

@section('titulo', 'Doble factor')

@section('contenido')
    <h1>Autenticación de doble factor</h1>

    @if ($usuario->dobleFactorHabilitado)
        <p>El doble factor está activado.</p>
        <form method="POST" action="{{ route('dobleFactor.desactivar') }}">
            @csrf
            <div class="campo">
                <label for="claveActual">Clave actual</label>
                <input id="claveActual" name="claveActual" type="password" required>
            </div>
            <button class="botonPeligro" type="submit">Desactivar doble factor</button>
        </form>
    @else
        <p class="textoAyuda">Agregue una cuenta TOTP en Google Authenticator, Microsoft Authenticator u otra aplicación compatible.</p>
        <div class="campo">
            <label>Clave secreta</label>
            <span class="codigo">{{ $secretoTemporal }}</span>
        </div>
        <div class="campo">
            <label>URI de configuración</label>
            <span class="codigo">{{ $uriConfiguracion }}</span>
        </div>
        <form method="POST" action="{{ route('dobleFactor.activar') }}">
            @csrf
            <div class="campo">
                <label for="codigo">Código de 6 dígitos</label>
                <input id="codigo" name="codigo" inputmode="numeric" maxlength="6" required>
            </div>
            <button type="submit">Activar doble factor</button>
        </form>
    @endif
@endsection
