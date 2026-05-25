<?php

namespace App\Policies;

use App\Models\AvaliacaoRisco;
use App\Models\RiscoInventario;
use App\Models\User;

class AvaliacaoRiscoPolicy
{
    /**
     * Sobe a hierarquia: AvaliacaoRisco → RiscoInventario → GHE → Setor → Unidade → empresa_id
     * Usa loadMissing para evitar N+1 e trata cada elo nulo com segurança.
     */
    private function pertenceAEmpresa(User $user, AvaliacaoRisco $avaliacao): bool
    {
        $avaliacao->loadMissing('riscoInventario.ghe.setor.unidade');

        $unidade = optional(optional(optional($avaliacao->riscoInventario)->ghe)->setor)->unidade;

        return $unidade !== null && $user->empresa_id === $unidade->empresa_id;
    }

    private function riscoParteEmpresa(User $user, RiscoInventario $risco): bool
    {
        $risco->loadMissing('ghe.setor.unidade');

        $unidade = optional(optional($risco->ghe)->setor)->unidade;

        return $unidade !== null && $user->empresa_id === $unidade->empresa_id;
    }

    /** Qualquer usuário autenticado pode listar avaliações do próprio risco */
    public function viewAny(User $user, RiscoInventario $risco): bool
    {
        return $this->riscoParteEmpresa($user, $risco);
    }

    public function view(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $this->pertenceAEmpresa($user, $avaliacao);
    }

    public function create(User $user, RiscoInventario $risco): bool
    {
        return $user->canWrite() && $this->riscoParteEmpresa($user, $risco);
    }

    public function update(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->canWrite() && $this->pertenceAEmpresa($user, $avaliacao);
    }

    public function delete(User $user, AvaliacaoRisco $avaliacao): bool
    {
        return $user->canWrite() && $this->pertenceAEmpresa($user, $avaliacao);
    }
}
