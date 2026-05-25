<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas_elaboradoras', function (Blueprint $table) {
            $table->id();

            // ── Identificação da empresa ────────────────────────────────────
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj', 18)->unique();
            $table->string('cnae_principal', 20)->nullable();
            $table->string('cnae_descricao')->nullable();

            // ── Endereço ────────────────────────────────────────────────────
            $table->string('logradouro')->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->char('uf', 2)->nullable();
            $table->string('cep', 9)->nullable();

            // ── Contato ─────────────────────────────────────────────────────
            $table->string('telefone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();

            // ── Responsável técnico ─────────────────────────────────────────
            // Baseado nos modelos reais: K3M Engenharia (CREA/CE) e SESI (CREA/PR)
            $table->string('responsavel_nome')->nullable();
            $table->string('responsavel_formacao')->nullable();
            $table->string('responsavel_especializacao')->nullable();
            $table->string('responsavel_registro_tipo', 20)->nullable();  // CREA, CRBio, CRM
            $table->string('responsavel_registro_numero', 50)->nullable();
            $table->string('responsavel_rnp', 30)->nullable();
            $table->string('responsavel_cpf', 14)->nullable();
            $table->string('responsavel_nit', 20)->nullable();
            $table->string('responsavel_cargo')->nullable();  // Engenheiro / Técnico de Segurança

            // ── Status ──────────────────────────────────────────────────────
            $table->boolean('ativo')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas_elaboradoras');
    }
};
