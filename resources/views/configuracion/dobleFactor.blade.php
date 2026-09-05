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
        <p class="textoAyuda">
            Escanee el código QR con Google Authenticator,
            Microsoft Authenticator u otra aplicación compatible.
        </p>

        <div class="contenedorQr">
            <img
                class="imagenQr"
                src="{{ $codigoQr }}"
                alt="Código QR para configurar la autenticación de doble factor"
                width="260"
                height="260"
            >
        </div>

        <div class="configuracionManual">
            <p class="tituloConfiguracionManual">
                ¿No puede escanearlo?
            </p>

            <div class="campo">
                <label>Clave secreta</label>
                <span class="codigo">{{ $secretoTemporal }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('dobleFactor.activar') }}">
            @csrf

            <div class="campo">
                <label for="codigo">Código de 6 dígitos</label>

                <input
                    id="codigo"
                    name="codigo"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    required
                >
            </div>

            <button type="submit">
                Activar doble factor
            </button>
        </form>
    @endif
@endsection
