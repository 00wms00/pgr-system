<?php

namespace App\Policies;

use App\Models\RiscoInventario;
use App\Models\User;

class RiscoInventarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RiscoInventario $risco): bool
    {
        // RiscoInventario → GHE → Setor → Unidade → empresa_id
        return $user->empresa_id === $risco->ghe->setor->unidade->empresa_id;
    }

    public function create(User $user): bool
    {
        return $user->canWrite();
    }

    public function update(User $user, RiscoInventario $risco): bool
    {
        return $user->canWrite()
            && $user->empresa_id === $risco->ghe->setor->unidade->empresa_id;
    }

    public function delete(User $user, RiscoInventario $risco): bool
    {
        return $user->canWrite()
            && $user->empresa_id === $risco->ghe->setor->unidade->empresa_id;
    }
}
