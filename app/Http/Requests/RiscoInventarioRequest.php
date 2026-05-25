<?php

namespace App\Http\Requests;

use App\Models\AgenteQuantitativo;
use App\Models\Ghe;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RiscoInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorização via Gate no controller
    }

    public function rules(): array
    {
        // GHEs válidos para a empresa do usuário
        $gheIds = Ghe::whereHas('setor.unidade', fn ($q) =>
            $q->where('empresa_id', auth()->user()->empresa_id)
        )->pluck('id');

        return [
            'ghe_id'                  => ['required', 'integer', Rule::in($gheIds)],
            'risco_tipo_id'           => ['required', 'integer', Rule::exists('riscos_tipos', 'id')],
            'agente_quantitativo_id'  => ['nullable', 'integer', Rule::exists('agentes_quantitativos', 'id')],
            'agente'                  => ['nullable', 'string', 'max:255'],
            'fonte_geradora'          => ['required', 'string', 'max:500'],
            'via_absorcao'            => ['nullable', 'string', 'max:255'],
            'tecnica_utilizada'       => ['nullable', 'string', 'max:255'],
            'possiveis_lesoes'        => ['nullable', 'string', 'max:1000'],
            'danos_saude'             => ['nullable', 'string', 'max:1000'],
            'medidas_existentes'      => ['nullable', 'string', 'max:1000'],
            'observacoes'             => ['nullable', 'string', 'max:1000'],
            // Medição quantitativa
            'valor_medido'            => ['nullable', 'numeric', 'min:0'],
            'probabilidade_calculada' => ['nullable', 'integer', 'min:1', 'max:5'],
            'severidade_calculada'    => ['nullable', 'integer', 'min:1', 'max:5'],
            'classificacao_calculada' => ['nullable', Rule::in(['baixo','moderado','alto','critico'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'ghe_id'                  => 'GHE',
            'risco_tipo_id'           => 'tipo de risco',
            'agente_quantitativo_id'  => 'agente quantitativo',
            'fonte_geradora'          => 'fonte geradora',
            'via_absorcao'            => 'via de absorção',
            'tecnica_utilizada'       => 'técnica utilizada',
            'possiveis_lesoes'        => 'possíveis lesões',
            'danos_saude'             => 'danos à saúde',
            'medidas_existentes'      => 'medidas existentes',
            'valor_medido'            => 'valor medido',
            'probabilidade_calculada' => 'probabilidade calculada',
            'severidade_calculada'    => 'severidade calculada',
            'classificacao_calculada' => 'classificação calculada',
        ];
    }
}
