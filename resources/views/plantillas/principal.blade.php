<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="cabecera">
        <div class="cabeceraInterior">
            <strong>{{ config('app.name') }}</strong>
            <nav class="menu">
                <a href="{{ route('principal') }}">Principal</a>
                <a href="{{ route('configuracion') }}">Configuración</a>
                <a href="{{ route('usuarios.crear') }}">Crear usuario</a>
                <a href="{{ route('roles.crear') }}">Crear rol</a>
                <a href="{{ route('roles.asignar') }}">Asignar rol</a>
                <form method="POST" action="{{ route('acceso.salir') }}">
                    @csrf
                    <button type="submit">Salir</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="contenido">
        @if (session('estado'))
            <div class="estado">{{ session('estado') }}</div>
        @endif

        @if ($errors->any())
            <div class="errores">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <section class="panel">
            @yield('contenido')
        </section>
    </main>
</body>
</html>
