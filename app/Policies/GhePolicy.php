<?php

namespace App\Policies;

use App\Models\Ghe;
use App\Models\User;

class GhePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ghe $ghe): bool
    {
        // GHE → Setor → Unidade → empresa_id
        return $user->empresa_id === $ghe->setor->unidade->empresa_id;
    }

    public function create(User $user): bool
    {
        return $user->canWrite();
    }

    public function update(User $user, Ghe $ghe): bool
    {
        return $user->canWrite()
            && $user->empresa_id === $ghe->setor->unidade->empresa_id;
    }

    public function delete(User $user, Ghe $ghe): bool
    {
        return $user->canWrite()
            && $user->empresa_id === $ghe->setor->unidade->empresa_id;
    }
}
