<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'endereco',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
