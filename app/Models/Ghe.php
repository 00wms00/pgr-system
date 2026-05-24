<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ghe extends Model
{
    protected $table = 'ghes';

    protected $fillable = ['setor_id', 'codigo', 'nome', 'descricao_atividades', 'ativo'];

    protected $casts = ['ativo' => 'boolean'];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function riscos(): HasMany
    {
        return $this->hasMany(RiscoInventario::class);
    }
}
