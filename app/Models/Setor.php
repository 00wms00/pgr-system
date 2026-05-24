<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $table = 'setores';

    protected $fillable = ['unidade_id', 'nome', 'descricao'];

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function ghes(): HasMany
    {
        return $this->hasMany(Ghe::class);
    }
}
