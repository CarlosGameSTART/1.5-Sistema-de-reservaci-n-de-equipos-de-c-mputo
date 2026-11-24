@extends('layouts.app')

@section('title', 'Editar equipo')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar equipo</h1>
        <p class="muted">{{ $equipo->nombre }} · <code>{{ $equipo->codigo }}</code></p>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('equipos.update', $equipo) }}" novalidate>
        @csrf
        @method('PUT')
        @include('equipos._form')
    </form>
</div>
@endsection
