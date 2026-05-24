<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $empresaA = Empresa::updateOrCreate(
            ['cnpj' => '11.111.111/0001-11'],
            ['razao_social' => 'Metalúrgica Brasil Ltda', 'nome_fantasia' => 'MetalBrasil', 'ativo' => true]
        );

        User::updateOrCreate(
            ['email' => 'admin@pgr.test'],
            ['name' => 'Admin Geral', 'password' => Hash::make('password'),
             'role' => 'admin', 'empresa_id' => $empresaA->id]
        );

        User::updateOrCreate(
            ['email' => 'gestor@pgr.test'],
            ['name' => 'Carlos Gestor', 'password' => Hash::make('password'),
             'role' => 'gestor', 'empresa_id' => $empresaA->id]
        );
    }
}