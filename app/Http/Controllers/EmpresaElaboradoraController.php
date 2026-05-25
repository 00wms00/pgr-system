<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaElaboradoraRequest;
use App\Models\EmpresaElaboradora;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EmpresaElaboradoraController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', EmpresaElaboradora::class);

        $empresas = EmpresaElaboradora::orderBy('razao_social')->paginate(15);

        return view('empresas-elaboradoras.index', compact('empresas'));
    }

    public function create(): View
    {
        Gate::authorize('create', EmpresaElaboradora::class);

        return view('empresas-elaboradoras.create');
    }

    public function store(EmpresaElaboradoraRequest $request): RedirectResponse
    {
        Gate::authorize('create', EmpresaElaboradora::class);

        $empresa = EmpresaElaboradora::create($request->validated());

        return redirect()
            ->route('empresas-elaboradoras.show', $empresa)
            ->with('success', 'Empresa elaboradora cadastrada com sucesso.');
    }

    public function show(EmpresaElaboradora $empresaElaboradora): View
    {
        Gate::authorize('view', $empresaElaboradora);

        return view('empresas-elaboradoras.show', [
            'empresa' => $empresaElaboradora,
        ]);
    }

    public function edit(EmpresaElaboradora $empresaElaboradora): View
    {
        Gate::authorize('update', $empresaElaboradora);

        return view('empresas-elaboradoras.edit', [
            'empresa' => $empresaElaboradora,
        ]);
    }

    public function update(EmpresaElaboradoraRequest $request, EmpresaElaboradora $empresaElaboradora): RedirectResponse
    {
        Gate::authorize('update', $empresaElaboradora);

        $empresaElaboradora->update($request->validated());

        return redirect()
            ->route('empresas-elaboradoras.show', $empresaElaboradora)
            ->with('success', 'Empresa elaboradora atualizada com sucesso.');
    }

    public function destroy(EmpresaElaboradora $empresaElaboradora): RedirectResponse
    {
        Gate::authorize('delete', $empresaElaboradora);

        $empresaElaboradora->delete();

        return redirect()
            ->route('empresas-elaboradoras.index')
            ->with('success', 'Empresa elaboradora removida com sucesso.');
    }
}
