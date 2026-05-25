<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmpresaElaboradora extends Model
{
    protected $table = 'empresa_elaboradora';

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'cnae_codigo',
        'cnae_descricao',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'telefone',
        'email',
        'site',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // ─── Relacionamentos ────────────────────────────────────────────────────────

    public function responsaveis(): HasMany
    {
        return $this->hasMany(ResponsavelTecnico::class)->where('ativo', true);
    }

    public function todosResponsaveis(): HasMany
    {
        return $this->hasMany(ResponsavelTecnico::class);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Retorna o endereço formatado em uma linha.
     */
    public function enderecoFormatado(): string
    {
        $partes = [
            $this->logradouro . ', ' . $this->numero,
            $this->complemento,
            $this->bairro,
            $this->cidade . ' – ' . $this->uf,
            'CEP: ' . $this->cep,
        ];

        return implode(', ', array_filter($partes));
    }

    /**
     * Retorna o nome de exibição preferindo nome_fantasia.
     */
    public function nomeExibicao(): string
    {
        return $this->nome_fantasia ?? $this->razao_social;
    }
}
