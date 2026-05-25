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

    /**
     * Rota shallow: GET /avaliacoes/{avaliacao}
     * Autorização manual via abort_unless para evitar problemas de cache
     * de relacionamentos no Gate::authorize.
     */
    public function show(AvaliacaoRisco $avaliacao): View
    {
        // Busca fresh do banco para garantir hierarquia completa sem cache
        $avaliacao = AvaliacaoRisco::with([
            'riscoInventario.ghe.setor.unidade',
            'riscoInventario.riscoTipo',
            'avaliador',
            'planosAcao',
        ])->findOrFail($avaliacao->id);

        $unidade = $avaliacao->riscoInventario?->ghe?->setor?->unidade;

        abort_unless(
            $unidade && (int) auth()->user()->empresa_id === (int) $unidade->empresa_id,
            403
        );

        $risco = $avaliacao->riscoInventario;

        return view('avaliacoes.show', compact('risco', 'avaliacao'));
    }

    public function edit(AvaliacaoRisco $avaliacao): View
    {
        $avaliacao = AvaliacaoRisco::with([
            'riscoInventario.ghe.setor.unidade',
            'riscoInventario.riscoTipo',
        ])->findOrFail($avaliacao->id);

        $unidade = $avaliacao->riscoInventario?->ghe?->setor?->unidade;
        abort_unless(
            auth()->user()->canWrite()
            && $unidade
            && (int) auth()->user()->empresa_id === (int) $unidade->empresa_id,
            403
        );

        $risco = $avaliacao->riscoInventario;
        $risco->load(['riscoTipo']);

        return view('avaliacoes.edit', compact('risco', 'avaliacao'));
    }

    public function update(AvaliacaoRiscoRequest $request, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        $avaliacao = AvaliacaoRisco::with([
            'riscoInventario.ghe.setor.unidade',
        ])->findOrFail($avaliacao->id);

        $unidade = $avaliacao->riscoInventario?->ghe?->setor?->unidade;
        abort_unless(
            auth()->user()->canWrite()
            && $unidade
            && (int) auth()->user()->empresa_id === (int) $unidade->empresa_id,
            403
        );

        $dados = $request->validated();
        $dados['nivel_risco']   = $dados['probabilidade'] * $dados['severidade'];
        $dados['classificacao'] = AvaliacaoRisco::classificar($dados['nivel_risco']);

        $avaliacao->update($dados);

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Avaliação atualizada.');
    }

    public function destroy(AvaliacaoRisco $avaliacao): RedirectResponse
    {
        $avaliacao = AvaliacaoRisco::with([
            'riscoInventario.ghe.setor.unidade',
        ])->findOrFail($avaliacao->id);

        $unidade = $avaliacao->riscoInventario?->ghe?->setor?->unidade;
        abort_unless(
            auth()->user()->canWrite()
            && $unidade
            && (int) auth()->user()->empresa_id === (int) $unidade->empresa_id,
            403
        );

        $risco = $avaliacao->riscoInventario;
        $avaliacao->delete();

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Avaliação removida.');
    }
}
