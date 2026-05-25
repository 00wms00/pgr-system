<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaliacaoRiscoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\RiscoInventario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AvaliacaoRiscoController extends Controller
{
    /**
     * Avaliações são sempre contextualizadas dentro de um RiscoInventario.
     * Rota: riscos.{risco}.avaliacoes.*  (nested resource)
     */

    public function index(RiscoInventario $risco): View
    {
        Gate::authorize('viewAny', [AvaliacaoRisco::class, $risco]);

        $risco->load(['ghe.setor.unidade', 'riscoTipo']);
        $avaliacoes = $risco->avaliacoes()
            ->with('avaliador')
            ->latest('data_avaliacao')
            ->paginate(20);

        return view('avaliacoes.index', compact('risco', 'avaliacoes'));
    }

    public function create(RiscoInventario $risco): View
    {
        Gate::authorize('create', [AvaliacaoRisco::class, $risco]);

        $risco->load(['ghe.setor.unidade', 'riscoTipo']);

        // Pré-preenche probabilidade/severidade do inventário se existirem
        $defaults = [
            'probabilidade' => $risco->probabilidade_calculada,
            'severidade'    => $risco->severidade_calculada,
        ];

        return view('avaliacoes.create', compact('risco', 'defaults'));
    }

    public function store(AvaliacaoRiscoRequest $request, RiscoInventario $risco): RedirectResponse
    {
        Gate::authorize('create', [AvaliacaoRisco::class, $risco]);

        $dados = $request->validated();
        $dados['risco_inventario_id'] = $risco->id;

        // Calcula nivel_risco e classificação automaticamente
        $dados['nivel_risco']    = $dados['probabilidade'] * $dados['severidade'];
        $dados['classificacao']  = AvaliacaoRisco::classificar($dados['nivel_risco']);

        // Registra o avaliador
        $dados['avaliado_por'] = auth()->id();

        AvaliacaoRisco::create($dados);

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação registrada com sucesso.');
    }

    public function show(RiscoInventario $risco, AvaliacaoRisco $avaliacao): View
    {
        Gate::authorize('view', $avaliacao);

        $avaliacao->load(['riscoInventario.ghe.setor.unidade', 'riscoInventario.riscoTipo', 'avaliador', 'planosAcao']);

        return view('avaliacoes.show', compact('risco', 'avaliacao'));
    }

    public function edit(RiscoInventario $risco, AvaliacaoRisco $avaliacao): View
    {
        Gate::authorize('update', $avaliacao);

        $risco->load(['ghe.setor.unidade', 'riscoTipo']);

        return view('avaliacoes.edit', compact('risco', 'avaliacao'));
    }

    public function update(AvaliacaoRiscoRequest $request, RiscoInventario $risco, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        Gate::authorize('update', $avaliacao);

        $dados = $request->validated();
        $dados['nivel_risco']   = $dados['probabilidade'] * $dados['severidade'];
        $dados['classificacao'] = AvaliacaoRisco::classificar($dados['nivel_risco']);

        $avaliacao->update($dados);

        return redirect()->route('riscos.avaliacoes.show', [$risco, $avaliacao])
            ->with('success', 'Avaliação atualizada.');
    }

    public function destroy(RiscoInventario $risco, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        Gate::authorize('delete', $avaliacao);

        $avaliacao->delete();

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação removida.');
    }
}
