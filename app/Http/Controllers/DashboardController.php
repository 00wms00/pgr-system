<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoRisco;
use App\Models\Ghe;
use App\Models\PlanoAcao;
use App\Models\RiscoInventario;
use App\Models\Unidade;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $empresaId = auth()->user()->empresa_id;

        // KPIs
        $totalRiscos    = RiscoInventario::count();
        $totalGhes      = Ghe::count();
        $totalUnidades  = Unidade::count();
        $totalPlanos    = PlanoAcao::whereHas('avaliacaoRisco.riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->count();

        // Distribuicao por classificacao
        $distribuicao = AvaliacaoRisco::whereHas('riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->select('classificacao', DB::raw('count(*) as total'))
            ->groupBy('classificacao')
            ->pluck('total', 'classificacao')
            ->toArray();

        $classificacoes = ['critico' => 0, 'alto' => 0, 'moderado' => 0, 'baixo' => 0];
        foreach ($classificacoes as $k => $_) {
            $classificacoes[$k] = $distribuicao[$k] ?? 0;
        }

        // Planos por status
        $planosPorStatus = PlanoAcao::whereHas('avaliacaoRisco.riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Planos vencidos/proximos do prazo
        $planosAtrasados = PlanoAcao::whereHas('avaliacaoRisco.riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->where('status', '!=', 'concluido')
            ->where('prazo', '<', now())
            ->count();

        $planosProximos = PlanoAcao::whereHas('avaliacaoRisco.riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->where('status', '!=', 'concluido')
            ->whereBetween('prazo', [now(), now()->addDays(30)])
            ->count();

        // Ultimos riscos criticos/altos sem plano
        $riscosSemPlano = RiscoInventario::with(['riscoTipo', 'ghe', 'avaliacoes'])
            ->whereHas('avaliacoes', function ($q) {
                $q->whereIn('classificacao', ['critico', 'alto']);
            })
            ->whereDoesntHave('avaliacoes.planosAcao')
            ->latest()
            ->take(5)
            ->get();

        // Planos em aberto proximos
        $proximosPlanos = PlanoAcao::with(['avaliacaoRisco.riscoInventario.riscoTipo'])
            ->whereHas('avaliacaoRisco.riscoInventario.ghe.setor.unidade', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->where('status', '!=', 'concluido')
            ->orderBy('prazo')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRiscos', 'totalGhes', 'totalUnidades', 'totalPlanos',
            'classificacoes', 'planosPorStatus',
            'planosAtrasados', 'planosProximos',
            'riscosSemPlano', 'proximosPlanos'
        ));
    }
}
