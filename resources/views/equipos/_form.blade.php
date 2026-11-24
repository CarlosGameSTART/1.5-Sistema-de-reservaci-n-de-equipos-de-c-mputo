@php
    $editando = isset($equipo);
    $reservado = $editando && $equipo->estado === \App\Models\Equipo::RESERVADO;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre">Nombre</label>
        <input id="nombre" type="text" name="nombre" maxlength="100" required
               value="{{ old('nombre', $equipo->nombre ?? '') }}">
        @error('nombre')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="codigo">Código</label>
        <input id="codigo" type="text" name="codigo" maxlength="30" required
               value="{{ old('codigo', $equipo->codigo ?? '') }}">
        @error('codigo')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecciona…</option>
            @foreach (\App\Models\Equipo::TIPOS as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo', $equipo->tipo ?? '') === $tipo)>{{ $tipo }}</option>
            @endforeach
        </select>
        @error('tipo')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="estado">Estado</label>
        @if ($reservado)
            <input id="estado" type="text" value="Reservado" disabled>
            <div class="hint">Cambia automáticamente al cancelar la reservación.</div>
        @else
            <select id="estado" name="estado" required>
                @foreach (['disponible' => 'Disponible', 'mantenimiento' => 'En mantenimiento'] as $valor => $texto)
                    <option value="{{ $valor }}" @selected(old('estado', $equipo->estado ?? 'disponible') === $valor)>{{ $texto }}</option>
                @endforeach
            </select>
            @error('estado')<div class="field-error">{{ $message }}</div>@enderror
        @endif
    </div>

    <div class="field full">
        <label for="descripcion">Descripción (opcional)</label>
        <textarea id="descripcion" name="descripcion" rows="3" maxlength="255">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
        @error('descripcion')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn">{{ $editando ? 'Guardar cambios' : 'Registrar equipo' }}</button>
    <a href="{{ route('equipos.index') }}" class="btn btn-outline">Cancelar</a>
</div>
