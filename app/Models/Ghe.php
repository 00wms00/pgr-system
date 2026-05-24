<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ghe extends Model
{
    use HasFactory, BelongsToEmpresa;

    protected $fillable = ['empresa_id', 'setor_id', 'codigo', 'nome', 'descricao'];

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function riscosInventario(): HasMany
    {
        return $this->hasMany(RiscoInventario::class);
    }
}
