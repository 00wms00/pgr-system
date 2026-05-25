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
     *
     * IMPORTANTE: o eager load da cadeia (riscoInventario.ghe.setor.unidade)
     * deve ser feito ANTES de Gate::authorize(), pois a Policy usa loadMissing
     * mas é mais eficiente já injetar o relacionamento carregado.
     */

    public function index(RiscoInventario $risco): View
    {
        $risco->load(['ghe.setor.unidade', 'riscoTipo']);

        Gate::authorize('viewAny', [AvaliacaoRisco::class, $risco]);

        $avaliacoes = $risco->avaliacoes()
            ->with('avaliador')
            ->latest('data_avaliacao')
            ->paginate(20);

        return view('avaliacoes.index', compact('risco', 'avaliacoes'));
    }

    public function create(RiscoInventario $risco): View
    {
        $risco->load(['ghe.setor.unidade', 'riscoTipo']);

        Gate::authorize('create', [AvaliacaoRisco::class, $risco]);

        $defaults = [
            'probabilidade' => $risco->probabilidade_calculada,
            'severidade'    => $risco->severidade_calculada,
        ];

        return view('avaliacoes.create', compact('risco', 'defaults'));
    }

    public function store(AvaliacaoRiscoRequest $request, RiscoInventario $risco): RedirectResponse
    {
        $risco->load(['ghe.setor.unidade']);

        Gate::authorize('create', [AvaliacaoRisco::class, $risco]);

        $dados = $request->validated();
        $dados['risco_inventario_id'] = $risco->id;
        $dados['nivel_risco']         = $dados['probabilidade'] * $dados['severidade'];
        $dados['classificacao']       = AvaliacaoRisco::classificar($dados['nivel_risco']);
        $dados['avaliado_por']        = auth()->id();

        AvaliacaoRisco::create($dados);

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação registrada com sucesso.');
    }

    public function show(RiscoInventario $risco, AvaliacaoRisco $avaliacao): View
    {
        $avaliacao->load(['riscoInventario.ghe.setor.unidade', 'riscoInventario.riscoTipo', 'avaliador', 'planosAcao']);

        Gate::authorize('view', $avaliacao);

        return view('avaliacoes.show', compact('risco', 'avaliacao'));
    }

    public function edit(RiscoInventario $risco, AvaliacaoRisco $avaliacao): View
    {
        $avaliacao->load(['riscoInventario.ghe.setor.unidade']);
        $risco->load(['ghe.setor.unidade', 'riscoTipo']);

        Gate::authorize('update', $avaliacao);

        return view('avaliacoes.edit', compact('risco', 'avaliacao'));
    }

    public function update(AvaliacaoRiscoRequest $request, RiscoInventario $risco, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        $avaliacao->load(['riscoInventario.ghe.setor.unidade']);

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
        $avaliacao->load(['riscoInventario.ghe.setor.unidade']);

        Gate::authorize('delete', $avaliacao);

        $avaliacao->delete();

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação removida.');
    }
}
