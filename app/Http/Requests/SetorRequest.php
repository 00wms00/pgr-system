<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'unidade_id' => ['required', 'exists:unidades,id'],
            'nome'       => ['required', 'string', 'max:255'],
            'descricao'  => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'unidade_id' => 'unidade',
            'nome'       => 'nome',
        ];
    }
}
