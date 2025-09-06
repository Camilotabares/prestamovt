<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pago;

/**
 * Class Prestamo
 *
 * @property $id
 * @property $cliente_id
 * @property $monto
 * @property $cuotas
 * @property $interes_porcentaje
 * @property $fecha_inicio
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Prestamo extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cliente_id', 'monto', 'cuotas', 'interes_porcentaje','modalidad_pago', 'fecha_inicio'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id', 'id');
    }
    

public function pagos()
{
    return $this->hasMany(Pago::class);
}
public function getCuotasRestantesAttribute()
{
    $cuotasRestantes = $this->cuotas - $this->pagos()->count();

    // Si el saldo está saldado, forzar a 0
    $saldoPendiente = ($this->monto + $this->interes_total) - $this->pagos()->sum('monto_abono');
    if ($saldoPendiente <= 0) {
        $cuotasRestantes = 0;
    }

    return max($cuotasRestantes, 0); // Nunca negativo
}
}
