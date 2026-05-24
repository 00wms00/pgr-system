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
        Schema::create('epi_plano_acao', function (Blueprint $table) {
            $table->foreignId('epi_ca_id')->constrained('epis_ca')->cascadeOnDelete();
            $table->foreignId('plano_acao_id')->constrained('planos_acao')->cascadeOnDelete();
            $table->primary(['epi_ca_id', 'plano_acao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epi_plano_acao');
    }
};
