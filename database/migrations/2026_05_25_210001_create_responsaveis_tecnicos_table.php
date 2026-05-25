<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responsaveis_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_elaboradora_id')
                  ->constrained('empresa_elaboradora')
                  ->cascadeOnDelete();
            $table->string('nome');
            $table->string('formacao');          // Ex: Engenheiro de Produção
            $table->string('especializacao')->nullable(); // Ex: Engenharia de Segurança do Trabalho
            // Registro profissional
            $table->string('tipo_registro', 10); // CREA | CRQ | RNP | MTE | CFQ | CFTA
            $table->string('numero_registro', 30);
            $table->string('uf_registro', 2)->nullable(); // Ex: CE (para CREA/CE)
            // ART / RRT
            $table->string('numero_art_rrt')->nullable();
            $table->date('data_art_rrt')->nullable();
            // Contato
            $table->string('email')->nullable();
            $table->string('telefone', 20)->nullable();
            // Controle
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsaveis_tecnicos');
    }
};
