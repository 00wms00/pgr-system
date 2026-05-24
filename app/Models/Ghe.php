<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ghe extends Model
{
    use HasFactory;

    protected $fillable = ['setor_id', 'codigo', 'nome', 'descricao_atividades', 'ativo'];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function riscosInventario(): HasMany
    {
        return $this->hasMany(RiscoInventario::class);
    }
}
