<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidade extends Model
{
    use HasFactory, BelongsToEmpresa;

    protected $table = 'unidades';

    protected $fillable = ['empresa_id', 'codigo', 'nome', 'endereco'];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function setores(): HasMany
    {
        return $this->hasMany(Setor::class);
    }
}
