<?php

namespace Database\Seeders;

use App\Models\RiscoTipo;
use Illuminate\Database\Seeder;

class RiscoTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['codigo' => '01.01.001', 'categoria' => 'Físico', 'nome' => 'Ruído', 'descricao' => 'Exposição a ruído contínuo ou intermitente.'],
            ['codigo' => '01.01.002', 'categoria' => 'Físico', 'nome' => 'Vibração', 'descricao' => 'Exposição a vibrações localizadas ou de corpo inteiro.'],
            ['codigo' => '01.01.003', 'categoria' => 'Físico', 'nome' => 'Calor', 'descricao' => 'Sobrecarga térmica por fontes artificiais ou ambiente.'],
            ['codigo' => '01.01.004', 'categoria' => 'Físico', 'nome' => 'Frio', 'descricao' => 'Exposição ocupacional ao frio.'],
            ['codigo' => '01.01.005', 'categoria' => 'Físico', 'nome' => 'Umidade', 'descricao' => 'Exposição a ambientes alagados, encharcados ou úmidos.'],
            ['codigo' => '01.01.006', 'categoria' => 'Físico', 'nome' => 'Radiações ionizantes', 'descricao' => 'Exposição a radiações ionizantes.'],
            ['codigo' => '01.01.007', 'categoria' => 'Físico', 'nome' => 'Radiações não ionizantes', 'descricao' => 'Exposição a radiações não ionizantes.'],
            ['codigo' => '01.01.008', 'categoria' => 'Físico', 'nome' => 'Pressões anormais', 'descricao' => 'Atividades sob pressões acima ou abaixo da atmosférica.'],
            ['codigo' => '01.02.001', 'categoria' => 'Químico', 'nome' => 'Poeiras', 'descricao' => 'Exposição a poeiras minerais, vegetais ou metálicas.'],
            ['codigo' => '01.02.002', 'categoria' => 'Químico', 'nome' => 'Fumos', 'descricao' => 'Exposição a fumos metálicos ou de outros processos.'],
            ['codigo' => '01.02.003', 'categoria' => 'Químico', 'nome' => 'Névoas', 'descricao' => 'Exposição a névoas ou aerossóis químicos.'],
            ['codigo' => '01.02.004', 'categoria' => 'Químico', 'nome' => 'Neblinas', 'descricao' => 'Exposição a neblinas de substâncias químicas.'],
            ['codigo' => '01.02.005', 'categoria' => 'Químico', 'nome' => 'Gases', 'descricao' => 'Exposição a gases ocupacionais.'],
            ['codigo' => '01.02.006', 'categoria' => 'Químico', 'nome' => 'Vapores', 'descricao' => 'Exposição a vapores de solventes e outros agentes.'],
            ['codigo' => '01.02.007', 'categoria' => 'Químico', 'nome' => 'Substâncias químicas por contato', 'descricao' => 'Contato dérmico com agentes químicos.'],
            ['codigo' => '01.03.001', 'categoria' => 'Biológico', 'nome' => 'Vírus', 'descricao' => 'Exposição a vírus em atividades ocupacionais.'],
            ['codigo' => '01.03.002', 'categoria' => 'Biológico', 'nome' => 'Bactérias', 'descricao' => 'Exposição a bactérias em atividades ocupacionais.'],
            ['codigo' => '01.03.003', 'categoria' => 'Biológico', 'nome' => 'Fungos', 'descricao' => 'Exposição a fungos em atividades ocupacionais.'],
            ['codigo' => '01.03.004', 'categoria' => 'Biológico', 'nome' => 'Parasitas', 'descricao' => 'Exposição a parasitas e protozoários.'],
            ['codigo' => '01.03.005', 'categoria' => 'Biológico', 'nome' => 'Bacilos', 'descricao' => 'Exposição a bacilos patogênicos.'],
            ['codigo' => '01.04.001', 'categoria' => 'Ergonômico', 'nome' => 'Levantamento e transporte manual de cargas', 'descricao' => 'Movimentação manual de materiais com sobrecarga física.'],
            ['codigo' => '01.04.002', 'categoria' => 'Ergonômico', 'nome' => 'Posturas inadequadas', 'descricao' => 'Posturas forçadas ou mantidas por tempo prolongado.'],
            ['codigo' => '01.04.003', 'categoria' => 'Ergonômico', 'nome' => 'Repetitividade', 'descricao' => 'Movimentos repetitivos de membros superiores ou inferiores.'],
            ['codigo' => '01.04.004', 'categoria' => 'Ergonômico', 'nome' => 'Ritmo excessivo de trabalho', 'descricao' => 'Exigência de produtividade incompatível com limites humanos.'],
            ['codigo' => '01.04.005', 'categoria' => 'Ergonômico', 'nome' => 'Jornada prolongada', 'descricao' => 'Exposição a jornadas extensas e pausas insuficientes.'],
            ['codigo' => '01.04.006', 'categoria' => 'Ergonômico', 'nome' => 'Monotonia e repetição', 'descricao' => 'Atividades monótonas com baixa variabilidade.'],
            ['codigo' => '01.05.001', 'categoria' => 'Acidente', 'nome' => 'Máquinas e equipamentos sem proteção', 'descricao' => 'Risco de acidentes por ausência de proteção coletiva.'],
            ['codigo' => '01.05.002', 'categoria' => 'Acidente', 'nome' => 'Ferramentas inadequadas ou defeituosas', 'descricao' => 'Uso de ferramentas inseguras.'],
            ['codigo' => '01.05.003', 'categoria' => 'Acidente', 'nome' => 'Eletricidade', 'descricao' => 'Contato com energia elétrica.'],
            ['codigo' => '01.05.004', 'categoria' => 'Acidente', 'nome' => 'Incêndio ou explosão', 'descricao' => 'Situações com inflamáveis, combustíveis ou atmosferas explosivas.'],
            ['codigo' => '01.05.005', 'categoria' => 'Acidente', 'nome' => 'Arranjo físico inadequado', 'descricao' => 'Layout inseguro, circulação deficiente ou obstruída.'],
            ['codigo' => '01.05.006', 'categoria' => 'Acidente', 'nome' => 'Queda de mesmo nível', 'descricao' => 'Escorregões, tropeços e outros eventos sem diferença de nível.'],
            ['codigo' => '01.05.007', 'categoria' => 'Acidente', 'nome' => 'Queda de nível', 'descricao' => 'Trabalho em altura ou desníveis sem proteção adequada.'],
        ];

        foreach ($tipos as $tipo) {
            RiscoTipo::updateOrCreate(
                ['codigo' => $tipo['codigo']],
                $tipo
            );
        }
    }
}
