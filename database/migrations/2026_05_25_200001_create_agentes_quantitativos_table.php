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
            $table->foreignId('risco_tipo_id')->constrained('riscos_tipos')->cascadeOnDelete();
            $table->string('nome');
            $table->string('unidade_medida');
            $table->string('campo_label');
            $table->decimal('nivel_acao', 8, 2)->nullable();
            $table->decimal('limite_tolerancia', 8, 2)->nullable();
            $table->decimal('limite_rgi', 8, 2)->nullable();
            $table->string('norma_referencia');
            $table->string('input_step')->default('0.1');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agentes_quantitativos');
    }
};
