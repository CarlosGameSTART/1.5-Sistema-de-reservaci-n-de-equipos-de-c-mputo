<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Reservacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReservacionController extends Controller
{
    /** Administrador: todas. Estudiante: únicamente las suyas (filtro en la consulta). */
    public function index(Request $request): View
    {
        $usuario = $request->user();

        $reservaciones = Reservacion::with(['equipo', 'user'])
            ->when(! $usuario->esAdmin(), fn ($q) => $q->where('user_id', $usuario->id))
            ->latest()
            ->get();

        return view('reservaciones.index', compact('reservaciones'));
    }

    /** Detalle: la política impide ver la reservación de otro usuario cambiando el ID en la URL. */
    public function show(Reservacion $reservacion): View
    {
        Gate::authorize('view', $reservacion);

        $reservacion->load(['equipo', 'user']);

        return view('reservaciones.show', compact('reservacion'));
    }

    public function store(Request $request, Equipo $equipo): RedirectResponse
    {
        $datos = $request->validateWithBag('reservar_'.$equipo->id, [
            'motivo' => ['required', 'string', 'min:3', 'max:150'],
        ]);

        $reservada = DB::transaction(function () use ($request, $equipo, $datos) {
            // UPDATE condicional y atómico: solo uno de dos usuarios simultáneos
            // obtiene "1 fila afectada"; el otro recibe 0 y se le informa.
            $apartado = Equipo::whereKey($equipo->id)
                ->where('estado', Equipo::DISPONIBLE)
                ->update(['estado' => Equipo::RESERVADO]);

            if ($apartado === 0) {
                return false;
            }

            Reservacion::create([
                'user_id' => $request->user()->id,
                'equipo_id' => $equipo->id,
                'motivo' => $datos['motivo'],
                'estado' => Reservacion::ACTIVA,
            ]);

            return true;
        });

        if (! $reservada) {
            return redirect()->route('equipos.index')
                ->with('error', 'Lo sentimos, ese equipo ya no está disponible.');
        }

        return redirect()->route('reservaciones.index')
            ->with('success', 'Reservaste "'.$equipo->nombre.'" correctamente.');
    }

    /** Cancelar una reservación (administrador: cualquiera; estudiante: la suya dentro del plazo). */
    public function destroy(Reservacion $reservacion): RedirectResponse
    {
        Gate::authorize('cancel', $reservacion);

        DB::transaction(function () use ($reservacion) {
            // Solo libera el equipo si ESTA llamada fue la que canceló la reservación.
            $canceladas = Reservacion::whereKey($reservacion->id)
                ->where('estado', Reservacion::ACTIVA)
                ->update(['estado' => Reservacion::CANCELADA, 'cancelada_at' => now()]);

            if ($canceladas === 1) {
                Equipo::whereKey($reservacion->equipo_id)
                    ->where('estado', Equipo::RESERVADO)
                    ->update(['estado' => Equipo::DISPONIBLE]);
            }
        });

        return back()->with('success', 'Reservación cancelada. El equipo quedó disponible de nuevo.');
    }
}
