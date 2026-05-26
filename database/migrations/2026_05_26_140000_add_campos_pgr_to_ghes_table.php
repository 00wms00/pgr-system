<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Novos campos na tabela ghes
        Schema::table('ghes', function (Blueprint $table) {
            $table->unsignedSmallInteger('qtd_funcionarios')->nullable()->after('nome');
            $table->text('descricao_ambiente')->nullable()->after('descricao_atividades');
        });

        // Tabela auxiliar para CBOs
        Schema::create('ghe_cbos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ghe_id')->constrained('ghes')->cascadeOnDelete();
            $table->string('codigo', 10);          // ex: 3132-10
            $table->string('descricao', 200);
            $table->timestamps();
        });

        // Tabela auxiliar para Cargos/Funções
        Schema::create('ghe_cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ghe_id')->constrained('ghes')->cascadeOnDelete();
            $table->string('cargo', 150);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ghe_cargos');
        Schema::dropIfExists('ghe_cbos');
        Schema::table('ghes', function (Blueprint $table) {
            $table->dropColumn(['qtd_funcionarios', 'descricao_ambiente']);
        });
    }
};
