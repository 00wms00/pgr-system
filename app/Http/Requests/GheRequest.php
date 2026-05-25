<?php

namespace App\Http\Requests;

use App\Models\Setor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $gheId = $this->route('ghe')?->id;

        // IDs de setores que pertencem à empresa do usuário
        $setorIds = Setor::whereHas('unidade', fn ($q) =>
            $q->where('empresa_id', auth()->user()->empresa_id)
        )->pluck('id');

        return [
            'setor_id' => ['required', 'integer', Rule::in($setorIds)],
            'codigo'   => [
                'nullable', 'string', 'max:20',
                Rule::unique('ghes', 'codigo')
                    ->where('setor_id', $this->input('setor_id'))
                    ->ignore($gheId),
            ],
            'nome'                => ['required', 'string', 'max:150'],
            'descricao_atividades'=> ['nullable', 'string', 'max:1000'],
            'ativo'               => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'setor_id.required' => 'Selecione um setor.',
            'setor_id.in'       => 'Setor inválido.',
            'nome.required'     => 'O nome do GHE é obrigatório.',
            'codigo.unique'     => 'Já existe um GHE com este código neste setor.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Checkbox "ativo" não enviado = false
        $this->merge(['ativo' => $this->boolean('ativo')]);
    }
}
