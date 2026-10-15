<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CalculateSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'salary' => [
                'required',
                'numeric',
                'min:0.01',
                'max:1000000',
                'decimal:0,2',
            ],
            'frequency' => [
                'nullable',
                Rule::in(['mensual', 'quincenal', 'semanal']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'salary.required' => 'Escribe el salario mensual.',
            'salary.numeric' => 'El salario debe ser numérico.',
            'salary.min' => 'El salario debe ser mayor que cero.',
            'salary.max' => 'El salario supera el límite permitido.',
            'salary.decimal' => 'Usa máximo dos decimales.',
            'frequency.in' => 'La frecuencia seleccionada no es válida.',
        ];
    }
}
