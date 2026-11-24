<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inicio') · LabReserva</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@auth
    <header class="navbar">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('equipos.index') }}">LabReserva</a>

            <nav class="nav-links">
                <a href="{{ route('equipos.index') }}" @class(['active' => request()->routeIs('equipos.*')])>Equipos</a>
                <a href="{{ route('reservaciones.index') }}" @class(['active' => request()->routeIs('reservaciones.*')])>
                    {{ auth()->user()->esAdmin() ? 'Reservaciones' : 'Mis reservaciones' }}
                </a>
            </nav>

            <div class="user-box">
                <div class="user-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span class="badge badge-rol">{{ auth()->user()->rol }}</span>
                    {{-- Huella resumida del ID de sesión: sirve para comprobar que cada PC tiene una sesión distinta --}}
                    <span class="session-tag" title="Huella de tu sesión actual">sesión {{ substr(sha1(session()->getId()), 0, 8) }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>
@endauth

<main class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>
</body>
</html>
