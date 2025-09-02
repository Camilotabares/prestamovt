<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'monto' => preg_replace('/\D/', '', $this->monto),
        ]);
    }
    public function rules(): array
    {
        return [
			'cliente_id' => 'required',
			'monto' => 'required',
			'cuotas' => 'required',
			'interes_porcentaje' => 'required',
            'modalidad_pago' => 'required',
			'fecha_inicio' => 'required',
        ];
    }
}
