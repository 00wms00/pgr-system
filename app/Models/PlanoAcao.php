<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanoAcao extends Model
{
    protected $table = 'planos_acao';

    protected $fillable = [
        'avaliacao_risco_id',
        'tipo_controle',
        'descricao',
        'responsavel',
        'prazo',
        'status',
    ];

    protected $casts = [
        'prazo' => 'date',
    ];

    const TIPOS_CONTROLE = [
        'eliminacao'   => 'Eliminação',
        'substituicao' => 'Substituição',
        'engenharia'   => 'Controle de Engenharia',
        'administrativo' => 'Controle Administrativo',
        'epi'          => 'EPI',
    ];

    const STATUS = [
        'pendente'      => 'Pendente',
        'em_andamento'  => 'Em andamento',
        'concluido'     => 'Concluído',
    ];

    public function avaliacaoRisco(): BelongsTo
    {
        return $this->belongsTo(AvaliacaoRisco::class);
    }

    public function epis(): BelongsToMany
    {
        return $this->belongsToMany(EpiCa::class, 'epi_plano_acao', 'plano_acao_id', 'epi_ca_id');
    }
}
