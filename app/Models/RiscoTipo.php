<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiscoTipo extends Model
{
    protected $table = 'riscos_tipos';

    protected $fillable = [
        'codigo_esocial',
        'nome',
        'grupo',
    ];

    public function riscosInventario(): HasMany
    {
        return $this->hasMany(RiscoInventario::class, 'risco_tipo_id');
    }

    public function agentesQuantitativos(): HasMany
    {
        return $this->hasMany(AgenteQuantitativo::class, 'risco_tipo_id')
            ->where('ativo', true)
            ->orderBy('nome');
    }
}
