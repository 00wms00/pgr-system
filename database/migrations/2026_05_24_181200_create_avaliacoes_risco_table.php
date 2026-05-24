<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('avaliacoes_risco', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risco_inventario_id')->constrained('riscos_inventario')->cascadeOnDelete();
            $table->date('data_avaliacao');
            $table->unsignedTinyInteger('probabilidade');
            $table->unsignedTinyInteger('severidade');
            $table->unsignedTinyInteger('nivel_risco');
            $table->string('classificacao', 20);
            $table->string('metodologia')->nullable();
            $table->text('justificativa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_risco');
    }
};
