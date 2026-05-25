<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaElaboradoraRequest;
use App\Models\EmpresaElaboradora;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmpresaElaboradoraController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(EmpresaElaboradora::class, 'empresa_elaboradora');
    }

    public function index(): View
    {
        $empresas = EmpresaElaboradora::orderBy('razao_social')->paginate(15);

        return view('empresas-elaboradoras.index', compact('empresas'));
    }

    public function create(): View
    {
        return view('empresas-elaboradoras.create');
    }

    public function store(EmpresaElaboradoraRequest $request): RedirectResponse
    {
        $empresa = EmpresaElaboradora::create($request->validated());

        return redirect()
            ->route('empresas-elaboradoras.show', $empresa)
            ->with('success', 'Empresa elaboradora cadastrada com sucesso.');
    }

    public function show(EmpresaElaboradora $empresaElaboradora): View
    {
        return view('empresas-elaboradoras.show', [
            'empresa' => $empresaElaboradora,
        ]);
    }

    public function edit(EmpresaElaboradora $empresaElaboradora): View
    {
        return view('empresas-elaboradoras.edit', [
            'empresa' => $empresaElaboradora,
        ]);
    }

    public function update(EmpresaElaboradoraRequest $request, EmpresaElaboradora $empresaElaboradora): RedirectResponse
    {
        $empresaElaboradora->update($request->validated());

        return redirect()
            ->route('empresas-elaboradoras.show', $empresaElaboradora)
            ->with('success', 'Empresa elaboradora atualizada com sucesso.');
    }

    public function destroy(EmpresaElaboradora $empresaElaboradora): RedirectResponse
    {
        $empresaElaboradora->delete();

        return redirect()
            ->route('empresas-elaboradoras.index')
            ->with('success', 'Empresa elaboradora removida com sucesso.');
    }
}
