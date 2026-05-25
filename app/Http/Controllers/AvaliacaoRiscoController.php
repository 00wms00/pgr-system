<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaliacaoRiscoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\RiscoInventario;

class AvaliacaoRiscoController extends Controller
{
    public function create(RiscoInventario $risco)
    {
        $risco->load(['ghe.setor.unidade', 'riscoTipo.agentesQuantitativos.faixas']);

        // Monta JSON de agentes para o Alpine.js
        $agentesJson = $risco->riscoTipo->agentesQuantitativos->map(fn ($ag) => [
            'id'                => $ag->id,
            'nome'              => $ag->nome,
            'unidade_medida'    => $ag->unidade_medida,
            'campo_label'       => $ag->campo_label,
            'nivel_acao'        => $ag->nivel_acao,
            'limite_tolerancia' => $ag->limite_tolerancia,
            'input_step'        => $ag->input_step ?? '0.1',
            'faixas'            => $ag->faixas->map(fn ($f) => [
                'valor_min'       => $f->valor_min,
                'valor_max'       => $f->valor_max,
                'probabilidade'   => $f->probabilidade,
                'severidade'      => $f->severidade,
                'classificacao'   => $f->classificacao,
            ])->values(),
        ])->values();

        return view('avaliacoes.create', compact('risco', 'agentesJson'));
    }

    public function store(AvaliacaoRiscoRequest $request, RiscoInventario $risco)
    {
        $data = $request->validated();

        $nivel = $data['probabilidade'] * $data['severidade'];

        $avaliacao = $risco->avaliacoes()->create([
            ...$data,
            'nivel_risco'   => $nivel,
            'classificacao' => AvaliacaoRisco::classificar($nivel),
            'metodologia'   => $data['metodologia'] ?? 'Matriz 5x5 (P x S)',
            'avaliado_por'  => auth()->id(),
        ]);

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação registrada.');
    }

    public function show(AvaliacaoRisco $avaliacao)
    {
        $avaliacao->load(['riscoInventario.ghe.setor.unidade', 'riscoInventario.riscoTipo', 'planosAcao', 'avaliador']);
        return view('avaliacoes.show', compact('avaliacao'));
    }

    public function edit(AvaliacaoRisco $avaliacao)
    {
        $avaliacao->load(['riscoInventario.riscoTipo.agentesQuantitativos.faixas']);

        $agentesJson = $avaliacao->riscoInventario->riscoTipo->agentesQuantitativos->map(fn ($ag) => [
            'id'                => $ag->id,
            'nome'              => $ag->nome,
            'unidade_medida'    => $ag->unidade_medida,
            'campo_label'       => $ag->campo_label,
            'nivel_acao'        => $ag->nivel_acao,
            'limite_tolerancia' => $ag->limite_tolerancia,
            'input_step'        => $ag->input_step ?? '0.1',
            'faixas'            => $ag->faixas->map(fn ($f) => [
                'valor_min'       => $f->valor_min,
                'valor_max'       => $f->valor_max,
                'probabilidade'   => $f->probabilidade,
                'severidade'      => $f->severidade,
                'classificacao'   => $f->classificacao,
            ])->values(),
        ])->values();

        return view('avaliacoes.edit', compact('avaliacao', 'agentesJson'));
    }

    public function update(AvaliacaoRiscoRequest $request, AvaliacaoRisco $avaliacao)
    {
        $data = $request->validated();
        $nivel = $data['probabilidade'] * $data['severidade'];

        $avaliacao->update([
            ...$data,
            'nivel_risco'   => $nivel,
            'classificacao' => AvaliacaoRisco::classificar($nivel),
            'metodologia'   => $data['metodologia'] ?? 'Matriz 5x5 (P x S)',
        ]);

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação atualizada.');
    }

    public function destroy(AvaliacaoRisco $avaliacao)
    {
        $riscoId = $avaliacao->risco_inventario_id;
        $avaliacao->delete();
        return redirect()->route('riscos.show', $riscoId)
            ->with('success', 'Avaliação removida.');
    }
}
