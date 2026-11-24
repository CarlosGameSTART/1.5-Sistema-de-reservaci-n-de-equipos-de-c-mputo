<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservacion extends Model
{
    public const ACTIVA = 'activa';
    public const CANCELADA = 'cancelada';

    /** Minutos que tiene un estudiante para cancelar su propia reservación. */
    public const MINUTOS_PARA_CANCELAR = 30;

    // El plural en español no lo infiere Laravel ("reservacions").
    protected $table = 'reservaciones';

    protected $fillable = ['user_id', 'equipo_id', 'motivo', 'estado', 'cancelada_at'];

    protected function casts(): array
    {
        return [
            'cancelada_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function estaActiva(): bool
    {
        return $this->estado === self::ACTIVA;
    }

    public function dentroDelPlazoDeCancelacion(): bool
    {
        return $this->created_at->greaterThanOrEqualTo(now()->subMinutes(self::MINUTOS_PARA_CANCELAR));
    }
}
