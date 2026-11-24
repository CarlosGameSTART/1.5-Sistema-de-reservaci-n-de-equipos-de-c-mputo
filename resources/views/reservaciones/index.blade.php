@extends('layouts.app')

@section('title', 'Reservaciones')

@section('content')
@php($admin = auth()->user()->esAdmin())

<div class="page-header">
    <div>
        <h1>{{ $admin ? 'Todas las reservaciones' : 'Mis reservaciones' }}</h1>
        <p class="muted">
            @if ($admin)
                Consulta y cancela las reservaciones de todos los usuarios.
            @else
                Puedes cancelar una reservación durante los primeros {{ \App\Models\Reservacion::MINUTOS_PARA_CANCELAR }} minutos.
            @endif
        </p>
    </div>
    @unless ($admin)
        <a href="{{ route('equipos.index') }}" class="btn">Reservar un equipo</a>
    @endunless
</div>

<div class="card">
    @if ($reservaciones->isEmpty())
        <p class="empty">Todavía no hay reservaciones.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Equipo</th>
                        @if ($admin)<th>Usuario</th>@endif
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($reservaciones as $reserva)
                    <tr>
                        <td>{{ $reserva->id }}</td>
                        <td>
                            <strong>{{ $reserva->equipo->nombre }}</strong>
                            <div class="muted small"><code>{{ $reserva->equipo->codigo }}</code></div>
                        </td>
                        @if ($admin)<td>{{ $reserva->user->name }}</td>@endif
                        <td>{{ $reserva->motivo }}</td>
                        <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge badge-{{ $reserva->estado }}">{{ ucfirst($reserva->estado) }}</span></td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('reservaciones.show', $reserva) }}" class="btn btn-outline btn-sm">Ver</a>
                                @can('cancel', $reserva)
                                    <form method="POST" action="{{ route('reservaciones.destroy', $reserva) }}"
                                          onsubmit="return confirm('¿Cancelar esta reservación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
