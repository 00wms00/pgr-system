<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnidadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Gate::authorize() já é feito no controller
    }

    public function rules(): array
    {
        $empresaId = auth()->user()->empresa_id;
        $unidadeId = $this->route('unidade')?->id;

        return [
            'codigo' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('unidades', 'codigo')
                    ->where('empresa_id', $empresaId)
                    ->ignore($unidadeId),
            ],
            'nome'     => ['required', 'string', 'max:150'],
            'endereco' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da unidade é obrigatório.',
            'codigo.unique' => 'Já existe uma unidade com este código na sua empresa.',
        ];
    }
}
