<?php

namespace App\Models;

use App\Models\Concerns\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EpiCa extends Model
{
    use BelongsToEmpresa;

    protected $table = 'epis_ca';

    protected $fillable = [
        'empresa_id',
        'nome',
        'numero_ca',
        'fabricante',
        'validade_ca',
        'ativo',
    ];

    protected $casts = [
        'validade_ca' => 'date',
        'ativo'       => 'boolean',
    ];

    public function planosAcao(): BelongsToMany
    {
        return $this->belongsToMany(PlanoAcao::class, 'epi_plano_acao', 'epi_ca_id', 'plano_acao_id');
    }
}
