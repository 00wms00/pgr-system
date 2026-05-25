<?php

namespace App\Http\Requests;

use App\Models\PlanoAcao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanoAcaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorização via Gate no controller
    }

    public function rules(): array
    {
        return [
            'tipo_controle' => ['required', Rule::in(array_keys(PlanoAcao::TIPOS_CONTROLE))],
            'descricao'     => ['required', 'string', 'max:1000'],
            'responsavel'   => ['required', 'string', 'max:255'],
            'prazo'         => ['required', 'date', 'after_or_equal:today'],
            'status'        => ['required', Rule::in(array_keys(PlanoAcao::STATUS))],
            'observacao'    => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'tipo_controle' => 'tipo de controle',
            'descricao'     => 'descrição',
            'responsavel'   => 'responsável',
            'prazo'         => 'prazo',
            'status'        => 'status',
        ];
    }

    public function messages(): array
    {
        return [
            'prazo.after_or_equal' => 'O prazo não pode ser anterior à data de hoje.',
        ];
    }
}
