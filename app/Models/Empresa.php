<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        // CNAE
        'cnae_principal_codigo',
        'cnae_principal_descricao',
        'grau_risco',
        // Trabalhadores
        'total_trabalhadores',
        'trabalhadores_masculino',
        'trabalhadores_feminino',
        // Porte
        'porte',
        // Endereço e inscrições
        'endereco',
        'inscricao_estadual',
        'inscricao_municipal',
        // Representante legal
        'representante_nome',
        'representante_cargo',
        // Contato técnico interno
        'contato_tecnico_nome',
        'contato_tecnico_cargo',
        'ativo',
    ];

    protected $casts = [
        'ativo'                  => 'boolean',
        'grau_risco'             => 'integer',
        'total_trabalhadores'    => 'integer',
        'trabalhadores_masculino'=> 'integer',
        'trabalhadores_feminino' => 'integer',
    ];

    // -----------------------------------------------------------------------
    // Relacionamentos
    // -----------------------------------------------------------------------

    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function cnaesSecundarios(): HasMany
    {
        return $this->hasMany(EmpresaCnae::class)->orderBy('codigo');
    }

    // -----------------------------------------------------------------------
    // Accessors
    // -----------------------------------------------------------------------

    public function getNomeExibicaoAttribute(): string
    {
        return $this->nome_fantasia ?: $this->razao_social;
    }

    public function getGrauRiscoLabelAttribute(): string
    {
        return match ($this->grau_risco) {
            1 => 'Grau 1',
            2 => 'Grau 2',
            3 => 'Grau 3',
            4 => 'Grau 4',
            default => '—',
        };
    }

    public function getPorteLabelAttribute(): string
    {
        return match ($this->porte) {
            'MEI'    => 'MEI — Microempreendedor Individual',
            'ME'     => 'ME — Microempresa',
            'EPP'    => 'EPP — Empresa de Pequeno Porte',
            'medio'  => 'Médio Porte',
            'grande' => 'Grande Porte',
            default  => '—',
        };
    }
}
