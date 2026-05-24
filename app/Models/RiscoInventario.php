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
        'via_absorcao',
        'tecnica_utilizada',
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
        return $this->belongsTo(RiscoTipo::class);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(AvaliacaoRisco::class);
    }

    public function ultimaAvaliacao()
    {
        return $this->avaliacoes()->latest()->first();
    }
}
