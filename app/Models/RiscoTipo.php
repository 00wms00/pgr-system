<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiscoTipo extends Model
{
    public $timestamps = false;

    protected $table = 'riscos_tipos';

    protected $fillable = [
        'codigo',
        'nome',
        'categoria',
        'descricao',
    ];

    public function riscosInventario(): HasMany
    {
        return $this->hasMany(RiscoInventario::class, 'risco_tipo_id');
    }
}
