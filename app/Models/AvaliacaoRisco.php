<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvaliacaoRisco extends Model
{
    protected $table = 'avaliacoes_risco';

    protected $fillable = [
        'risco_inventario_id',
        'data_avaliacao',
        'probabilidade',
        'severidade',
        'nivel_risco',
        'classificacao',
        'metodologia',
        'justificativa',
    ];

    protected $casts = [
        'data_avaliacao' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $avaliacao) {
            $avaliacao->nivel_risco = (int) $avaliacao->probabilidade * (int) $avaliacao->severidade;
            $avaliacao->classificacao = match (true) {
                $avaliacao->nivel_risco <= 4 => 'baixo',
                $avaliacao->nivel_risco <= 12 => 'moderado',
                default => 'alto',
            };
        });
    }

    public function riscoInventario(): BelongsTo
    {
        return $this->belongsTo(RiscoInventario::class, 'risco_inventario_id');
    }
}
