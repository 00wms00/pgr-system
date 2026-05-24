<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

require __DIR__.'/auth.php';

// ----------------------------------------------------------------
// Autenticado — somente leitura
// ----------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile',    [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------------------------------------------------------------
// Escrita — admin e gestor
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin,gestor'])->group(function () {
    Route::resource('unidades',  \App\Http\Controllers\UnidadeController::class);
    Route::resource('setores',   \App\Http\Controllers\SetorController::class);
    Route::resource('ghes',      \App\Http\Controllers\GheController::class);
    Route::resource('riscos',    \App\Http\Controllers\RiscoInventarioController::class);

    // Avaliações aninhadas em riscos
    Route::get('/riscos/{risco}/avaliar',     [\App\Http\Controllers\AvaliacaoRiscoController::class, 'create'])->name('avaliacoes.create');
    Route::post('/riscos/{risco}/avaliacoes', [\App\Http\Controllers\AvaliacaoRiscoController::class, 'store'])->name('avaliacoes.store');
    Route::resource('avaliacoes', \App\Http\Controllers\AvaliacaoRiscoController::class)->except('create', 'store');
});

// ----------------------------------------------------------------
// Admin
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('empresas', \App\Http\Controllers\Admin\EmpresaController::class);
        Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class)->except('show');
    });
