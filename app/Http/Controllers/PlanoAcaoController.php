<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanoAcaoRequest;
use App\Models\AvaliacaoRisco;
use App\Models\PlanoAcao;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanoAcaoController extends Controller
{
    // -------------------------------------------------------------------------
    // Helpers para carregar hierarquia completa e verificar empresa
    // (mesmo padrão do AvaliacaoRiscoController)
    // -------------------------------------------------------------------------

    /** Retorna AvaliacaoRisco com hierarquia completa carregada do banco. */
    private function freshAvaliacao(AvaliacaoRisco $avaliacao, array $extra = []): AvaliacaoRisco
    {
        return AvaliacaoRisco::with(array_merge([
            'riscoInventario.ghe.setor.unidade',
        ], $extra))->findOrFail($avaliacao->id);
    }

    /** Retorna PlanoAcao com hierarquia completa carregada do banco. */
    private function freshPlano(PlanoAcao $plano, array $extra = []): PlanoAcao
    {
        return PlanoAcao::with(array_merge([
            'avaliacaoRisco.riscoInventario.ghe.setor.unidade',
        ], $extra))->findOrFail($plano->id);
    }

    /** Confirma que o usuário logado pertence à empresa da unidade. */
    private function autorizarPorUnidade(AvaliacaoRisco $avaliacao, bool $exigeEscrita = false): void
    {
        $unidade = $avaliacao->riscoInventario?->ghe?->setor?->unidade;

        abort_unless(
            $unidade && (int) auth()->user()->empresa_id === (int) $unidade->empresa_id,
            403
        );

        if ($exigeEscrita) {
            abort_unless(auth()->user()->canWrite(), 403);
        }
    }

    // -------------------------------------------------------------------------
    // Rotas nested: avaliacoes/{avaliacao}/planos
    // -------------------------------------------------------------------------

    public function index(AvaliacaoRisco $avaliacao): View
    {
        $avaliacao = $this->freshAvaliacao($avaliacao, ['riscoInventario.riscoTipo']);
        $this->autorizarPorUnidade($avaliacao);

        $planos = $avaliacao->planosAcao()
            ->orderByRaw("FIELD(status, 'em_andamento', 'pendente', 'concluido')")
            ->orderBy('prazo')
            ->get();

        return view('planos.index', compact('avaliacao', 'planos'));
    }

    public function create(AvaliacaoRisco $avaliacao): View
    {
        $avaliacao = $this->freshAvaliacao($avaliacao, ['riscoInventario.riscoTipo']);
        $this->autorizarPorUnidade($avaliacao, exigeEscrita: true);

        return view('planos.create', compact('avaliacao'));
    }

    public function store(PlanoAcaoRequest $request, AvaliacaoRisco $avaliacao): RedirectResponse
    {
        $avaliacao = $this->freshAvaliacao($avaliacao);
        $this->autorizarPorUnidade($avaliacao, exigeEscrita: true);

        $dados = $request->validated();
        $dados['avaliacao_risco_id'] = $avaliacao->id;

        PlanoAcao::create($dados);

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Plano de ação cadastrado com sucesso.');
    }

    // -------------------------------------------------------------------------
    // Rotas shallow: planos/{plano}
    // -------------------------------------------------------------------------

    public function show(PlanoAcao $plano): View
    {
        $plano = $this->freshPlano($plano, [
            'avaliacaoRisco.riscoInventario.riscoTipo',
        ]);
        $this->autorizarPorUnidade($plano->avaliacaoRisco);

        return view('planos.show', compact('plano'));
    }

    public function edit(PlanoAcao $plano): View
    {
        $plano = $this->freshPlano($plano, [
            'avaliacaoRisco.riscoInventario.riscoTipo',
        ]);
        $this->autorizarPorUnidade($plano->avaliacaoRisco, exigeEscrita: true);

        return view('planos.edit', compact('plano'));
    }

    public function update(PlanoAcaoRequest $request, PlanoAcao $plano): RedirectResponse
    {
        $plano = $this->freshPlano($plano);
        $this->autorizarPorUnidade($plano->avaliacaoRisco, exigeEscrita: true);

        $plano->update($request->validated());

        return redirect()->route('planos.show', $plano)
            ->with('success', 'Plano de ação atualizado.');
    }

    public function destroy(PlanoAcao $plano): RedirectResponse
    {
        $plano = $this->freshPlano($plano);
        $this->autorizarPorUnidade($plano->avaliacaoRisco, exigeEscrita: true);

        $avaliacao = $plano->avaliacaoRisco;
        $plano->delete();

        return redirect()->route('avaliacoes.show', $avaliacao)
            ->with('success', 'Plano de ação removido.');
    }
}
