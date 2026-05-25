<?php

namespace App\Policies\Admin;

use App\Models\User;

class UsuarioPolicy
{
    /** Somente Admin pode gerenciar usuários */
    private function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewAny(User $user): bool  { return $this->isAdmin($user); }
    public function view(User $user, User $modelo): bool { return $this->isAdmin($user); }
    public function create(User $user): bool   { return $this->isAdmin($user); }
    public function update(User $user, User $modelo): bool { return $this->isAdmin($user); }
    public function delete(User $user, User $modelo): bool
    {
        return $this->isAdmin($user) && $user->id !== $modelo->id;
    }
}
