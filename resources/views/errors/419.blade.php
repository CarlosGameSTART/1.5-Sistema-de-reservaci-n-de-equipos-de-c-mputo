@extends('layouts.app')

@section('title', 'Sesión expirada')

@section('content')
<div class="card center-card">
    <h1>Sesión expirada</h1>
    <p class="muted">Tu sesión se cerró por inactividad o el formulario caducó. Inicia sesión de nuevo para continuar.</p>
    <a href="{{ route('login') }}" class="btn">Iniciar sesión</a>
</div>
@endsection
