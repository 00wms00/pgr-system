<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaElaboradoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\EmpresaElaboradora::class);
    }

    public function rules(): array
    {
        return [
            'razao_social'    => ['required', 'string', 'max:255'],
            'nome_fantasia'   => ['nullable', 'string', 'max:255'],
            'cnpj'            => ['required', 'string', 'max:18', 'unique:empresa_elaboradora,cnpj'],
            'cnae_codigo'     => ['nullable', 'string', 'max:10'],
            'cnae_descricao'  => ['nullable', 'string', 'max:255'],
            'logradouro'      => ['required', 'string', 'max:255'],
            'numero'          => ['required', 'string', 'max:20'],
            'complemento'     => ['nullable', 'string', 'max:100'],
            'bairro'          => ['required', 'string', 'max:100'],
            'cidade'          => ['required', 'string', 'max:100'],
            'uf'              => ['required', 'string', 'size:2'],
            'cep'             => ['required', 'string', 'max:9'],
            'telefone'        => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:255'],
            'site'            => ['nullable', 'url', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'razao_social'   => 'Razão Social',
            'nome_fantasia'  => 'Nome Fantasia',
            'cnpj'           => 'CNPJ',
            'cnae_codigo'    => 'Código CNAE',
            'cnae_descricao' => 'Descrição CNAE',
            'logradouro'     => 'Logradouro',
            'numero'         => 'Número',
            'complemento'    => 'Complemento',
            'bairro'         => 'Bairro',
            'cidade'         => 'Cidade',
            'uf'             => 'UF',
            'cep'            => 'CEP',
        ];
    }
}
