<?php

namespace App\Policies\Admin;

use App\Models\Empresa;
use App\Models\User;

class EmpresaPolicy
{
    /** Somente Admin pode gerenciar empresas */
    private function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewAny(User $user): bool  { return $this->isAdmin($user); }
    public function view(User $user, Empresa $empresa): bool { return $this->isAdmin($user); }
    public function create(User $user): bool   { return $this->isAdmin($user); }
    public function update(User $user, Empresa $empresa): bool { return $this->isAdmin($user); }
    public function delete(User $user, Empresa $empresa): bool { return $this->isAdmin($user); }
}
