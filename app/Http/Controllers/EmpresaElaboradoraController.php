<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaElaboradoraRequest;
use App\Http\Requests\UpdateEmpresaElaboradoraRequest;
use App\Models\EmpresaElaboradora;

class EmpresaElaboradoraController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', EmpresaElaboradora::class);

        $elaboradoras = EmpresaElaboradora::withCount('responsaveis')
            ->orderBy('razao_social')
            ->paginate(15);

        return view('empresa_elaboradora.index', compact('elaboradoras'));
    }

    public function create()
    {
        $this->authorize('create', EmpresaElaboradora::class);

        return view('empresa_elaboradora.create');
    }

    public function store(StoreEmpresaElaboradoraRequest $request)
    {
        $elaboradora = EmpresaElaboradora::create($request->validated());

        return redirect()
            ->route('empresa-elaboradora.show', $elaboradora)
            ->with('success', 'Empresa elaboradora cadastrada com sucesso.');
    }

    public function show(EmpresaElaboradora $empresaElaboradora)
    {
        $this->authorize('view', $empresaElaboradora);

        $empresaElaboradora->load('responsaveis');

        return view('empresa_elaboradora.show', compact('empresaElaboradora'));
    }

    public function edit(EmpresaElaboradora $empresaElaboradora)
    {
        $this->authorize('update', $empresaElaboradora);

        return view('empresa_elaboradora.edit', compact('empresaElaboradora'));
    }

    public function update(UpdateEmpresaElaboradoraRequest $request, EmpresaElaboradora $empresaElaboradora)
    {
        $empresaElaboradora->update($request->validated());

        return redirect()
            ->route('empresa-elaboradora.show', $empresaElaboradora)
            ->with('success', 'Empresa elaboradora atualizada com sucesso.');
    }

    public function destroy(EmpresaElaboradora $empresaElaboradora)
    {
        $this->authorize('delete', $empresaElaboradora);

        if ($empresaElaboradora->responsaveis()->exists()) {
            return back()->with('error', 'Não é possível excluir: há responsáveis técnicos vinculados.');
        }

        $empresaElaboradora->delete();

        return redirect()
            ->route('empresa-elaboradora.index')
            ->with('success', 'Empresa elaboradora removida.');
    }
}
