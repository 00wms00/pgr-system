<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agentes_quantitativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risco_tipo_id')->constrained()->cascadeOnDelete();
            $table->string('nome');                    // ex: Ruído Contínuo
            $table->string('unidade_medida');          // ex: dB(A)
            $table->string('campo_label');             // ex: Nível de Pressão Sonora
            $table->decimal('nivel_acao', 8, 2)->nullable();       // ex: 80.0
            $table->decimal('limite_tolerancia', 8, 2)->nullable(); // ex: 85.0
            $table->decimal('limite_rgi', 8, 2)->nullable();       // Risco Grave e Iminente ex: 115.0
            $table->string('norma_referencia');        // ex: NR-15 Anexo I
            $table->string('input_step')->default('0.1'); // step do input HTML
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agentes_quantitativos');
    }
};
