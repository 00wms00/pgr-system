<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AvaliacaoRiscoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorização via Gate no controller
    }

    public function rules(): array
    {
        return [
            'probabilidade'  => ['required', 'integer', 'min:1', 'max:5'],
            'severidade'     => ['required', 'integer', 'min:1', 'max:5'],
            'data_avaliacao' => ['required', 'date', 'before_or_equal:today'],
            'metodologia'    => ['nullable', 'string', Rule::in(['qualitativo','quantitativo','semi_quantitativo'])],
            'justificativa'  => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'probabilidade'  => 'probabilidade',
            'severidade'     => 'severidade',
            'data_avaliacao' => 'data da avaliação',
            'metodologia'    => 'metodologia',
            'justificativa'  => 'justificativa',
        ];
    }

    public function messages(): array
    {
        return [
            'data_avaliacao.before_or_equal' => 'A data da avaliação não pode ser no futuro.',
        ];
    }
}
