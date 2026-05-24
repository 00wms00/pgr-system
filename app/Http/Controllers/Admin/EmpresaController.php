<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmpresaRequest;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::withCount('usuarios', 'unidades')
            ->orderBy('razao_social')
            ->paginate(20);

        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
    }

    public function store(EmpresaRequest $request)
    {
        Empresa::create($request->validated());
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa criada com sucesso.');
    }

    public function show(Empresa $empresa)
    {
        $empresa->load('unidades', 'usuarios');
        return view('admin.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->validated());
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa atualizada.');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa removida.');
    }
}
