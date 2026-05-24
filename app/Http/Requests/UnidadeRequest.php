<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnidadeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('unidade')?->id;

        return [
            'codigo'   => [
                'required', 'string', 'max:20',
                Rule::unique('unidades')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->ignore($id),
            ],
            'nome'     => ['required', 'string', 'max:255'],
            'endereco' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'codigo' => 'código',
            'nome'   => 'nome',
        ];
    }
}
