<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoAcaoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\PlanoAcao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PlanoAcaoController extends Controller
{
    /**
     * Planos de Ação são nested dentro de AvaliacaoRisco.
     * Rota: avaliacoes.{avaliacao}.planos.*  + shallow para show/edit/update/destroy
     */

    public function index(AvaliacaoRisco $avaliacao): View
    {
        Gate::authorize('viewAny', [PlanoAcao::class, $avaliacao]);

        $avaliacao->load([
            'riscoInventario.ghe.setor.unidade',
            'riscoInventario.riscoTipo',
        ]);

        $planos = $avaliacao->planosAcao()
            ->orderByRaw("FIELD(status, 'em_andamento', 'pendente', 'concluido')")
            ->orderBy('prazo')
            ->get();

        return view('planos.index', compact('avaliacao', 'planos'));
    }

    public function create(AvaliacaoRisco $avaliacao): View
    {
        Gate::authorize('create', [PlanoAcao::class, $avaliacao]);

        $avaliacao->load([
            'riscoInventario.ghe.setor',
            'riscoInventario.riscoTipo',
        ]);

        return view('planos.create', compact('avaliacao'));
    }

    public function store(PlanoAcaoRequest $request, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        Gate::authorize('create', [PlanoAcao::class, $avaliacao]);

        $dados = $request->validated();
        $dados['avaliacao_risco_id'] = $avaliacao->id;

        PlanoAcao::create($dados);

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Plano de ação cadastrado com sucesso.');
    }

    public function show(PlanoAcao $plano): View
    {
        Gate::authorize('view', $plano);

        $plano->load([
            'avaliacaoRisco.riscoInventario.ghe.setor.unidade',
            'avaliacaoRisco.riscoInventario.riscoTipo',
        ]);

        return view('planos.show', compact('plano'));
    }

    public function edit(PlanoAcao $plano): View
    {
        Gate::authorize('update', $plano);

        $plano->load([
            'avaliacaoRisco.riscoInventario.ghe.setor',
            'avaliacaoRisco.riscoInventario.riscoTipo',
        ]);

        return view('planos.edit', compact('plano'));
    }

    public function update(PlanoAcaoRequest $request, PlanoAcao $plano): RedirectResponse
    {
        Gate::authorize('update', $plano);

        $plano->update($request->validated());

        return redirect()->route('planos.show', $plano)
            ->with('success', 'Plano de ação atualizado.');
    }

    public function destroy(PlanoAcao $plano): RedirectResponse
    {
        Gate::authorize('delete', $plano);

        $avaliacao = $plano->avaliacaoRisco;
        $plano->delete();

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Plano de ação removido.');
    }
}
