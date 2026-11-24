@extends('layouts.app')

@section('title', 'Acceso denegado')

@section('content')
<div class="card center-card">
    <h1>403</h1>
    <p><strong>Acceso denegado</strong></p>
    <p class="muted">No tienes permiso para ver este recurso o realizar esta acción.</p>
    <a href="{{ route('equipos.index') }}" class="btn">Volver al inicio</a>
</div>
@endsection
