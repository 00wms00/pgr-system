<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiscoInventario extends Model
{
    protected $table = 'riscos_inventario';

    protected $fillable = [
        'ghe_id',
        'risco_tipo_id',
        'agente_quantitativo_id',
        'agente',
        'fonte_geradora',
        'via_absorcao',
        'tecnica_utilizada',
        'possiveis_lesoes',
        'danos_saude',
        'medidas_existentes',
        'observacoes',
        'valor_medido',
        'probabilidade_calculada',
        'severidade_calculada',
        'classificacao_calculada',
    ];

    protected $casts = [
        'valor_medido'            => 'decimal:4',
        'probabilidade_calculada' => 'integer',
        'severidade_calculada'    => 'integer',
    ];

    public function ghe(): BelongsTo
    {
        return $this->belongsTo(Ghe::class);
    }

    public function riscoTipo(): BelongsTo
    {
        return $this->belongsTo(RiscoTipo::class);
    }

    public function agenteQuantitativo(): BelongsTo
    {
        return $this->belongsTo(AgenteQuantitativo::class);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(AvaliacaoRisco::class);
    }

    public function ultimaAvaliacao(): ?AvaliacaoRisco
    {
        return $this->avaliacoes()->latest('data_avaliacao')->first();
    }
}
