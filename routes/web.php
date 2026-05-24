<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// ----------------------------------------------------------------
// Autenticação (Breeze)
// ----------------------------------------------------------------
require __DIR__.'/auth.php';

// ----------------------------------------------------------------
// Rotas protegidas — qualquer usuário autenticado
// ----------------------------------------------------------------
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Perfil (Breeze)
    Route::get('/profile',    [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Leitura — qualquer role autenticado pode ver
    Route::get('/unidades',        [\App\Http\Controllers\UnidadeController::class, 'index'])->name('unidades.index');
    Route::get('/unidades/{unidade}', [\App\Http\Controllers\UnidadeController::class, 'show'])->name('unidades.show');

    Route::get('/setores',         [\App\Http\Controllers\SetorController::class, 'index'])->name('setores.index');
    Route::get('/setores/{setor}', [\App\Http\Controllers\SetorController::class, 'show'])->name('setores.show');

    Route::get('/ghes',       [\App\Http\Controllers\GheController::class, 'index'])->name('ghes.index');
    Route::get('/ghes/{ghe}', [\App\Http\Controllers\GheController::class, 'show'])->name('ghes.show');
});

// ----------------------------------------------------------------
// Escrita — somente admin e gestor
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin,gestor'])->group(function () {

    // Unidades (create/edit/update/destroy)
    Route::get('/unidades/create',             [\App\Http\Controllers\UnidadeController::class, 'create'])->name('unidades.create');
    Route::post('/unidades',                   [\App\Http\Controllers\UnidadeController::class, 'store'])->name('unidades.store');
    Route::get('/unidades/{unidade}/edit',     [\App\Http\Controllers\UnidadeController::class, 'edit'])->name('unidades.edit');
    Route::put('/unidades/{unidade}',          [\App\Http\Controllers\UnidadeController::class, 'update'])->name('unidades.update');
    Route::delete('/unidades/{unidade}',       [\App\Http\Controllers\UnidadeController::class, 'destroy'])->name('unidades.destroy');

    // Setores
    Route::get('/setores/create',              [\App\Http\Controllers\SetorController::class, 'create'])->name('setores.create');
    Route::post('/setores',                    [\App\Http\Controllers\SetorController::class, 'store'])->name('setores.store');
    Route::get('/setores/{setor}/edit',        [\App\Http\Controllers\SetorController::class, 'edit'])->name('setores.edit');
    Route::put('/setores/{setor}',             [\App\Http\Controllers\SetorController::class, 'update'])->name('setores.update');
    Route::delete('/setores/{setor}',          [\App\Http\Controllers\SetorController::class, 'destroy'])->name('setores.destroy');

    // GHEs
    Route::get('/ghes/create',                 [\App\Http\Controllers\GheController::class, 'create'])->name('ghes.create');
    Route::post('/ghes',                       [\App\Http\Controllers\GheController::class, 'store'])->name('ghes.store');
    Route::get('/ghes/{ghe}/edit',             [\App\Http\Controllers\GheController::class, 'edit'])->name('ghes.edit');
    Route::put('/ghes/{ghe}',                  [\App\Http\Controllers\GheController::class, 'update'])->name('ghes.update');
    Route::delete('/ghes/{ghe}',               [\App\Http\Controllers\GheController::class, 'destroy'])->name('ghes.destroy');
});

// ----------------------------------------------------------------
// Admin — somente administradores
// ----------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Route::resource('empresas', \App\Http\Controllers\Admin\EmpresaController::class);
        // Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class);
    });
