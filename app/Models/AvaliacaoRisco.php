<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvaliacaoRisco extends Model
{
    protected $table = 'avaliacoes_risco';

    protected $fillable = [
        'risco_inventario_id',
        'probabilidade',
        'severidade',
        'nivel_risco',
        'data_avaliacao',
        'metodologia',
        'classificacao',
        'justificativa',
        'avaliado_por',
    ];

    protected $casts = [
        'data_avaliacao' => 'date',
        'probabilidade'  => 'integer',
        'severidade'     => 'integer',
        'nivel_risco'    => 'integer',
    ];

    // Classificacao calculada a partir do nivel_risco (P x S)
    public static function classificar(int $nivel): string
    {
        return match (true) {
            $nivel <= 4  => 'baixo',
            $nivel <= 9  => 'moderado',
            $nivel <= 16 => 'alto',
            default      => 'critico',
        };
    }

    public function riscoInventario(): BelongsTo
    {
        return $this->belongsTo(RiscoInventario::class);
    }

    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'avaliado_por');
    }

    public function planosAcao(): HasMany
    {
        return $this->hasMany(PlanoAcao::class);
    }
}
