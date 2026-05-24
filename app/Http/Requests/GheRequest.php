<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GheRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'setor_id'             => ['required', 'exists:setores,id'],
            'codigo'               => ['required', 'string', 'max:20'],
            'nome'                 => ['required', 'string', 'max:255'],
            'descricao_atividades' => ['nullable', 'string'],
            'ativo'                => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'setor_id' => 'setor',
            'codigo'   => 'código',
            'nome'     => 'nome',
        ];
    }
}
