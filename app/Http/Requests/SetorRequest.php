<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $setorId = $this->route('setor')?->id;

        // Pega os IDs de unidades que pertencem à empresa do usuário
        $unidadeIds = \App\Models\Unidade::where('empresa_id', auth()->user()->empresa_id)
            ->pluck('id');

        return [
            'unidade_id' => ['required', 'integer', Rule::in($unidadeIds)],
            'nome'       => [
                'required',
                'string',
                'max:150',
                // Nome único por unidade
                Rule::unique('setores', 'nome')
                    ->where('unidade_id', $this->input('unidade_id'))
                    ->ignore($setorId),
            ],
            'descricao'  => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'unidade_id.required' => 'Selecione uma unidade.',
            'unidade_id.in'       => 'Unidade inválida.',
            'nome.required'       => 'O nome do setor é obrigatório.',
            'nome.unique'         => 'Já existe um setor com este nome nesta unidade.',
        ];
    }
}
