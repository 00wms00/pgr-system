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
        Schema::create('planos_acao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avaliacao_risco_id')->constrained('avaliacoes_risco')->cascadeOnDelete();
            $table->string('tipo_controle'); // Eliminação, Substituição, Eng., Adm., EPI
            $table->text('descricao');
            $table->string('responsavel');
            $table->date('prazo');
            $table->string('status')->default('pendente'); // pendente, em_andamento, concluido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos_acao');
    }
};
