<?php

namespace App\Providers;

use App\Models\EmpresaElaboradora;
use App\Models\Ghe;
use App\Models\RiscoInventario;
use App\Models\Setor;
use App\Models\Unidade;
use App\Policies\EmpresaElaboradoraPolicy;
use App\Policies\GhePolicy;
use App\Policies\RiscoInventarioPolicy;
use App\Policies\SetorPolicy;
use App\Policies\UnidadePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(EmpresaElaboradora::class, EmpresaElaboradoraPolicy::class);
        Gate::policy(Unidade::class, UnidadePolicy::class);
        Gate::policy(Setor::class, SetorPolicy::class);
        Gate::policy(Ghe::class, GhePolicy::class);
        Gate::policy(RiscoInventario::class, RiscoInventarioPolicy::class);
    }
}
