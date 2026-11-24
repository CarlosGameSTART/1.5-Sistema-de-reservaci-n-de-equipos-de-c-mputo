<?php

namespace App\Policies;

use App\Models\Reservacion;
use App\Models\User;

class ReservacionPolicy
{
    /**
     * Ver una reservación: el administrador cualquiera; el estudiante solo la suya.
     * Esto evita que se consulte la reservación de otro cambiando el ID en la URL.
     */
    public function view(User $usuario, Reservacion $reservacion): bool
    {
        return $usuario->esAdmin() || $reservacion->user_id === $usuario->id;
    }

    /**
     * Cancelar:
     *  - Solo reservaciones activas.
     *  - Administrador: cualquiera.
     *  - Estudiante: solo la suya y dentro del plazo (Reservacion::MINUTOS_PARA_CANCELAR).
     */
    public function cancel(User $usuario, Reservacion $reservacion): bool
    {
        if (! $reservacion->estaActiva()) {
            return false;
        }

        if ($usuario->esAdmin()) {
            return true;
        }

        return $reservacion->user_id === $usuario->id
            && $reservacion->dentroDelPlazoDeCancelacion();
    }
}
