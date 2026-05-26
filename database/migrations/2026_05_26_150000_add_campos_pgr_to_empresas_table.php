<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Novos campos na tabela empresas
        Schema::table('empresas', function (Blueprint $table) {
            // CNAE
            $table->string('cnae_principal_codigo', 10)->nullable()->after('cnpj');
            $table->string('cnae_principal_descricao', 300)->nullable()->after('cnae_principal_codigo');
            // Grau de Risco NR-4 (1, 2, 3 ou 4)
            $table->tinyInteger('grau_risco')->unsigned()->nullable()->after('cnae_principal_descricao');
            // Trabalhadores
            $table->unsignedSmallInteger('total_trabalhadores')->nullable()->after('grau_risco');
            $table->unsignedSmallInteger('trabalhadores_masculino')->nullable()->after('total_trabalhadores');
            $table->unsignedSmallInteger('trabalhadores_feminino')->nullable()->after('trabalhadores_masculino');
            // Porte
            $table->string('porte', 20)->nullable()->after('trabalhadores_feminino');
            // Inscrições
            $table->string('inscricao_estadual', 30)->nullable()->after('endereco');
            $table->string('inscricao_municipal', 30)->nullable()->after('inscricao_estadual');
            // Representante legal
            $table->string('representante_nome', 150)->nullable()->after('inscricao_municipal');
            $table->string('representante_cargo', 100)->nullable()->after('representante_nome');
            // Contato técnico interno
            $table->string('contato_tecnico_nome', 150)->nullable()->after('representante_cargo');
            $table->string('contato_tecnico_cargo', 100)->nullable()->after('contato_tecnico_nome');
        });

        // Tabela para CNAEs secundários
        Schema::create('empresa_cnaes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('codigo', 10);
            $table->string('descricao', 300);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa_cnaes');
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn([
                'cnae_principal_codigo', 'cnae_principal_descricao',
                'grau_risco',
                'total_trabalhadores', 'trabalhadores_masculino', 'trabalhadores_feminino',
                'porte',
                'inscricao_estadual', 'inscricao_municipal',
                'representante_nome', 'representante_cargo',
                'contato_tecnico_nome', 'contato_tecnico_cargo',
            ]);
        });
    }
};
