<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanoAcaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'avaliacao_risco_id' => ['required', 'integer', Rule::exists('avaliacoes_risco', 'id')],
            'tipo_controle'      => ['required', 'string', Rule::in(array_keys(\App\Models\PlanoAcao::TIPOS_CONTROLE))],
            'descricao'          => ['required', 'string', 'max:2000'],
            'responsavel'        => ['required', 'string', 'max:255'],
            'prazo'              => ['required', 'date'],
            'status'             => ['required', Rule::in(array_keys(\App\Models\PlanoAcao::STATUS))],
            'observacao'         => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'avaliacao_risco_id' => 'avaliação',
            'tipo_controle'      => 'tipo de controle',
            'responsavel'        => 'responsável',
        ];
    }
}
