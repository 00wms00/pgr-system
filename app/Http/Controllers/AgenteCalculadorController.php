<?php

namespace App\Http\Controllers;

use App\Models\AgenteQuantitativo;
use App\Services\RiscoCalculadorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Endpoint JSON usado pelo formulário Alpine.js para calcular
 * probabilidade/severidade em tempo real sem salvar nada.
 */
class AgenteCalculadorController extends Controller
{
    public function __construct(private RiscoCalculadorService $service) {}

    public function calcular(Request $request, AgenteQuantitativo $agente): JsonResponse
    {
        $request->validate(['valor' => 'required|numeric|min:0']);

        $resultado = $this->service->calcular($agente, (float) $request->valor);

        return response()->json([
            'probabilidade'       => $resultado['probabilidade'],
            'severidade'          => $resultado['severidade'],
            'nivel'               => $resultado['nivel'],
            'classificacao'       => $resultado['classificacao'],
            'classificacao_label' => $resultado['classificacao_label'],
            'gatilho'             => $resultado['gatilho'],
            'descricao_gatilho'   => $resultado['descricao_gatilho'],
            // informações do agente para exibição
            'nivel_acao'          => $agente->nivel_acao,
            'limite_tolerancia'   => $agente->limite_tolerancia,
            'limite_rgi'          => $agente->limite_rgi,
            'norma_referencia'    => $agente->norma_referencia,
        ]);
    }

    /** Lista agentes ativos de um risco_tipo (para popular select dinâmico) */
    public function porRiscoTipo(int $riscoTipoId): JsonResponse
    {
        $agentes = AgenteQuantitativo::where('risco_tipo_id', $riscoTipoId)
            ->where('ativo', true)
            ->get(['id', 'nome', 'unidade_medida', 'campo_label', 'input_step']);

        return response()->json($agentes);
    }
}
