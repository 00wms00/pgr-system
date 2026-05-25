<?php

namespace App\Policies;

use App\Models\Unidade;
use App\Models\User;

class UnidadePolicy
{
    // Todos os usuários autenticados da empresa podem visualizar
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Unidade $unidade): bool
    {
        return $user->empresa_id === $unidade->empresa_id;
    }

    // Somente admin e gestor podem criar/editar/deletar
    public function create(User $user): bool
    {
        return $user->canWrite();
    }

    public function update(User $user, Unidade $unidade): bool
    {
        return $user->canWrite() && $user->empresa_id === $unidade->empresa_id;
    }

    public function delete(User $user, Unidade $unidade): bool
    {
        return $user->canWrite() && $user->empresa_id === $unidade->empresa_id;
    }
}
