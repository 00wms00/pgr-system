<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'observacao',
    ];

    protected $casts = [
        'prazo' => 'date',
    ];

    const TIPOS_CONTROLE = [
        'eliminacao'     => '1. Eliminação',
        'substituicao'   => '2. Substituição',
        'engenharia'     => '3. Controle de Engenharia',
        'administrativo' => '4. Controle Administrativo',
        'epi'            => '5. EPI',
    ];

    const STATUS = [
        'pendente'     => 'Pendente',
        'em_andamento' => 'Em andamento',
        'concluido'    => 'Concluído',
    ];

    // Cores para inline styles (evita purge do Tailwind)
    const STATUS_CORES = [
        'pendente'     => ['bg' => '#e5e7eb', 'text' => '#374151'],
        'em_andamento' => ['bg' => '#bfdbfe', 'text' => '#1e3a8a'],
        'concluido'    => ['bg' => '#bbf7d0', 'text' => '#14532d'],
    ];

    public function avaliacaoRisco(): BelongsTo
    {
        return $this->belongsTo(AvaliacaoRisco::class);
    }
}
