<?php

namespace App\Policies;

use App\Models\Setor;
use App\Models\User;

class SetorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Setor $setor): bool
    {
        $setor->loadMissing('unidade');

        return $setor->unidade !== null
            && $user->empresa_id === $setor->unidade->empresa_id;
    }

    public function create(User $user): bool
    {
        return $user->canWrite();
    }

    public function update(User $user, Setor $setor): bool
    {
        $setor->loadMissing('unidade');

        return $user->canWrite()
            && $setor->unidade !== null
            && $user->empresa_id === $setor->unidade->empresa_id;
    }

    public function delete(User $user, Setor $setor): bool
    {
        $setor->loadMissing('unidade');

        return $user->canWrite()
            && $setor->unidade !== null
            && $user->empresa_id === $setor->unidade->empresa_id;
    }
}
