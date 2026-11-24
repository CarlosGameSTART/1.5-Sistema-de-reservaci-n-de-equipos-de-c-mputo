@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="auth-wrap">
    <div class="card auth-card">
        <div class="auth-logo">Sistema_reservacion_lab</div>
        <h1>Iniciar sesión</h1>
        <p class="muted">Reservación de equipos de cómputo</p>

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="field">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-block">Entrar</button>
        </form>
    </div>
</div>
@endsection
