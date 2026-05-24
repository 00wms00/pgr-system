<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Unidade;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::orderBy('nome')->paginate(20);
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function store(UnidadeRequest $request)
    {
        Unidade::create($request->validated());
        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso.');
    }

    public function show(Unidade $unidade)
    {
        $unidade->load('setores.ghes');
        return view('unidades.show', compact('unidade'));
    }

    public function edit(Unidade $unidade)
    {
        return view('unidades.edit', compact('unidade'));
    }

    public function update(UnidadeRequest $request, Unidade $unidade)
    {
        $unidade->update($request->validated());
        return redirect()->route('unidades.index')->with('success', 'Unidade atualizada.');
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidade removida.');
    }
}
