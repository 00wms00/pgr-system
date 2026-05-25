<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\EmpresaElaboradora;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpresaElaboradoraPolicy
{
    use HandlesAuthorization;

    /**
     * Empresa Elaboradora é configuração global do sistema.
     * Apenas administradores podem gerenciá-la.
     */
    private function isAdmin(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, EmpresaElaboradora $elaboradora): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, EmpresaElaboradora $elaboradora): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, EmpresaElaboradora $elaboradora): bool
    {
        return $this->isAdmin($user);
    }
}
