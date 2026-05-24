<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Estrutura Organizacional
    Route::resource('unidades', \App\Http\Controllers\UnidadeController::class);
    Route::resource('setores',  \App\Http\Controllers\SetorController::class);
    Route::resource('ghes',     \App\Http\Controllers\GheController::class);
});

// Rotas exclusivas — Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Route::resource('empresas', \App\Http\Controllers\Admin\EmpresaController::class);
        // Route::resource('usuarios', \App\Http\Controllers\Admin\UsuarioController::class);
    });
