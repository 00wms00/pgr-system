<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riscos_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable()->unique();
            $table->string('nome');
            $table->string('categoria');
            $table->text('descricao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riscos_tipos');
    }
};
