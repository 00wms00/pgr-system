<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoAcaoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\PlanoAcao;

class PlanoAcaoController extends Controller
{
    public function create(AvaliacaoRisco $avaliacao)
    {
        $avaliacao->load(['riscoInventario.riscoTipo', 'riscoInventario.ghe']);
        return view('planos.create', compact('avaliacao'));
    }

    public function store(PlanoAcaoRequest $request)
    {
        $plano = PlanoAcao::create($request->validated());
        return redirect()->route('avaliacoes.show', $plano->avaliacao_risco_id)
            ->with('success', 'Plano de ação criado.');
    }

    public function edit(PlanoAcao $plano)
    {
        $plano->load('avaliacaoRisco.riscoInventario.riscoTipo');
        return view('planos.edit', compact('plano'));
    }

    public function update(PlanoAcaoRequest $request, PlanoAcao $plano)
    {
        $plano->update($request->validated());
        return redirect()->route('avaliacoes.show', $plano->avaliacao_risco_id)
            ->with('success', 'Plano de ação atualizado.');
    }

    public function destroy(PlanoAcao $plano)
    {
        $avaliacaoId = $plano->avaliacao_risco_id;
        $plano->delete();
        return redirect()->route('avaliacoes.show', $avaliacaoId)
            ->with('success', 'Plano de ação removido.');
    }
}
