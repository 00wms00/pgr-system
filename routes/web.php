<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaElaboradoraController;

Route::get('/', function () {
    return redirect()->route('empresas-elaboradoras.index');
});

// ── Sprint 1: Empresa Elaboradora ────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard — alias para o index principal do sistema
    Route::get('/dashboard', function () {
        return redirect()->route('empresas-elaboradoras.index');
    })->name('dashboard');

    Route::resource('empresas-elaboradoras', EmpresaElaboradoraController::class);

});

// Auth (Breeze)
require __DIR__.'/auth.php';
