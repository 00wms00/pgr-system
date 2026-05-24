<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Perfil (Breeze)
    Route::get('/profile',   [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Estrutura Organizacional
    Route::resource('unidades', \App\Http\Controllers\UnidadeController::class);
    Route::resource('setores',  \App\Http\Controllers\SetorController::class);
    Route::resource('ghes',     \App\Http\Controllers\GheController::class);
});

// Autenticação (Breeze)
require __DIR__.'/auth.php';

// Rotas exclusivas — Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Route::resource('empresas', \App\Http\Controllers\Admin\EmpresaController::class);
        // Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class);
    });
