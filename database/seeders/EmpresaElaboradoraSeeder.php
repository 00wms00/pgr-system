<?php

namespace Database\Seeders;

use App\Models\EmpresaElaboradora;
use App\Models\ResponsavelTecnico;

class EmpresaElaboradoraSeeder extends Seeder
{
    /**
     * Dados de exemplo baseados no modelo real K3M Engenharia (PGR Gelar, 2024).
     * Idempotente: usa updateOrCreate para não duplicar ao rodar novamente.
     */
    public function run(): void
    {
        $elaboradora = EmpresaElaboradora::updateOrCreate(
            ['cnpj' => '23.376.968/0001-12'],
            [
                'razao_social'   => 'K3M ENGENHARIA SAUDE E SEGURANCA DO TRABALHO LTDA',
                'nome_fantasia'  => 'K3M ENGENHARIA',
                'cnae_codigo'    => '71.12-0-00',
                'cnae_descricao' => 'Serviços de engenharia',
                'logradouro'     => 'R Jaime Vasconcelos',
                'numero'         => '577',
                'complemento'   => null,
                'bairro'         => 'Varjota',
                'cidade'         => 'Fortaleza',
                'uf'             => 'CE',
                'cep'            => '60.165-260',
                'telefone'       => '(85) 9.8138.7773',
                'email'          => 'engenheiromichel@outlook.com',
                'site'           => 'https://www.k3mengenharia.com.br',
            ]
        );

        ResponsavelTecnico::updateOrCreate(
            [
                'empresa_elaboradora_id' => $elaboradora->id,
                'numero_registro'        => '335731',
            ],
            [
                'nome'            => 'Michel Moreira dos Santos',
                'formacao'        => 'Engenheiro de Produção',
                'especializacao'  => 'Engenharia de Segurança do Trabalho',
                'tipo_registro'   => 'CREA',
                'uf_registro'     => 'CE',
                'numero_art_rrt'  => null,
                'email'           => 'engenheiromichel@outlook.com',
                'telefone'        => '(85) 9.8138.7773',
            ]
        );

        // RNP — Registro Nacional de Profissionais (Técnico de Segurança)
        ResponsavelTecnico::updateOrCreate(
            [
                'empresa_elaboradora_id' => $elaboradora->id,
                'numero_registro'        => '0617647453',
            ],
            [
                'nome'            => 'Michel Moreira dos Santos',
                'formacao'        => 'Engenheiro de Produção',
                'especializacao'  => 'Engenharia de Segurança do Trabalho',
                'tipo_registro'   => 'RNP',
                'uf_registro'     => null,
                'numero_art_rrt'  => null,
            ]
        );
    }
}
