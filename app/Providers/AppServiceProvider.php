<?php

namespace App\Providers;

use App\Models\EmpresaElaboradora;
use App\Models\Unidade;
use App\Policies\EmpresaElaboradoraPolicy;
use App\Policies\UnidadePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Policies registradas explicitamente
        Gate::policy(EmpresaElaboradora::class, EmpresaElaboradoraPolicy::class);
        Gate::policy(Unidade::class, UnidadePolicy::class);
    }
}
