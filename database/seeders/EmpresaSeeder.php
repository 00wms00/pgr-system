<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        // Empresa de teste
        $empresa = Empresa::updateOrCreate(
            ['cnpj' => '00.000.000/0001-00'],
            [
                'razao_social'  => 'Empresa Teste Ltda',
                'nome_fantasia' => 'Empresa Teste',
                'cnpj'          => '00.000.000/0001-00',
                'endereco'      => 'Rua Exemplo, 100',
                'ativo'         => true,
            ]
        );

        // Admin do sistema (sem empresa — gerencia tudo)
        User::updateOrCreate(
            ['email' => 'admin@pgr.test'],
            [
                'name'       => 'Admin Sistema',
                'email'      => 'admin@pgr.test',
                'password'   => Hash::make('password'),
                'role'       => UserRole::Admin,
                'empresa_id' => $empresa->id,
            ]
        );

        // Gestor vinculado à empresa teste
        User::updateOrCreate(
            ['email' => 'gestor@pgr.test'],
            [
                'name'       => 'Gestor Teste',
                'email'      => 'gestor@pgr.test',
                'password'   => Hash::make('password'),
                'role'       => UserRole::Gestor,
                'empresa_id' => $empresa->id,
            ]
        );

        // Usuário somente leitura
        User::updateOrCreate(
            ['email' => 'usuario@pgr.test'],
            [
                'name'       => 'Usuário Teste',
                'email'      => 'usuario@pgr.test',
                'password'   => Hash::make('password'),
                'role'       => UserRole::Usuario,
                'empresa_id' => $empresa->id,
            ]
        );
    }
}
