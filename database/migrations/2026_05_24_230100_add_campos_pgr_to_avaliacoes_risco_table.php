<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avaliacoes_risco', function (Blueprint $table) {
            $table->string('metodologia')->default('Matriz 5x5 (P x S)')->after('nivel_risco');
            $table->string('classificacao', 30)->nullable()->after('metodologia'); // baixo/moderado/alto/critico
            $table->text('justificativa')->nullable()->after('classificacao');
            $table->foreignId('avaliado_por')->nullable()->constrained('users')->nullOnDelete()->after('justificativa');
        });
    }

    public function down(): void
    {
        Schema::table('avaliacoes_risco', function (Blueprint $table) {
            $table->dropConstrainedForeignId('avaliado_por');
            $table->dropColumn(['metodologia', 'classificacao', 'justificativa']);
        });
    }
};
