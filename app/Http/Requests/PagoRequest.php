<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PagoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $prestamo = \App\Models\Prestamo::with('pagos')->find($this->prestamo_id);
    
            if (!$prestamo) {
                $validator->errors()->add('prestamo_id', 'El préstamo no existe.');
                return;
            }
    
            // Cuotas por modalidad
            $cuotasPorMes = match($prestamo->modalidad_pago) {
                'Mensual' => 1,
                'Quincenal' => 2,
                'Decadal' => 3,
                default => 1,
            };
    
            // Duración en meses
            $duracionMeses = ceil($prestamo->cuotas / $cuotasPorMes);
    
            // Interés total
            $interesTotal = ($prestamo->monto * $prestamo->interes_porcentaje / 100) * $duracionMeses;
    
            // Monto total con interés
            $saldoFinal = $prestamo->monto + $interesTotal;
    
            // Total abonado
            $totalPagado = $prestamo->pagos->sum('monto_abono');
    
            // Saldo pendiente real
            $saldoPendiente = $saldoFinal - $totalPagado;
    
            // Validar que el abono no exceda el saldo pendiente
            if ($this->monto_abono > $saldoPendiente) {
                $validator->errors()->add('monto_abono', 'El abono excede el saldo pendiente con interés.');
            }
        });
    }
    public function prepareForValidation()
    {
        $this->merge([
            'monto_abono' => preg_replace('/\D/', '', $this->monto_abono),
        ]);
    }
    public function rules(): array
    {
        return [
			'prestamo_id' => 'required|exists:prestamos,id',
			'fecha_pago' => 'required|date',
			'monto_abono' => 'required|numeric|min:0',
        ];
    }
    
}
