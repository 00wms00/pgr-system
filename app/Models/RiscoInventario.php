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
        'agente',
        'fonte_geradora',
        'possiveis_lesoes',
        'danos_saude',
        'medidas_existentes',
        'observacoes',
    ];

    public function ghe(): BelongsTo
    {
        return $this->belongsTo(Ghe::class);
    }

    public function riscoTipo(): BelongsTo
    {
        return $this->belongsTo(RiscoTipo::class, 'risco_tipo_id');
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(AvaliacaoRisco::class, 'risco_inventario_id')->latest('data_avaliacao');
    }

    public function avaliacaoAtual(): HasMany
    {
        return $this->hasMany(AvaliacaoRisco::class, 'risco_inventario_id')->latest('data_avaliacao')->limit(1);
    }
}
