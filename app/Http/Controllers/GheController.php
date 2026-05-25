<?php

namespace App\Http\Controllers;

use App\Http\Requests\GheRequest;
use App\Models\Ghe;
use App\Models\Unidade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class GheController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Ghe::class);

        $ghes = Ghe::with(['setor.unidade'])
            ->whereHas('setor.unidade', fn ($q) =>
                $q->where('empresa_id', auth()->user()->empresa_id)
            )
            ->orderBy('nome')
            ->paginate(20);

        return view('ghes.index', compact('ghes'));
    }

    public function create(): View
    {
        Gate::authorize('create', Ghe::class);

        $unidades = Unidade::where('empresa_id', auth()->user()->empresa_id)
            ->with(['setores' => fn ($q) => $q->orderBy('nome')])
            ->orderBy('nome')
            ->get();

        return view('ghes.create', compact('unidades'));
    }

    public function store(GheRequest $request): RedirectResponse
    {
        Gate::authorize('create', Ghe::class);

        Ghe::create($request->validated());

        return redirect()->route('ghes.index')
            ->with('success', 'GHE criado com sucesso.');
    }

    public function show(Ghe $ghe): View
    {
        Gate::authorize('view', $ghe);

        $ghe->load('setor.unidade', 'riscosInventario');

        return view('ghes.show', compact('ghe'));
    }

    public function edit(Ghe $ghe): View
    {
        Gate::authorize('update', $ghe);

        $unidades = Unidade::where('empresa_id', auth()->user()->empresa_id)
            ->with(['setores' => fn ($q) => $q->orderBy('nome')])
            ->orderBy('nome')
            ->get();

        return view('ghes.edit', compact('ghe', 'unidades'));
    }

    public function update(GheRequest $request, Ghe $ghe): RedirectResponse
    {
        Gate::authorize('update', $ghe);

        $ghe->update($request->validated());

        return redirect()->route('ghes.index')
            ->with('success', 'GHE atualizado com sucesso.');
    }

    public function destroy(Ghe $ghe): RedirectResponse
    {
        Gate::authorize('delete', $ghe);

        $ghe->delete();

        return redirect()->route('ghes.index')
            ->with('success', 'GHE removido com sucesso.');
    }
}
