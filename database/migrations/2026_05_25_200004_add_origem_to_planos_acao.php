<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planos_acao', function (Blueprint $table) {
            $table->enum('origem', ['manual', 'automatico'])
                  ->default('manual')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('planos_acao', function (Blueprint $table) {
            $table->dropColumn('origem');
        });
    }
};
