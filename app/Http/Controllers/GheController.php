<?php

namespace App\Http\Controllers;

use App\Http\Requests\GheRequest;
use App\Models\Ghe;
use App\Models\Unidade;

class GheController extends Controller
{
    public function index()
    {
        $ghes = Ghe::with('setor.unidade')->orderBy('nome')->paginate(20);
        return view('ghes.index', compact('ghes'));
    }

    public function create()
    {
        $unidades = Unidade::with('setores')->orderBy('nome')->get();
        return view('ghes.create', compact('unidades'));
    }

    public function store(GheRequest $request)
    {
        Ghe::create($request->validated());
        return redirect()->route('ghes.index')
            ->with('success', 'GHE criado com sucesso.');
    }

    public function show(Ghe $ghe)
    {
        return view('ghes.show', compact('ghe'));
    }

    public function edit(Ghe $ghe)
    {
        $unidades = Unidade::with('setores')->orderBy('nome')->get();
        return view('ghes.edit', compact('ghe', 'unidades'));
    }

    public function update(GheRequest $request, Ghe $ghe)
    {
        $ghe->update($request->validated());
        return redirect()->route('ghes.index')
            ->with('success', 'GHE atualizado.');
    }

    public function destroy(Ghe $ghe)
    {
        $ghe->delete();
        return redirect()->route('ghes.index')
            ->with('success', 'GHE removido.');
    }
}
