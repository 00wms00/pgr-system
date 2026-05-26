<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ghe extends Model
{
    use HasFactory;

    protected $table = 'ghes';

    protected $fillable = [
        'setor_id',
        'codigo',
        'nome',
        'qtd_funcionarios',
        'descricao_atividades',
        'descricao_ambiente',
        'ativo',
    ];

    // -----------------------------------------------------------------------
    // Relacionamentos
    // -----------------------------------------------------------------------

    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }

    public function cbos(): HasMany
    {
        return $this->hasMany(GheCbo::class)->orderBy('codigo');
    }

    public function cargos(): HasMany
    {
        return $this->hasMany(GheCargo::class)->orderBy('cargo');
    }

    public function riscosInventario(): HasMany
    {
        return $this->hasMany(RiscoInventario::class);
    }
}
