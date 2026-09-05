@extends('plantillas.acceso')

@section('titulo', 'Ingresar correo')

@section('contenido')
    <h1>Acceso</h1>
    <p class="textoAyuda">Ingrese su correo electrónico para continuar.</p>

    <form method="POST" action="{{ route('acceso.validarCorreo') }}">
        @csrf
        <div class="campo">
            <label for="correoElectronico">Correo electrónico</label>
            <input id="correoElectronico" name="correoElectronico" type="email" value="{{ old('correoElectronico') }}" required autofocus>
        </div>
        <button type="submit">Continuar</button>
    </form>
@endsection
