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

    // Dashboard — ponto de entrada pós-login
    Route::get('/dashboard', function () {
        return redirect()->route('empresas-elaboradoras.index');
    })->name('dashboard');

    // ── Sprint 1: Empresa Elaboradora ────────────────────────────────────
    Route::resource('empresas-elaboradoras', EmpresaElaboradoraController::class);

    // ── Sprint 2+: Estrutura Organizacional (stubs — a implementar) ─────────
    Route::get('/unidades',          [UnidadeController::class, 'index'])->name('unidades.index');
    Route::get('/setores',           [SetorController::class,   'index'])->name('setores.index');
    Route::get('/ghes',              [GheController::class,     'index'])->name('ghes.index');

    // ── Sprint 3+: PGR (stubs — a implementar) ───────────────────────
    Route::get('/riscos',            [RiscoInventarioController::class, 'index'])->name('riscos.index');
    Route::get('/relatorio/pgr',     [RelatorioPgrController::class,    'index'])->name('relatorio.pgr');

    // ── Admin (stubs — a implementar) ───────────────────────────────
    Route::get('/admin/usuarios',    fn() => abort(501, 'Em desenvolvimento'))->name('admin.usuarios.index');
    Route::get('/admin/empresas',    fn() => abort(501, 'Em desenvolvimento'))->name('admin.empresas.index');

    // ── Profile (Breeze) ──────────────────────────────────────────
    Route::get('/profile',           [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',         [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',        [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Auth (Breeze)
require __DIR__.'/auth.php';
