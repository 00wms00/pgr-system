<?php

namespace Database\Seeders;

use App\Models\RiscoTipo;
use Illuminate\Database\Seeder;

class RiscoTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['codigo_esocial' => '01.01.001', 'grupo' => 'Físico',     'nome' => 'Ruído'],
            ['codigo_esocial' => '01.01.002', 'grupo' => 'Físico',     'nome' => 'Vibração'],
            ['codigo_esocial' => '01.01.003', 'grupo' => 'Físico',     'nome' => 'Calor'],
            ['codigo_esocial' => '01.01.004', 'grupo' => 'Físico',     'nome' => 'Frio'],
            ['codigo_esocial' => '01.01.005', 'grupo' => 'Físico',     'nome' => 'Umidade'],
            ['codigo_esocial' => '01.01.006', 'grupo' => 'Físico',     'nome' => 'Radiações ionizantes'],
            ['codigo_esocial' => '01.01.007', 'grupo' => 'Físico',     'nome' => 'Radiações não ionizantes'],
            ['codigo_esocial' => '01.01.008', 'grupo' => 'Físico',     'nome' => 'Pressões anormais'],
            ['codigo_esocial' => '01.02.001', 'grupo' => 'Químico',    'nome' => 'Poeiras'],
            ['codigo_esocial' => '01.02.002', 'grupo' => 'Químico',    'nome' => 'Fumos'],
            ['codigo_esocial' => '01.02.003', 'grupo' => 'Químico',    'nome' => 'Névoas'],
            ['codigo_esocial' => '01.02.004', 'grupo' => 'Químico',    'nome' => 'Neblinas'],
            ['codigo_esocial' => '01.02.005', 'grupo' => 'Químico',    'nome' => 'Gases'],
            ['codigo_esocial' => '01.02.006', 'grupo' => 'Químico',    'nome' => 'Vapores'],
            ['codigo_esocial' => '01.02.007', 'grupo' => 'Químico',    'nome' => 'Substâncias químicas por contato'],
            ['codigo_esocial' => '01.03.001', 'grupo' => 'Biológico',  'nome' => 'Vírus'],
            ['codigo_esocial' => '01.03.002', 'grupo' => 'Biológico',  'nome' => 'Bactérias'],
            ['codigo_esocial' => '01.03.003', 'grupo' => 'Biológico',  'nome' => 'Fungos'],
            ['codigo_esocial' => '01.03.004', 'grupo' => 'Biológico',  'nome' => 'Parasitas'],
            ['codigo_esocial' => '01.03.005', 'grupo' => 'Biológico',  'nome' => 'Bacilos'],
            ['codigo_esocial' => '01.04.001', 'grupo' => 'Ergonômico', 'nome' => 'Levantamento e transporte manual de cargas'],
            ['codigo_esocial' => '01.04.002', 'grupo' => 'Ergonômico', 'nome' => 'Posturas inadequadas'],
            ['codigo_esocial' => '01.04.003', 'grupo' => 'Ergonômico', 'nome' => 'Repetitividade'],
            ['codigo_esocial' => '01.04.004', 'grupo' => 'Ergonômico', 'nome' => 'Ritmo excessivo de trabalho'],
            ['codigo_esocial' => '01.04.005', 'grupo' => 'Ergonômico', 'nome' => 'Jornada prolongada'],
            ['codigo_esocial' => '01.04.006', 'grupo' => 'Ergonômico', 'nome' => 'Monotonia e repetição'],
            ['codigo_esocial' => '01.05.001', 'grupo' => 'Acidente',   'nome' => 'Máquinas e equipamentos sem proteção'],
            ['codigo_esocial' => '01.05.002', 'grupo' => 'Acidente',   'nome' => 'Ferramentas inadequadas ou defeituosas'],
            ['codigo_esocial' => '01.05.003', 'grupo' => 'Acidente',   'nome' => 'Eletricidade'],
            ['codigo_esocial' => '01.05.004', 'grupo' => 'Acidente',   'nome' => 'Incêndio ou explosão'],
            ['codigo_esocial' => '01.05.005', 'grupo' => 'Acidente',   'nome' => 'Arranjo físico inadequado'],
            ['codigo_esocial' => '01.05.006', 'grupo' => 'Acidente',   'nome' => 'Queda de mesmo nível'],
            ['codigo_esocial' => '01.05.007', 'grupo' => 'Acidente',   'nome' => 'Queda de nível'],
        ];

        foreach ($tipos as $tipo) {
            RiscoTipo::updateOrCreate(
                ['codigo_esocial' => $tipo['codigo_esocial']],
                $tipo
            );
        }
    }
}
