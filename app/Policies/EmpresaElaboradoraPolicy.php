<?php

namespace App\Policies;

use App\Models\EmpresaElaboradora;
use App\Models\User;

class EmpresaElaboradoraPolicy
{
    /**
     * Apenas admin e gestor podem gerenciar empresas elaboradoras.
     * Usuário comum só pode visualizar.
     */

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, EmpresaElaboradora $empresaElaboradora): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'gestor']);
    }

    public function update(User $user, EmpresaElaboradora $empresaElaboradora): bool
    {
        return in_array($user->role, ['admin', 'gestor']);
    }

    public function delete(User $user, EmpresaElaboradora $empresaElaboradora): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, EmpresaElaboradora $empresaElaboradora): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, EmpresaElaboradora $empresaElaboradora): bool
    {
        return $user->role === 'admin';
    }
}
