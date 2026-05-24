<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaliacaoRiscoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\RiscoInventario;

class AvaliacaoRiscoController extends Controller
{
    public function create(RiscoInventario $risco)
    {
        $risco->load(['ghe.setor.unidade', 'riscoTipo']);
        return view('avaliacoes.create', compact('risco'));
    }

    public function store(AvaliacaoRiscoRequest $request, RiscoInventario $risco)
    {
        $avaliacao = $risco->avaliacoes()->create($request->validated());

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação registrada com sucesso.');
    }

    public function show(AvaliacaoRisco $avaliacao)
    {
        $avaliacao->load('riscoInventario.ghe.setor.unidade', 'riscoInventario.riscoTipo');
        return view('avaliacoes.show', compact('avaliacao'));
    }

    public function edit(AvaliacaoRisco $avaliacao)
    {
        $avaliacao->load('riscoInventario.ghe.setor.unidade', 'riscoInventario.riscoTipo');
        return view('avaliacoes.edit', compact('avaliacao'));
    }

    public function update(AvaliacaoRiscoRequest $request, AvaliacaoRisco $avaliacao)
    {
        $avaliacao->update($request->validated());

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação atualizada com sucesso.');
    }

    public function destroy(AvaliacaoRisco $avaliacao)
    {
        $risco = $avaliacao->riscoInventario;
        $avaliacao->delete();

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação removida com sucesso.');
    }
}
