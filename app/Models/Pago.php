<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 *
 * @property $id
 * @property $prestamo_id
 * @property $fecha_pago
 * @property $monto_abono
 * @property $created_at
 * @property $updated_at
 *
 * @property Prestamo $prestamo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pago extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['prestamo_id', 'fecha_pago', 'monto_abono'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prestamo()
{
    return $this->belongsTo(Prestamo::class);
}
    
}
