<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Unidade;
use Illuminate\Http\Request;

class RelatorioPgrController extends Controller
{
    /**
     * Monta o relatório PGR completo para a empresa do usuário logado.
     * Aceita ?unidade_id= para filtrar por unidade.
     */
    public function index(Request $request)
    {
        $empresa = auth()->user()->empresa;

        if (!$empresa) {
            return redirect()->route('dashboard')
                ->with('error', 'Nenhuma empresa associada a este usuário.');
        }

        $empresa->load([
            'unidades' => function ($q) {
                $q->orderBy('nome');
            },
        ]);

        $unidades = $empresa->unidades;
        $unidadeFiltro = $request->integer('unidade_id') ?: null;

        // Carrega toda a hierarquia: unidade → setor → ghe → riscos → avaliação mais recente → planos
        $unidadesRelatorio = Unidade::where('empresa_id', $empresa->id)
            ->when($unidadeFiltro, fn ($q) => $q->where('id', $unidadeFiltro))
            ->orderBy('nome')
            ->with([
                'setores' => function ($q) {
                    $q->orderBy('nome')
                      ->with([
                          'ghes' => function ($q) {
                              $q->orderBy('nome')
                                ->with([
                                    'riscosInventario' => function ($q) {
                                        $q->with([
                                            'riscoTipo',
                                            'avaliacoes' => function ($q) {
                                                $q->latest()->limit(1)
                                                  ->with(['planosAcao', 'avaliador']);
                                            },
                                        ])->orderBy('created_at');
                                    },
                                ]);
                          },
                      ]);
                },
            ])
            ->get();

        $geradoEm = now();

        return view('relatorio.pgr', compact(
            'empresa',
            'unidades',
            'unidadesRelatorio',
            'unidadeFiltro',
            'geradoEm'
        ));
    }

    /**
     * Mesma view, mas com parâmetro ?pdf=1 para impressão via Ctrl+P.
     * A view detecta esse parâmetro e ajusta o layout.
     */
    public function pdf(Request $request)
    {
        return $this->index($request->merge(['pdf' => 1]));
    }
}
