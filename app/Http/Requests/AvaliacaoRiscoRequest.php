<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvaliacaoRiscoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'probabilidade'  => ['required', 'integer', 'min:1', 'max:5'],
            'severidade'     => ['required', 'integer', 'min:1', 'max:5'],
            'data_avaliacao' => ['required', 'date'],
            'metodologia'    => ['nullable', 'string', 'max:100'],
            'justificativa'  => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'probabilidade'  => 'probabilidade',
            'severidade'     => 'severidade',
            'data_avaliacao' => 'data da avaliação',
        ];
    }
}
