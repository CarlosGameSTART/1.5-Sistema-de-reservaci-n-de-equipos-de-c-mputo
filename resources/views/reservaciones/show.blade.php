@extends('layouts.app')

@section('title', 'Reservación #'.$reservacion->id)

@section('content')
<div class="page-header">
    <div>
        <h1>Reservación #{{ $reservacion->id }}</h1>
        <p class="muted">Detalle de la reservación.</p>
    </div>
</div>

<div class="card">
    <dl class="details">
        <dt>Equipo</dt>
        <dd>{{ $reservacion->equipo->nombre }} · <code>{{ $reservacion->equipo->codigo }}</code></dd>

        <dt>Usuario</dt>
        <dd>{{ $reservacion->user->name }}</dd>

        <dt>Motivo</dt>
        <dd>{{ $reservacion->motivo }}</dd>

        <dt>Reservada el</dt>
        <dd>{{ $reservacion->created_at->format('d/m/Y H:i') }}</dd>

        <dt>Estado</dt>
        <dd><span class="badge badge-{{ $reservacion->estado }}">{{ ucfirst($reservacion->estado) }}</span></dd>

        @if ($reservacion->cancelada_at)
            <dt>Cancelada el</dt>
            <dd>{{ $reservacion->cancelada_at->format('d/m/Y H:i') }}</dd>
        @endif
    </dl>

    <div class="actions">
        <a href="{{ route('reservaciones.index') }}" class="btn btn-outline">Volver</a>
        @can('cancel', $reservacion)
            <form method="POST" action="{{ route('reservaciones.destroy', $reservacion) }}"
                  onsubmit="return confirm('¿Cancelar esta reservación?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Cancelar reservación</button>
            </form>
        @endcan
    </div>
</div>
@endsection
