<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Empresa::class);

        $empresas = Empresa::withCount('usuarios')
            ->orderBy('razao_social')
            ->paginate(25);

        return view('admin.empresas.index', compact('empresas'));
    }

    public function create(): View
    {
        Gate::authorize('create', Empresa::class);

        return view('admin.empresas.create');
    }

    public function store(EmpresaRequest $request): RedirectResponse
    {
        Gate::authorize('create', Empresa::class);

        Empresa::create($request->validated());

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa criada com sucesso.');
    }

    public function edit(Empresa $empresa): View
    {
        Gate::authorize('update', $empresa);

        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa): RedirectResponse
    {
        Gate::authorize('update', $empresa);

        $empresa->update($request->validated());

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa atualizada.');
    }

    public function destroy(Empresa $empresa): RedirectResponse
    {
        Gate::authorize('delete', $empresa);

        // Impede exclusão se houver usuários vinculados
        if ($empresa->usuarios()->exists()) {
            return back()->with('error', 'Não é possível excluir uma empresa com usuários vinculados.');
        }

        $empresa->delete();

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa removida.');
    }
}
