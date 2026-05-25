<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riscos_inventario', function (Blueprint $table) {
            $table->foreignId('agente_quantitativo_id')
                  ->nullable()
                  ->after('risco_tipo_id')
                  ->constrained('agentes_quantitativos')->nullOnDelete();
            $table->decimal('valor_medido', 8, 2)->nullable()->after('agente_quantitativo_id');
            $table->unsignedTinyInteger('probabilidade_calculada')->nullable()->after('valor_medido');
            $table->unsignedTinyInteger('severidade_calculada')->nullable()->after('probabilidade_calculada');
            $table->enum('classificacao_calculada', ['baixo','moderado','alto','critico'])->nullable()->after('severidade_calculada');
        });
    }

    public function down(): void
    {
        Schema::table('riscos_inventario', function (Blueprint $table) {
            $table->dropForeign(['agente_quantitativo_id']);
            $table->dropColumn(['agente_quantitativo_id','valor_medido','probabilidade_calculada','severidade_calculada','classificacao_calculada']);
        });
    }
};
