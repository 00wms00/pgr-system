<?php

namespace App\Http\Controllers;

use App\Http\Requests\RiscoInventarioRequest;
use App\Models\AgenteQuantitativo;
use App\Models\Ghe;
use App\Models\RiscoInventario;
use App\Models\RiscoTipo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RiscoInventarioController extends Controller
{
    /** GHEs da empresa do usuário logado, com hierarquia carregada */
    private function ghesEmpresa()
    {
        return Ghe::whereHas('setor.unidade', fn ($q) =>
            $q->where('empresa_id', auth()->user()->empresa_id)
        )->with('setor.unidade')->orderBy('nome')->get();
    }

    /** Tipos de risco com agentes quantitativos pré-carregados (para o select dinâmico) */
    private function tiposComAgentes()
    {
        return RiscoTipo::with(['agentesQuantitativos' => fn ($q) =>
            $q->where('ativo', true)->orderBy('nome')
        ])->orderBy('grupo')->orderBy('nome')->get();
    }

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', RiscoInventario::class);

        $ghes   = $this->ghesEmpresa();
        $gheIds = $ghes->pluck('id');

        $riscos = RiscoInventario::with(['ghe.setor.unidade', 'riscoTipo', 'avaliacoes'])
            ->whereIn('ghe_id', $gheIds)
            ->when($request->filled('ghe_id'), fn ($q) =>
                $q->where('ghe_id', $request->integer('ghe_id'))
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('riscos.index', compact('riscos', 'ghes'));
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', RiscoInventario::class);

        $ghes          = $this->ghesEmpresa();
        $tipos         = $this->tiposComAgentes();
        $selectedGheId = $request->integer('ghe_id');

        return view('riscos.create', compact('ghes', 'tipos', 'selectedGheId'));
    }

    public function store(RiscoInventarioRequest $request): RedirectResponse
    {
        Gate::authorize('create', RiscoInventario::class);

        $risco = RiscoInventario::create($request->validated());

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Risco inventariado com sucesso.');
    }

    public function show(RiscoInventario $risco): View
    {
        Gate::authorize('view', $risco);

        $risco->load(['ghe.setor.unidade', 'riscoTipo', 'avaliacoes']);

        return view('riscos.show', compact('risco'));
    }

    public function edit(RiscoInventario $risco): View
    {
        Gate::authorize('update', $risco);

        $ghes  = $this->ghesEmpresa();
        $tipos = $this->tiposComAgentes();

        return view('riscos.edit', compact('risco', 'ghes', 'tipos'));
    }

    public function update(RiscoInventarioRequest $request, RiscoInventario $risco): RedirectResponse
    {
        Gate::authorize('update', $risco);

        $risco->update($request->validated());

        return redirect()->route('riscos.show', $risco)
            ->with('success', 'Risco atualizado com sucesso.');
    }

    public function destroy(RiscoInventario $risco): RedirectResponse
    {
        Gate::authorize('delete', $risco);

        $risco->delete();

        return redirect()->route('riscos.index')
            ->with('success', 'Risco removido.');
    }
}
