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
        Schema::create('riscos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ghe_id')->constrained('ghes')->cascadeOnDelete();
            $table->foreignId('risco_tipo_id')->constrained('riscos_tipos');
            $table->string('fonte_geradora');
            $table->string('via_absorcao')->nullable();
            $table->string('tecnica_utilizada')->nullable(); // medição, qualitativo, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riscos_inventario');
    }
};
