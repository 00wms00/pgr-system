<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $id = $this->route('empresa')?->id;

        return [
            'razao_social'  => ['required', 'string', 'max:255'],
            'nome_fantasia' => ['nullable', 'string', 'max:255'],
            'cnpj'          => ['required', 'string', 'max:18', Rule::unique('empresas', 'cnpj')->ignore($id)],
            'endereco'      => ['nullable', 'string', 'max:255'],
            'ativo'         => ['boolean'],
        ];
    }
}
