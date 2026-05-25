<?php
// Rodar com: ./vendor/bin/sail artisan tinker --execute="require 'debug-gate.php';"
// Apagar depois!

use App\Models\AvaliacaoRisco;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

$user = User::find(1);
Auth::login($user);

foreach ([4, 5] as $id) {
    $av = AvaliacaoRisco::find($id);
    $av->loadMissing('riscoInventario.ghe.setor.unidade');

    $unidade = optional(optional(optional($av->riscoInventario)->ghe)->setor)->unidade;

    $resultado = Gate::inspect('view', $av);

    echo "\n=== Avaliacao #{$id} ===\n";
    echo "user->empresa_id    : {$user->empresa_id}\n";
    echo "unidade->empresa_id : {$unidade?->empresa_id}\n";
    echo "policy resultado    : " . ($resultado->allowed() ? 'PERMITIDO' : 'NEGADO') . "\n";
    echo "mensagem            : " . ($resultado->message() ?: '(sem mensagem)') . "\n";
}
