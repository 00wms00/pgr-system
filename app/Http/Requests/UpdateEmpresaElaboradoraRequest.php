<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaElaboradoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('empresa_elaboradora'));
    }

    public function rules(): array
    {
        $id = $this->route('empresa_elaboradora')->id;

        return [
            'razao_social'    => ['required', 'string', 'max:255'],
            'nome_fantasia'   => ['nullable', 'string', 'max:255'],
            'cnpj'            => ['required', 'string', 'max:18', Rule::unique('empresa_elaboradora', 'cnpj')->ignore($id)],
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
}
