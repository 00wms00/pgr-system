<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgenteQuantitativo extends Model
{
    protected $fillable = [
        'risco_tipo_id', 'nome', 'unidade_medida', 'campo_label',
        'nivel_acao', 'limite_tolerancia', 'limite_rgi',
        'norma_referencia', 'input_step', 'ativo',
    ];

    protected $casts = [
        'nivel_acao'        => 'float',
        'limite_tolerancia' => 'float',
        'limite_rgi'        => 'float',
        'ativo'             => 'boolean',
    ];

    public function riscoTipo(): BelongsTo
    {
        return $this->belongsTo(RiscoTipo::class);
    }

    public function faixas(): HasMany
    {
        return $this->hasMany(AgenteFaixa::class)->orderBy('ordem');
    }

    /** Retorna a faixa que contém o valor informado */
    public function faixaParaValor(float $valor): ?AgenteFaixa
    {
        return $this->faixas
            ->first(function (AgenteFaixa $f) use ($valor) {
                $acimaDaMin = $valor >= $f->valor_min;
                $abaixoDoMax = is_null($f->valor_max) || $valor <= $f->valor_max;
                return $acimaDaMin && $abaixoDoMax;
            });
    }
}
