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
            'razao_social'  => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'cnpj'          => [
                'required', 'string', 'size:18',
                Rule::unique('empresas', 'cnpj')->ignore($empresa?->id),
            ],
            'endereco'      => ['nullable', 'string', 'max:500'],
            'ativo'         => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'razao_social'  => 'razão social',
            'nome_fantasia' => 'nome fantasia',
            'cnpj'          => 'CNPJ',
            'endereco'      => 'endereço',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ativo' => $this->boolean('ativo'),
        ]);
    }
}
