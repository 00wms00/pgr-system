<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

require __DIR__.'/auth.php';

// ----------------------------------------------------------------
// Autenticado
// ----------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::get('/profile',    [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Relatório PGR (leitura — todos os perfis autenticados)
    Route::get('/relatorio/pgr', [\App\Http\Controllers\RelatorioPgrController::class, 'index'])->name('relatorio.pgr');
});

// ----------------------------------------------------------------
// Escrita — admin e gestor
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin,gestor'])->group(function () {
    Route::resource('unidades', \App\Http\Controllers\UnidadeController::class)
         ->parameters(['unidades' => 'unidade']);

    Route::resource('setores', \App\Http\Controllers\SetorController::class)
         ->parameters(['setores' => 'setor']);

    Route::resource('ghes', \App\Http\Controllers\GheController::class)
         ->parameters(['ghes' => 'ghe']);

    Route::resource('riscos', \App\Http\Controllers\RiscoInventarioController::class)
         ->parameters(['riscos' => 'risco']);

    // Avaliações
    Route::get(   '/riscos/{risco}/avaliar',          [\App\Http\Controllers\AvaliacaoRiscoController::class, 'create'])->name('avaliacoes.create');
    Route::post(  '/riscos/{risco}/avaliacoes',        [\App\Http\Controllers\AvaliacaoRiscoController::class, 'store'])->name('avaliacoes.store');
    Route::get(   '/avaliacoes/{avaliacao}',           [\App\Http\Controllers\AvaliacaoRiscoController::class, 'show'])->name('avaliacoes.show');
    Route::get(   '/avaliacoes/{avaliacao}/edit',      [\App\Http\Controllers\AvaliacaoRiscoController::class, 'edit'])->name('avaliacoes.edit');
    Route::put(   '/avaliacoes/{avaliacao}',           [\App\Http\Controllers\AvaliacaoRiscoController::class, 'update'])->name('avaliacoes.update');
    Route::delete('/avaliacoes/{avaliacao}',           [\App\Http\Controllers\AvaliacaoRiscoController::class, 'destroy'])->name('avaliacoes.destroy');

    // Planos de Ação
    Route::get(   '/avaliacoes/{avaliacao}/planos/create', [\App\Http\Controllers\PlanoAcaoController::class, 'create'])->name('planos.create');
    Route::post(  '/planos',                               [\App\Http\Controllers\PlanoAcaoController::class, 'store'])->name('planos.store');
    Route::get(   '/planos/{plano}/edit',                  [\App\Http\Controllers\PlanoAcaoController::class, 'edit'])->name('planos.edit');
    Route::put(   '/planos/{plano}',                       [\App\Http\Controllers\PlanoAcaoController::class, 'update'])->name('planos.update');
    Route::delete('/planos/{plano}',                       [\App\Http\Controllers\PlanoAcaoController::class, 'destroy'])->name('planos.destroy');
});

// ----------------------------------------------------------------
// Admin
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('empresas', \App\Http\Controllers\Admin\EmpresaController::class)
             ->parameters(['empresas' => 'empresa']);

        Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class)
             ->parameters(['usuarios' => 'usuario'])
             ->except('show');
    });
