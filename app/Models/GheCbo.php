<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GheCbo extends Model
{
    protected $table = 'ghe_cbos';

    protected $fillable = ['ghe_id', 'codigo', 'descricao'];

    public function ghe(): BelongsTo
    {
        return $this->belongsTo(Ghe::class);
    }
}
