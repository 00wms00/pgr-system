<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $empresa = $this->route('empresa');

        return [
            'razao_social'            => ['required', 'string', 'max:255'],
            'nome_fantasia'           => ['nullable', 'string', 'max:255'],
            'cnpj'                    => [
                'required', 'string', 'max:18',
                Rule::unique('empresas', 'cnpj')->ignore($empresa?->id),
            ],
            // CNAE
            'cnae_principal_codigo'   => ['nullable', 'string', 'max:10'],
            'cnae_principal_descricao'=> ['nullable', 'string', 'max:300'],
            'grau_risco'              => ['nullable', 'integer', 'between:1,4'],
            // CNAEs secundários
            'cnaes'                   => ['nullable', 'array', 'max:50'],
            'cnaes.*.codigo'          => ['required_with:cnaes.*', 'string', 'max:10'],
            'cnaes.*.descricao'       => ['required_with:cnaes.*', 'string', 'max:300'],
            // Trabalhadores
            'total_trabalhadores'     => ['nullable', 'integer', 'min:0'],
            'trabalhadores_masculino' => ['nullable', 'integer', 'min:0'],
            'trabalhadores_feminino'  => ['nullable', 'integer', 'min:0'],
            // Porte
            'porte'                   => ['nullable', Rule::in(['MEI','ME','EPP','medio','grande'])],
            // Endereço e inscrições
            'endereco'                => ['nullable', 'string', 'max:255'],
            'inscricao_estadual'      => ['nullable', 'string', 'max:30'],
            'inscricao_municipal'     => ['nullable', 'string', 'max:30'],
            // Representante
            'representante_nome'      => ['nullable', 'string', 'max:150'],
            'representante_cargo'     => ['nullable', 'string', 'max:100'],
            // Contato técnico
            'contato_tecnico_nome'    => ['nullable', 'string', 'max:150'],
            'contato_tecnico_cargo'   => ['nullable', 'string', 'max:100'],
            'ativo'                   => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'razao_social'            => 'razão social',
            'cnpj'                    => 'CNPJ',
            'cnae_principal_codigo'   => 'código CNAE principal',
            'cnae_principal_descricao'=> 'descrição CNAE principal',
            'grau_risco'              => 'grau de risco',
            'cnaes.*.codigo'          => 'código CNAE secundário',
            'cnaes.*.descricao'       => 'descrição CNAE secundário',
            'total_trabalhadores'     => 'total de trabalhadores',
            'trabalhadores_masculino' => 'trabalhadores masculino',
            'trabalhadores_feminino'  => 'trabalhadores feminino',
            'porte'                   => 'porte da empresa',
            'representante_nome'      => 'nome do representante legal',
            'representante_cargo'     => 'cargo do representante',
            'contato_tecnico_nome'    => 'nome do contato técnico',
            'contato_tecnico_cargo'   => 'cargo do contato técnico',
        ];
    }
}
