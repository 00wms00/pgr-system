<?php

namespace App\Policies;

use App\Models\AvaliacaoRisco;
use App\Models\RiscoInventario;
use App\Models\User;

class AvaliacaoRiscoPolicy
{
    /** Qualquer usuário autenticado pode listar avaliações do próprio risco */
    public function viewAny(User $user, RiscoInventario $risco): bool
    {
        return $user->empresa_id === $risco->ghe->setor->unidade->empresa_id;
    }

    public function view(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->empresa_id ===
            $avaliacao->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function create(User $user, RiscoInventario $risco): bool
    {
        return $user->canWrite()
            && $user->empresa_id === $risco->ghe->setor->unidade->empresa_id;
    }

    public function update(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->canWrite()
            && $user->empresa_id ===
                $avaliacao->riscoInventario->ghe->setor->unidade->empresa_id;
    }

    public function delete(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->canWrite()
            && $user->empresa_id ===
                $avaliacao->riscoInventario->ghe->setor->unidade->empresa_id;
    }
}
