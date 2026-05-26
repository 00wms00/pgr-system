<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GheCargo extends Model
{
    protected $table = 'ghe_cargos';

    protected $fillable = ['ghe_id', 'cargo'];

    public function ghe(): BelongsTo
    {
        return $this->belongsTo(Ghe::class);
    }
}
