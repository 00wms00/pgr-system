<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Unidade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UnidadeController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Unidade::class);

        $unidades = Unidade::orderBy('nome')->paginate(20);

        return view('unidades.index', compact('unidades'));
    }

    public function create(): View
    {
        Gate::authorize('create', Unidade::class);

        return view('unidades.create');
    }

    public function store(UnidadeRequest $request): RedirectResponse
    {
        Gate::authorize('create', Unidade::class);

        Unidade::create($request->validated());

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade criada com sucesso.');
    }

    public function show(Unidade $unidade): View
    {
        Gate::authorize('view', $unidade);

        $unidade->load('setores.ghes');

        return view('unidades.show', compact('unidade'));
    }

    public function edit(Unidade $unidade): View
    {
        Gate::authorize('update', $unidade);

        return view('unidades.edit', compact('unidade'));
    }

    public function update(UnidadeRequest $request, Unidade $unidade): RedirectResponse
    {
        Gate::authorize('update', $unidade);

        $unidade->update($request->validated());

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade atualizada com sucesso.');
    }

    public function destroy(Unidade $unidade): RedirectResponse
    {
        Gate::authorize('delete', $unidade);

        $unidade->delete();

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade removida com sucesso.');
    }
}
