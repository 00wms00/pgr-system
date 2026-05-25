<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaElaboradoraController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\GheController;
use App\Http\Controllers\RiscoInventarioController;
use App\Http\Controllers\PlanoAcaoController;
use App\Http\Controllers\RelatorioPgrController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('empresas-elaboradoras.index');
    })->name('dashboard');

    // Sprint 1: Empresa Elaboradora
    Route::resource('empresas-elaboradoras', EmpresaElaboradoraController::class);

    // Sprint 2: Unidades
    Route::resource('unidades', UnidadeController::class);

    // Sprint 3: Setores
    Route::resource('setores', SetorController::class);

    // Sprints futuras (stubs)
    Route::get('/ghes',          [GheController::class,            'index'])->name('ghes.index');
    Route::get('/riscos',        [RiscoInventarioController::class,'index'])->name('riscos.index');
    Route::get('/relatorio/pgr', [RelatorioPgrController::class,   'index'])->name('relatorio.pgr');
    Route::get('/admin/usuarios',fn() => abort(501, 'Em desenvolvimento'))->name('admin.usuarios.index');
    Route::get('/admin/empresas', fn() => abort(501, 'Em desenvolvimento'))->name('admin.empresas.index');

    // Profile (Breeze)
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
