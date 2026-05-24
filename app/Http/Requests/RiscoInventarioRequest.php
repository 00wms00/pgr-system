<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RiscoInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->canWrite();
    }

    public function rules(): array
    {
        return [
            'ghe_id' => ['required', 'integer', Rule::exists('ghes', 'id')],
            'risco_tipo_id' => ['required', 'integer', Rule::exists('riscos_tipos', 'id')],
            'agente' => ['required', 'string', 'max:255'],
            'fonte_geradora' => ['nullable', 'string'],
            'possiveis_lesoes' => ['nullable', 'string'],
            'danos_saude' => ['nullable', 'string'],
            'medidas_existentes' => ['nullable', 'string'],
            'observacoes' => ['nullable', 'string'],
        ];
    }
}
