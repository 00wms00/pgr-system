<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmpresaRequest;
use App\Models\Empresa;
use App\Models\EmpresaCnae;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    // -----------------------------------------------------------------------
    // Helper: sincroniza CNAEs secundários
    // -----------------------------------------------------------------------

    private function syncCnaes(Empresa $empresa, array $cnaes): void
    {
        $empresa->cnaesSecundarios()->delete();
        foreach ($cnaes as $c) {
            if (!empty($c['codigo']) && !empty($c['descricao'])) {
                $empresa->cnaesSecundarios()->create([
                    'codigo'    => trim($c['codigo']),
                    'descricao' => trim($c['descricao']),
                ]);
            }
        }
    }

    // -----------------------------------------------------------------------
    // CRUD
    // -----------------------------------------------------------------------

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
        $empresa = new Empresa();
        return view('admin.empresas.create', compact('empresa'));
    }

    public function store(EmpresaRequest $request): RedirectResponse
    {
        Gate::authorize('create', Empresa::class);

        $dados = $request->safe()->except(['cnaes']);
        $dados['ativo'] = $request->boolean('ativo', true);

        $empresa = Empresa::create($dados);
        $this->syncCnaes($empresa, $request->input('cnaes', []));

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa criada com sucesso.');
    }

    public function edit(Empresa $empresa): View
    {
        Gate::authorize('update', $empresa);
        $empresa->load('cnaesSecundarios');
        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa): RedirectResponse
    {
        Gate::authorize('update', $empresa);

        $dados = $request->safe()->except(['cnaes']);
        $dados['ativo'] = $request->boolean('ativo', true);

        $empresa->update($dados);
        $this->syncCnaes($empresa, $request->input('cnaes', []));

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa atualizada.');
    }

    public function destroy(Empresa $empresa): RedirectResponse
    {
        Gate::authorize('delete', $empresa);

        if ($empresa->usuarios()->exists()) {
            return back()->with('error', 'Não é possível excluir uma empresa com usuários vinculados.');
        }

        $empresa->delete();

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa removida.');
    }
}
