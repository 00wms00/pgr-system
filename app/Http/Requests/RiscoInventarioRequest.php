<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RiscoInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // GHEs válidos para a empresa do usuário logado
        $gheIds = \App\Models\Ghe::whereHas('setor.unidade', function ($q) {
            $q->where('empresa_id', auth()->user()->empresa_id);
        })->pluck('id');

        return [
            'ghe_id'             => ['required', 'integer', Rule::in($gheIds)],
            'risco_tipo_id'      => ['required', 'integer', Rule::exists('riscos_tipos', 'id')],
            'agente'             => ['nullable', 'string', 'max:255'],
            'fonte_geradora'     => ['required', 'string', 'max:255'],
            'via_absorcao'       => ['nullable', 'string', 'max:255'],
            'tecnica_utilizada'  => ['nullable', 'string', 'max:255'],
            'possiveis_lesoes'   => ['nullable', 'string'],
            'danos_saude'        => ['nullable', 'string'],
            'medidas_existentes' => ['nullable', 'string'],
            'observacoes'        => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ghe_id'             => 'GHE',
            'risco_tipo_id'      => 'tipo de risco',
            'fonte_geradora'     => 'fonte geradora',
            'via_absorcao'       => 'via de absorção',
            'tecnica_utilizada'  => 'técnica utilizada',
            'possiveis_lesoes'   => 'possíveis lesões',
            'danos_saude'        => 'danos à saúde',
            'medidas_existentes' => 'medidas existentes',
        ];
    }
}
