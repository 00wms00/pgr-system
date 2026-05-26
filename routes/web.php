<?php

use App\Http\Controllers\Admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\Admin\UsuarioController as AdminUsuarioController;
use App\Http\Controllers\AvaliacaoRiscoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaElaboradoraController;
use App\Http\Controllers\GheController;
use App\Http\Controllers\PlanoAcaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelatorioPgrController;
use App\Http\Controllers\RiscoInventarioController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Sprint 1
    Route::resource('empresas-elaboradoras', EmpresaElaboradoraController::class);

    // Sprint 2
    Route::resource('unidades', UnidadeController::class);

    // Sprint 3 — parâmetro forçado: Laravel pluraliza 'setores' → '{setore}' sem isso
    Route::resource('setores', SetorController::class)
        ->parameters(['setores' => 'setor']);

    // Sprint 4
    Route::resource('ghes', GheController::class);

    // API auxiliar: setores de uma unidade
    Route::get('/api/unidades/{unidade}/setores', function (\App\Models\Unidade $unidade) {
        abort_unless((int) auth()->user()->empresa_id === (int) $unidade->empresa_id, 403);
        return response()->json(
            $unidade->setores()->orderBy('nome')->get(['id', 'nome'])
        );
    })->name('api.unidades.setores');

    // Sprint 5
    Route::resource('riscos', RiscoInventarioController::class);

    // Sprint 6 — parâmetro forçado: Laravel trunca 'avaliacoes' → '{avaliaco}' por causa do acento
    Route::resource('riscos.avaliacoes', AvaliacaoRiscoController::class)
        ->shallow()
        ->parameters(['avaliacoes' => 'avaliacao']);

    // Sprint 7 — parâmetro forçado: mesmo problema com 'planos'
    Route::resource('avaliacoes.planos', PlanoAcaoController::class)
        ->shallow()
        ->parameters([
            'avaliacoes' => 'avaliacao',
            'planos'     => 'plano',
        ]);

    // Sprint 8
    Route::get('/relatorio/pgr', [RelatorioPgrController::class, 'index'])->name('relatorio.pgr');

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', AdminUsuarioController::class)->except(['show']);
        Route::resource('empresas', AdminEmpresaController::class)->except(['show']);
    });

    // Profile (Breeze)
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
