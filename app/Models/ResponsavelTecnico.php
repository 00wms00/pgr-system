<?php

namespace App\Models;

use App\Enums\TipoRegistro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponsavelTecnico extends Model
{
    protected $fillable = [
        'empresa_elaboradora_id',
        'nome',
        'formacao',
        'especializacao',
        'tipo_registro',
        'numero_registro',
        'uf_registro',
        'numero_art_rrt',
        'data_art_rrt',
        'email',
        'telefone',
        'ativo',
    ];

    protected $casts = [
        'tipo_registro' => TipoRegistro::class,
        'data_art_rrt'  => 'date',
        'ativo'         => 'boolean',
    ];

    // ─── Relacionamentos ────────────────────────────────────────────────────────

    public function empresaElaboradora(): BelongsTo
    {
        return $this->belongsTo(EmpresaElaboradora::class);
    }

    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Retorna o número de registro formatado com o tipo e UF.
     * Ex: CREA/CE: 335731
     */
    public function registroFormatado(): string
    {
        $registro = $this->tipo_registro->value;
        if ($this->uf_registro) {
            $registro .= '/' . $this->uf_registro;
        }
        return $registro . ': ' . $this->numero_registro;
    }
}
