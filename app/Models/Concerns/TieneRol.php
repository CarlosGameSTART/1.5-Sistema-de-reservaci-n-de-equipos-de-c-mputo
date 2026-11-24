<?php

namespace App\Models\Concerns;

use App\Models\Reservacion;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait para agregar al modelo User: roles y relación con reservaciones.
 */
trait TieneRol
{
    public function esAdmin(): bool
    {
        return $this->rol === 'administrador';
    }

    public function esEstudiante(): bool
    {
        return $this->rol === 'estudiante';
    }

    public function reservaciones(): HasMany
    {
        return $this->hasMany(Reservacion::class);
    }
}
