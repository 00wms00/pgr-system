<?php

namespace App\Models\Concerns;

trait BelongsToEmpresa
{
    protected static function bootBelongsToEmpresa(): void
    {
        // Filtra automaticamente por empresa do usuário logado
        static::addGlobalScope('empresa', function ($query) {
            if (auth()->check() && auth()->user()->empresa_id) {
                $query->where(
                    (new static)->qualifyColumn('empresa_id'),
                    auth()->user()->empresa_id
                );
            }
        });

        // Preenche empresa_id automaticamente ao criar
        static::creating(function ($model) {
            if (empty($model->empresa_id) && auth()->check()) {
                $model->empresa_id = auth()->user()->empresa_id;
            }
        });
    }
}
