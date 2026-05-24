<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role?->value, $roles)) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
