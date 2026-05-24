<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riscos_inventario', function (Blueprint $table) {
            // Colunas do formulário PGR que não existiam na migration original
            $table->string('agente')->nullable()->after('risco_tipo_id');
            $table->text('possiveis_lesoes')->nullable()->after('fonte_geradora');
            $table->text('danos_saude')->nullable()->after('possiveis_lesoes');
            $table->text('medidas_existentes')->nullable()->after('danos_saude');
            $table->text('observacoes')->nullable()->after('medidas_existentes');
        });
    }

    public function down(): void
    {
        Schema::table('riscos_inventario', function (Blueprint $table) {
            $table->dropColumn(['agente', 'possiveis_lesoes', 'danos_saude', 'medidas_existentes', 'observacoes']);
        });
    }
};
