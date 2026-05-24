<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvaliacaoRiscoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->canWrite();
    }

    public function rules(): array
    {
        return [
            'data_avaliacao' => ['required', 'date'],
            'probabilidade' => ['required', 'integer', 'min:1', 'max:5'],
            'severidade' => ['required', 'integer', 'min:1', 'max:5'],
            'metodologia' => ['nullable', 'string', 'max:255'],
            'justificativa' => ['nullable', 'string'],
        ];
    }
}
