<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Unidade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioPgrController extends Controller
{
    /**
     * Monta o relatório PGR completo para a empresa do usuário logado.
     * Aceita ?unidade_id= para filtrar por unidade.
     */
    public function index(Request $request)
    {
        [$empresa, $unidades, $unidadesRelatorio, $unidadeFiltro, $geradoEm] = $this->dados($request);

        if (! $empresa) {
            return redirect()->route('dashboard')
                ->with('error', 'Nenhuma empresa associada a este usuário.');
        }

        return view('relatorio.pgr', compact(
            'empresa',
            'unidades',
            'unidadesRelatorio',
            'unidadeFiltro',
            'geradoEm'
        ));
    }

    /**
     * Exporta o relatório PGR como PDF via dompdf.
     */
    public function exportarPdf(Request $request)
    {
        [$empresa, $unidades, $unidadesRelatorio, $unidadeFiltro, $geradoEm] = $this->dados($request);

        if (! $empresa) {
            return redirect()->route('dashboard')
                ->with('error', 'Nenhuma empresa associada a este usuário.');
        }

        $pdf = Pdf::loadView('relatorio.pgr-pdf', compact(
            'empresa',
            'unidades',
            'unidadesRelatorio',
            'unidadeFiltro',
            'geradoEm'
        ))
        ->setPaper('a4', 'landscape')
        ->setOption('defaultFont', 'DejaVu Sans')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', false);

        $nomeArquivo = 'PGR_'
            . str_replace([' ', '/'], '_', $empresa->razao_social)
            . '_'
            . $geradoEm->format('Y-m-d')
            . '.pdf';

        return $pdf->download($nomeArquivo);
    }

    // ----------------------------------------------------------------
    // PRIVADO
    // ----------------------------------------------------------------

    private function dados(Request $request): array
    {
        $empresa = auth()->user()->empresa;

        if (! $empresa) {
            return [null, null, null, null, null];
        }

        $empresa->load(['unidades' => fn ($q) => $q->orderBy('nome')]);

        $unidades      = $empresa->unidades;
        $unidadeFiltro = $request->integer('unidade_id') ?: null;

        $unidadesRelatorio = Unidade::where('empresa_id', $empresa->id)
            ->when($unidadeFiltro, fn ($q) => $q->where('id', $unidadeFiltro))
            ->orderBy('nome')
            ->with([
                'setores' => fn ($q) => $q->orderBy('nome')->with([
                    'ghes' => fn ($q) => $q->orderBy('nome')->with([
                        'riscosInventario' => fn ($q) => $q
                            ->with([
                                'riscoTipo',
                                'avaliacoes' => fn ($q) => $q
                                    ->latest()
                                    ->limit(1)
                                    ->with(['planosAcao', 'avaliador']),
                            ])
                            ->orderBy('created_at'),
                    ]),
                ]),
            ])
            ->get();

        return [$empresa, $unidades, $unidadesRelatorio, $unidadeFiltro, now()];
    }
}
