<?php

namespace App\Providers;

use App\Models\EmpresaElaboradora;
use App\Models\Unidade;
use App\Models\Setor;
use App\Policies\EmpresaElaboradoraPolicy;
use App\Policies\UnidadePolicy;
use App\Policies\SetorPolicy;
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
    }
}
