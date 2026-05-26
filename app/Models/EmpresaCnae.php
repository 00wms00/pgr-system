<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaCnae extends Model
{
    protected $table = 'empresa_cnaes';

    protected $fillable = ['empresa_id', 'codigo', 'descricao'];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
