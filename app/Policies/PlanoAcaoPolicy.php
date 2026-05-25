<?php

namespace App\Policies;

use App\Models\AvaliacaoRisco;
use App\Models\PlanoAcao;
use App\Models\User;

class PlanoAcaoPolicy
{
    /** Qualquer usuário da empresa pode ver planos da avaliação */
    public function viewAny(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->empresa_id ===
            $avaliacao->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function view(User $user, PlanoAcao $plano): bool
    {
        return $user->empresa_id ===
            $plano->avaliacaoRisco->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function create(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->canWrite()
            && $user->empresa_id ===
                $avaliacao->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function update(User $user, PlanoAcao $plano): bool
    {
        return $user->canWrite()
            && $user->empresa_id ===
                $plano->avaliacaoRisco->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function delete(User $user, PlanoAcao $plano): bool
    {
        return $user->canWrite()
            && $user->empresa_id ===
                $plano->avaliacaoRisco->riscoInventario->ghe->setor->unidade->empresa_id;
    }
}
