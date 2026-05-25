<?php

namespace Database\Seeders;

use App\Models\AgenteQuantitativo;
use App\Models\AgenteFaixa;
use App\Models\RiscoTipo;
use Illuminate\Database\Seeder;

class AgentesQuantitativosSeeder extends Seeder
{
    public function run(): void
    {
        // Coluna correta é 'grupo', não 'tipo'
        $fisico = RiscoTipo::where('grupo', 'like', '%sico%')->first();

        if (! $fisico) {
            $this->command->warn('RiscoTipo físico não encontrado. Execute o RiscoTiposSeeder antes.');
            $this->command->warn('Grupos disponíveis: ' . RiscoTipo::pluck('grupo')->implode(', '));
            return;
        }

        $this->command->info("Usando RiscoTipo: [{$fisico->id}] {$fisico->nome} (grupo: {$fisico->grupo})");

        // ================================================================
        // 1. RUÍDO CONTÍNUO / INTERMITENTE — NR-15 Anexo I
        // ================================================================
        $ruidoContinuo = AgenteQuantitativo::updateOrCreate(
            ['nome' => 'Ruído Contínuo / Intermitente', 'risco_tipo_id' => $fisico->id],
            [
                'unidade_medida'    => 'dB(A)',
                'campo_label'       => 'Nível de Pressão Sonora Equivalente (Leq)',
                'nivel_acao'        => 80.0,
                'limite_tolerancia' => 85.0,
                'limite_rgi'        => 115.0,
                'norma_referencia'  => 'NR-15 Anexo I / NHO-01 Fundacentro',
                'input_step'        => '0.1',
            ]
        );

        $this->criarFaixas($ruidoContinuo->id, [
            [
                'valor_min'         => 0.0,
                'valor_max'         => 79.99,
                'probabilidade'     => 1,
                'severidade'        => 2,
                'classificacao'     => 'baixo',
                'gatilho'           => false,
                'descricao_gatilho' => null,
                'ordem'             => 1,
            ],
            [
                'valor_min'         => 80.0,
                'valor_max'         => 84.99,
                'probabilidade'     => 3,
                'severidade'        => 3,
                'classificacao'     => 'moderado',
                'gatilho'           => true,
                'descricao_gatilho' => 'Nível de Ação atingido (≥80 dB(A) — NHO-01). Implementar: monitoramento audiométrico periódico, fornecimento preventivo de EPI auditivo (CA válido) e programa de conservação auditiva (PCA).',
                'ordem'             => 2,
            ],
            [
                'valor_min'         => 85.0,
                'valor_max'         => 114.99,
                'probabilidade'     => 5,
                'severidade'        => 4,
                'classificacao'     => 'alto',
                'gatilho'           => true,
                'descricao_gatilho' => 'Limite de Tolerância ultrapassado (≥85 dB(A) — NR-15 Anexo I). Implementar imediatamente: controles de engenharia (enclausuramento/silenciadores), proteção auditiva obrigatória (CA válido), controle audiométrico admissional e periódico, e inscrição no PCMSO.',
                'ordem'             => 3,
            ],
            [
                'valor_min'         => 115.0,
                'valor_max'         => null,
                'probabilidade'     => 5,
                'severidade'        => 5,
                'classificacao'     => 'critico',
                'gatilho'           => true,
                'descricao_gatilho' => 'RISCO GRAVE E IMINENTE — NR-3 / NR-15 Anexo I §5. Nível ≥115 dB(A) sem proteção adequada. Interditar imediatamente a atividade, notificar o SESMT/CIPA, fornecer protetor auditivo de alto NRR e acionar plano de emergência de saúde auditiva.',
                'ordem'             => 4,
            ],
        ]);

        // ================================================================
        // 2. RUÍDO DE IMPACTO — NR-15 Anexo II
        // ================================================================
        $ruidoImpacto = AgenteQuantitativo::updateOrCreate(
            ['nome' => 'Ruído de Impacto', 'risco_tipo_id' => $fisico->id],
            [
                'unidade_medida'    => 'dB(linear)',
                'campo_label'       => 'Nível de Pico de Pressão Sonora',
                'nivel_acao'        => 120.0,
                'limite_tolerancia' => 130.0,
                'limite_rgi'        => 140.0,
                'norma_referencia'  => 'NR-15 Anexo II',
                'input_step'        => '1',
            ]
        );

        $this->criarFaixas($ruidoImpacto->id, [
            [
                'valor_min'         => 0.0,
                'valor_max'         => 119.99,
                'probabilidade'     => 1,
                'severidade'        => 2,
                'classificacao'     => 'baixo',
                'gatilho'           => false,
                'descricao_gatilho' => null,
                'ordem'             => 1,
            ],
            [
                'valor_min'         => 120.0,
                'valor_max'         => 129.99,
                'probabilidade'     => 3,
                'severidade'        => 3,
                'classificacao'     => 'moderado',
                'gatilho'           => true,
                'descricao_gatilho' => 'Nível de Ação para ruído de impacto atingido (≥120 dB linear). Fornecer protetor auditivo e realizar audiometria periódica.',
                'ordem'             => 2,
            ],
            [
                'valor_min'         => 130.0,
                'valor_max'         => 139.99,
                'probabilidade'     => 5,
                'severidade'        => 4,
                'classificacao'     => 'alto',
                'gatilho'           => true,
                'descricao_gatilho' => 'Limite de Tolerância de ruído de impacto ultrapassado (≥130 dB linear — NR-15 Anexo II). Implementar controles de engenharia (amortecimento, isolamento), proteção auditiva obrigatória e vigilância médica.',
                'ordem'             => 3,
            ],
            [
                'valor_min'         => 140.0,
                'valor_max'         => null,
                'probabilidade'     => 5,
                'severidade'        => 5,
                'classificacao'     => 'critico',
                'gatilho'           => true,
                'descricao_gatilho' => 'RISCO GRAVE E IMINENTE — NR-15 Anexo II §4. Pico ≥140 dB(linear). Interditar imediatamente a atividade e notificar o MTE.',
                'ordem'             => 4,
            ],
        ]);

        // ================================================================
        // 3. CALOR (IBUTG) — NR-15 Anexo III (Atividade Moderada)
        // ================================================================
        $calor = AgenteQuantitativo::updateOrCreate(
            ['nome' => 'Calor (IBUTG)', 'risco_tipo_id' => $fisico->id],
            [
                'unidade_medida'    => '°C (IBUTG)',
                'campo_label'       => 'Índice de Bulbo Úmido — Termômetro de Globo (IBUTG)',
                'nivel_acao'        => 25.0,
                'limite_tolerancia' => 26.7,
                'limite_rgi'        => 31.1,
                'norma_referencia'  => 'NR-15 Anexo III (Atividade Moderada)',
                'input_step'        => '0.1',
            ]
        );

        $this->criarFaixas($calor->id, [
            [
                'valor_min'         => 0.0,
                'valor_max'         => 24.99,
                'probabilidade'     => 1,
                'severidade'        => 1,
                'classificacao'     => 'baixo',
                'gatilho'           => false,
                'descricao_gatilho' => null,
                'ordem'             => 1,
            ],
            [
                'valor_min'         => 25.0,
                'valor_max'         => 26.69,
                'probabilidade'     => 2,
                'severidade'        => 3,
                'classificacao'     => 'moderado',
                'gatilho'           => true,
                'descricao_gatilho' => 'Aproximando do Limite de Tolerância para calor (atividade moderada). Implementar pausas, aclimatação dos trabalhadores, hidratação regular e monitoramento IBUTG contínuo.',
                'ordem'             => 2,
            ],
            [
                'valor_min'         => 26.7,
                'valor_max'         => 31.09,
                'probabilidade'     => 4,
                'severidade'        => 4,
                'classificacao'     => 'alto',
                'gatilho'           => true,
                'descricao_gatilho' => 'Limite de Tolerância para calor ultrapassado (IBUTG > 26,7°C — NR-15 Anexo III, Atividade Moderada). Adotar regime de trabalho intermitente com pausas obrigatórias conforme Quadro N.°1, ventilação forçada, EPI específico (roupa de resfriamento) e exame médico periódico.',
                'ordem'             => 3,
            ],
            [
                'valor_min'         => 31.1,
                'valor_max'         => null,
                'probabilidade'     => 5,
                'severidade'        => 5,
                'classificacao'     => 'critico',
                'gatilho'           => true,
                'descricao_gatilho' => 'RISCO GRAVE E IMINENTE — NR-15 Anexo III. IBUTG > 31,1°C para atividade moderada: trabalho NÃO PERMITIDO sem medidas adequadas de controle. Suspender a atividade imediatamente, instalar sistema de climatização ou realocar o trabalhador.',
                'ordem'             => 4,
            ],
        ]);

        $this->command->info('✅ AgentesQuantitativos: Ruído Contínuo, Ruído de Impacto e Calor (IBUTG) cadastrados com sucesso.');
    }

    private function criarFaixas(int $agenteId, array $faixas): void
    {
        AgenteFaixa::where('agente_quantitativo_id', $agenteId)->delete();

        foreach ($faixas as $f) {
            AgenteFaixa::create([
                'agente_quantitativo_id' => $agenteId,
                'valor_min'              => $f['valor_min'],
                'valor_max'              => $f['valor_max'],
                'probabilidade'          => $f['probabilidade'],
                'severidade'             => $f['severidade'],
                'classificacao'          => $f['classificacao'],
                'gatilho_plano_acao'     => $f['gatilho'],
                'descricao_gatilho'      => $f['descricao_gatilho'],
                'ordem'                  => $f['ordem'],
            ]);
        }
    }
}
