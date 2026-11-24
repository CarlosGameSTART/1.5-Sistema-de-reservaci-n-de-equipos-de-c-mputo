@extends('layouts.app')

@section('title', 'Nuevo equipo')

@section('content')
<div class="page-header">
    <div>
        <h1>Nuevo equipo</h1>
        <p class="muted">Registra un equipo en el inventario.</p>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('equipos.store') }}" novalidate>
        @csrf
        @include('equipos._form')
    </form>
</div>
@endsection
