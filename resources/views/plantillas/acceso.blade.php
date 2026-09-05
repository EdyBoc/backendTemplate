<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="contenedorAcceso">
        <section class="tarjeta @yield('claseTarjeta')">
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

            @yield('contenido')
        </section>
    </main>
</body>
</html>
