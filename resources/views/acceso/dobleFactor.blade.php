@extends('plantillas.acceso')

@section('titulo', 'Doble factor')

@section('contenido')
    <h1>Autenticación de doble factor</h1>
    <p class="textoAyuda">Ingrese el código de 6 dígitos de su aplicación autenticadora.</p>

    <form method="POST" action="{{ route('dobleFactor.validar') }}">
        @csrf
        <div class="campo">
            <label for="codigo">Código</label>
            <input id="codigo" name="codigo" inputmode="numeric" maxlength="6" required autofocus>
        </div>
        <button type="submit">Validar</button>
    </form>
@endsection
