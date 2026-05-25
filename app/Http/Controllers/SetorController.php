<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetorRequest;
use App\Models\Setor;
use App\Models\Unidade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SetorController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Setor::class);

        $setores = Setor::with('unidade')
            ->whereHas('unidade', fn ($q) => $q->where('empresa_id', auth()->user()->empresa_id))
            ->orderBy('nome')
            ->paginate(20);

        return view('setores.index', compact('setores'));
    }

    public function create(): View
    {
        Gate::authorize('create', Setor::class);

        $unidades = Unidade::where('empresa_id', auth()->user()->empresa_id)
            ->orderBy('nome')
            ->get();

        return view('setores.create', compact('unidades'));
    }

    public function store(SetorRequest $request): RedirectResponse
    {
        Gate::authorize('create', Setor::class);

        Setor::create($request->validated());

        return redirect()->route('setores.index')
            ->with('success', 'Setor criado com sucesso.');
    }

    public function show(Setor $setor): View
    {
        Gate::authorize('view', $setor);

        $setor->load('unidade', 'ghes');

        return view('setores.show', compact('setor'));
    }

    public function edit(Setor $setor): View
    {
        Gate::authorize('update', $setor);

        $unidades = Unidade::where('empresa_id', auth()->user()->empresa_id)
            ->orderBy('nome')
            ->get();

        return view('setores.edit', compact('setor', 'unidades'));
    }

    public function update(SetorRequest $request, Setor $setor): RedirectResponse
    {
        Gate::authorize('update', $setor);

        $setor->update($request->validated());

        return redirect()->route('setores.index')
            ->with('success', 'Setor atualizado com sucesso.');
    }

    public function destroy(Setor $setor): RedirectResponse
    {
        Gate::authorize('delete', $setor);

        $setor->delete();

        return redirect()->route('setores.index')
            ->with('success', 'Setor removido com sucesso.');
    }
}
