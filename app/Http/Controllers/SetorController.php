<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetorRequest;
use App\Models\Setor;
use App\Models\Unidade;

class SetorController extends Controller
{
    public function index()
    {
        // Unidade usa BelongsToEmpresa, setores filtrados via unidade
        $setores = Setor::whereHas('unidade', function ($q) {
            $q->where('empresa_id', auth()->user()->empresa_id);
        })->with('unidade')->orderBy('nome')->paginate(20);

        return view('setores.index', compact('setores'));
    }

    public function create()
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('setores.create', compact('unidades'));
    }

    public function store(SetorRequest $request)
    {
        Setor::create($request->validated());
        return redirect()->route('setores.index')->with('success', 'Setor criado com sucesso.');
    }

    public function show(Setor $setor)
    {
        $setor->load('unidade', 'ghes');
        return view('setores.show', compact('setor'));
    }

    public function edit(Setor $setor)
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('setores.edit', compact('setor', 'unidades'));
    }

    public function update(SetorRequest $request, Setor $setor)
    {
        $setor->update($request->validated());
        return redirect()->route('setores.index')->with('success', 'Setor atualizado.');
    }

    public function destroy(Setor $setor)
    {
        $setor->delete();
        return redirect()->route('setores.index')->with('success', 'Setor removido.');
    }
}
