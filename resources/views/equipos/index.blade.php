@extends('layouts.app')

@section('title', 'Equipos')

@section('content')
@php($admin = auth()->user()->esAdmin())

<div class="page-header">
    <div>
        <h1>{{ $admin ? 'Todos los equipos' : 'Equipos disponibles' }}</h1>
        <p class="muted">
            {{ $admin ? 'Administra el inventario del laboratorio.' : 'Escribe un motivo y reserva el equipo que necesites.' }}
        </p>
    </div>
    @if ($admin)
        <a href="{{ route('equipos.create') }}" class="btn">+ Nuevo equipo</a>
    @endif
</div>

<div class="card">
    @if ($equipos->isEmpty())
        <p class="empty">{{ $admin ? 'Aún no hay equipos registrados.' : 'No hay equipos disponibles por ahora.' }}</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Equipo</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>{{ $admin ? 'Acciones' : 'Reservar' }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($equipos as $equipo)
                    <tr>
                        <td><code>{{ $equipo->codigo }}</code></td>
                        <td>
                            <strong>{{ $equipo->nombre }}</strong>
                            @if ($equipo->descripcion)
                                <div class="muted small">{{ $equipo->descripcion }}</div>
                            @endif
                        </td>
                        <td>{{ $equipo->tipo }}</td>
                        <td><span class="badge badge-{{ $equipo->estado }}">{{ ucfirst($equipo->estado) }}</span></td>
                        <td>
                            @if ($admin)
                                <div class="actions">
                                    <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-outline btn-sm">Editar</a>
                                    <form method="POST" action="{{ route('equipos.destroy', $equipo) }}"
                                          onsubmit="return confirm('¿Eliminar este equipo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </div>
                            @else
                                @php($bolsa = 'reservar_'.$equipo->id)
                                <form method="POST" action="{{ route('reservaciones.store', $equipo) }}" class="inline-form">
                                    @csrf
                                    <div>
                                        <input type="text" name="motivo" placeholder="Motivo de uso" maxlength="150" required
                                               value="{{ $errors->hasBag($bolsa) ? old('motivo') : '' }}">
                                        @if ($errors->hasBag($bolsa) && $errors->getBag($bolsa)->has('motivo'))
                                            <div class="field-error">{{ $errors->getBag($bolsa)->first('motivo') }}</div>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-sm">Reservar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
