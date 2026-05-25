<?php

namespace App\Services;

use App\Models\AgenteQuantitativo;
use App\Models\AgenteFaixa;
use App\Models\RiscoInventario;
use App\Models\PlanoAcao;

class RiscoCalculadorService
{
    /**
     * Calcula probabilidade, severidade e classificação a partir
     * de um agente quantitativo e um valor medido.
     *
     * @return array{probabilidade:int, severidade:int, nivel:int,
     *               classificacao:string, classificacao_label:string,
     *               gatilho:bool, descricao_gatilho:string|null,
     *               faixa_id:int|null}
     */
    public function calcular(AgenteQuantitativo $agente, float $valor): array
    {
        $faixa = $agente->faixaParaValor($valor);

        if (! $faixa) {
            return [
                'probabilidade'      => 1,
                'severidade'         => 1,
                'nivel'              => 1,
                'classificacao'      => 'baixo',
                'classificacao_label'=> 'Baixo',
                'gatilho'            => false,
                'descricao_gatilho'  => null,
                'faixa_id'           => null,
            ];
        }

        return [
            'probabilidade'       => $faixa->probabilidade,
            'severidade'          => $faixa->severidade,
            'nivel'               => $faixa->nivel_risco,
            'classificacao'       => $faixa->classificacao,
            'classificacao_label' => $faixa->classificacao_label,
            'gatilho'             => $faixa->gatilho_plano_acao,
            'descricao_gatilho'   => $faixa->descricao_gatilho,
            'faixa_id'            => $faixa->id,
        ];
    }

    /**
     * Aplica o resultado do cálculo ao risco e, se gatilho ativo,
     * cria um PlanoAcao automático com status pendente.
     */
    public function aplicarAoRisco(RiscoInventario $risco, array $resultado): void
    {
        $risco->update([
            'probabilidade_calculada'  => $resultado['probabilidade'],
            'severidade_calculada'     => $resultado['severidade'],
            'classificacao_calculada'  => $resultado['classificacao'],
        ]);

        if ($resultado['gatilho'] && $resultado['descricao_gatilho']) {
            // Verifica se já existe plano automático para este risco
            // (evita duplicar em re-salvamentos)
            $jaExiste = PlanoAcao::where('risco_inventario_id', $risco->id)
                ->where('origem', 'automatico')
                ->exists();

            if (! $jaExiste) {
                PlanoAcao::create([
                    'risco_inventario_id' => $risco->id,
                    'descricao'           => $resultado['descricao_gatilho'],
                    'responsavel'         => null,
                    'prazo'               => null,
                    'status'              => 'pendente',
                    'origem'              => 'automatico',
                ]);
            }
        }
    }
}
