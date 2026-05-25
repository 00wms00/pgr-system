<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgenteFaixa extends Model
{
    protected $fillable = [
        'agente_quantitativo_id',
        'valor_min', 'valor_max',
        'probabilidade', 'severidade', 'classificacao',
        'gatilho_plano_acao', 'descricao_gatilho', 'ordem',
    ];

    protected $casts = [
        'valor_min'          => 'float',
        'valor_max'          => 'float',
        'probabilidade'      => 'integer',
        'severidade'         => 'integer',
        'gatilho_plano_acao' => 'boolean',
    ];

    public function agente(): BelongsTo
    {
        return $this->belongsTo(AgenteQuantitativo::class, 'agente_quantitativo_id');
    }

    /** Produto Probabilidade × Severidade */
    public function getNivelRiscoAttribute(): int
    {
        return $this->probabilidade * $this->severidade;
    }

    /** Label legível da classificação */
    public function getClassificacaoLabelAttribute(): string
    {
        return match ($this->classificacao) {
            'baixo'    => 'Baixo',
            'moderado' => 'Moderado',
            'alto'     => 'Alto',
            'critico'  => 'Crítico',
            default    => ucfirst($this->classificacao),
        };
    }
}
