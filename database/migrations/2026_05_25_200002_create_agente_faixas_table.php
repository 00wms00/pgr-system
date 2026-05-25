<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agente_faixas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agente_quantitativo_id')
                  ->constrained('agentes_quantitativos')
                  ->cascadeOnDelete();
            $table->decimal('valor_min', 8, 2);
            $table->decimal('valor_max', 8, 2)->nullable();
            $table->unsignedTinyInteger('probabilidade');
            $table->unsignedTinyInteger('severidade');
            $table->enum('classificacao', ['baixo', 'moderado', 'alto', 'critico']);
            $table->boolean('gatilho_plano_acao')->default(false);
            $table->text('descricao_gatilho')->nullable();
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agente_faixas');
    }
};
