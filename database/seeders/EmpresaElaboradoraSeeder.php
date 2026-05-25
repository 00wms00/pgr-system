<?php

namespace Database\Seeders;

use App\Models\EmpresaElaboradora;
use Illuminate\Database\Seeder;

class EmpresaElaboradoraSeeder extends Seeder
{
    /**
     * Seeder idempotente — usa updateOrCreate pelo CNPJ.
     * Baseado nos modelos reais dos PDFs de referência.
     */
    public function run(): void
    {
        // Empresa de referência 1 — modelo PGR Gelar (K3M Engenharia)
        EmpresaElaboradora::updateOrCreate(
            ['cnpj' => '23.376.968/0001-12'],
            [
                'razao_social'               => 'K3M ENGENHARIA SAUDE E SEGURANCA DO TRABALHO LTDA',
                'nome_fantasia'              => 'K3M ENGENHARIA',
                'cnae_principal'             => '71.12-0-00',
                'cnae_descricao'             => 'Serviços de engenharia',
                'logradouro'                 => 'Rua Jaime Vasconcelos',
                'numero'                     => '577',
                'bairro'                     => 'Varjota',
                'cidade'                     => 'Fortaleza',
                'uf'                         => 'CE',
                'cep'                        => '60165-260',
                'telefone'                   => '(85) 9.8138.7773',
                'email'                      => 'engenheiro.michel@outlook.com',
                'site'                       => 'https://www.k3mengenharia.com.br',
                'responsavel_nome'           => 'Michel Moreira dos Santos',
                'responsavel_formacao'       => 'Engenheiro de Produção',
                'responsavel_especializacao' => 'Engenharia de Segurança do Trabalho',
                'responsavel_registro_tipo'  => 'CREA',
                'responsavel_registro_numero'=> '335731 - CE',
                'responsavel_rnp'            => '0617647453',
                'responsavel_cargo'          => 'Engenheiro de Segurança do Trabalho',
                'ativo'                      => true,
            ]
        );

        // Empresa de referência 2 — modelo PGR Matelandia (SESI)
        EmpresaElaboradora::updateOrCreate(
            ['cnpj' => '03.777.341/0001-76'], // SESI-PR (CNPJ referência)
            [
                'razao_social'               => 'SERVIÇO SOCIAL DA INDÚSTRIA - SESI',
                'nome_fantasia'              => 'SESI / Sistema FIEP',
                'cnae_principal'             => '85.99-6-04',
                'cnae_descricao'             => 'Treinamento em desenvolvimento profissional e gerencial',
                'logradouro'                 => 'Av. Cândido de Abreu',
                'numero'                     => '200',
                'bairro'                     => 'Centro Cívico',
                'cidade'                     => 'Curitiba',
                'uf'                         => 'PR',
                'cep'                        => '80530-902',
                'telefone'                   => '(41) 3271-9000',
                'site'                       => 'https://www.sesipr.org.br',
                'responsavel_nome'           => 'Wagner Camargo Rodrigues',
                'responsavel_registro_tipo'  => 'CREA',
                'responsavel_registro_numero'=> '207090-D/PR',
                'responsavel_cpf'            => '022.094.639-63',
                'responsavel_nit'            => '125.08139.21-3',
                'responsavel_cargo'          => 'Engenheiro de Segurança do Trabalho',
                'ativo'                      => true,
            ]
        );
    }
}
