<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riscos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ghe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('risco_tipo_id')->constrained('riscos_tipos')->restrictOnDelete();
            $table->string('agente');
            $table->text('fonte_geradora')->nullable();
            $table->text('possiveis_lesoes')->nullable();
            $table->text('danos_saude')->nullable();
            $table->text('medidas_existentes')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riscos_inventario');
    }
};
