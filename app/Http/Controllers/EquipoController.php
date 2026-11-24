<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipoController extends Controller
{
    /** Administrador: todos los equipos. Estudiante: solo los disponibles. */
    public function index(Request $request): View
    {
        $equipos = Equipo::query()
            ->when(! $request->user()->esAdmin(), fn ($q) => $q->where('estado', Equipo::DISPONIBLE))
            ->orderBy('nombre')
            ->get();

        return view('equipos.index', compact('equipos'));
    }

    public function create(): View
    {
        return view('equipos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate($this->reglas());

        Equipo::create($datos);

        return redirect()->route('equipos.index')->with('success', 'Equipo registrado correctamente.');
    }

    public function edit(Equipo $equipo): View
    {
        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, Equipo $equipo): RedirectResponse
    {
        $datos = $request->validate($this->reglas($equipo));

        // El estado "reservado" lo controla el sistema (al reservar/cancelar), no el formulario.
        if ($equipo->estado === Equipo::RESERVADO) {
            unset($datos['estado']);
        }

        $equipo->update($datos);

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        if ($equipo->estado === Equipo::RESERVADO) {
            return back()->with('error', 'No puedes eliminar un equipo con una reservación activa. Cancélala primero.');
        }

        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado correctamente.');
    }

    private function reglas(?Equipo $equipo = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'codigo' => ['required', 'string', 'max:30', Rule::unique('equipos', 'codigo')->ignore($equipo?->id)],
            'tipo' => ['required', Rule::in(Equipo::TIPOS)],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'estado' => ['sometimes', Rule::in([Equipo::DISPONIBLE, Equipo::MANTENIMIENTO])],
        ];
    }
}
