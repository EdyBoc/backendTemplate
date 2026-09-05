@extends('plantillas.principal')

@section('titulo', 'Crear rol')

@section('contenido')
    <h1>Crear rol</h1>
    <form method="POST" action="{{ route('roles.guardar') }}">
        @csrf
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="campo">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>
        <button type="submit">Crear rol</button>
    </form>
@endsection
