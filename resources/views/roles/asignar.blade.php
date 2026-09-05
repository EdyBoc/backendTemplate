@extends('plantillas.principal')

@section('titulo', 'Asignar rol')

@section('contenido')
    <h1>Asignar rol</h1>
    <form method="POST" action="{{ route('roles.guardarAsignacion') }}">
        @csrf
        <div class="campo">
            <label for="usuarioId">Usuario</label>
            <select id="usuarioId" name="usuarioId" required>
                <option value="">Seleccione</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->nombre }} — {{ $usuario->correoElectronico }}</option>
                @endforeach
            </select>
        </div>
        <div class="campo">
            <label for="rolId">Rol</label>
            <select id="rolId" name="rolId" required>
                <option value="">Seleccione</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Asignar rol</button>
    </form>
@endsection
