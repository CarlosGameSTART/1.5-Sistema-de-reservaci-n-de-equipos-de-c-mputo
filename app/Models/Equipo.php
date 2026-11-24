<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    public const DISPONIBLE = 'disponible';
    public const RESERVADO = 'reservado';
    public const MANTENIMIENTO = 'mantenimiento';

    public const TIPOS = ['Laptop', 'Computadora de escritorio', 'Tablet', 'Otro'];

    protected $fillable = ['nombre', 'codigo', 'tipo', 'descripcion', 'estado'];

    public function reservaciones(): HasMany
    {
        return $this->hasMany(Reservacion::class);
    }

    public function estaDisponible(): bool
    {
        return $this->estado === self::DISPONIBLE;
    }
}
