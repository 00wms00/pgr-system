<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacoes_risco', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risco_inventario_id')->constrained('riscos_inventario')->cascadeOnDelete();
            $table->unsignedTinyInteger('probabilidade'); // 1-5
            $table->unsignedTinyInteger('severidade');    // 1-5
            $table->unsignedTinyInteger('nivel_risco');   // calculado: prob * sev
            $table->date('data_avaliacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_risco');
    }
};
