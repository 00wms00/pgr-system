<?php

namespace App\Http\Controllers;

use App\Http\Requests\RiscoInventarioRequest;
use App\Models\Ghe;
use App\Models\RiscoInventario;
use App\Models\RiscoTipo;
use Illuminate\Http\Request;

class RiscoInventarioController extends Controller
{
    public function index(Request $request)
    {
        $ghes = Ghe::orderBy('nome')->get();

        $riscos = RiscoInventario::with(['ghe.setor.unidade', 'riscoTipo', 'avaliacoes'])
            ->when($request->filled('ghe_id'), fn ($q) => $q->where('ghe_id', $request->integer('ghe_id')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('riscos.index', compact('riscos', 'ghes'));
    }

    public function create(Request $request)
    {
        $ghes = Ghe::with('setor.unidade')->orderBy('nome')->get();
        $tipos = RiscoTipo::orderBy('grupo')->orderBy('nome')->get();
        $selectedGheId = $request->integer('ghe_id');

        return view('riscos.create', compact('ghes', 'tipos', 'selectedGheId'));
    }

    public function store(RiscoInventarioRequest $request)
    {
        $risco = RiscoInventario::create($request->validated());

        return redirect()->route('avaliacoes.create', $risco)
            ->with('success', 'Risco inventariado. Registre agora a avaliação.');
    }

    public function show(RiscoInventario $risco)
    {
        $risco->load(['ghe.setor.unidade', 'riscoTipo', 'avaliacoes']);
        return view('riscos.show', compact('risco'));
    }

    public function edit(RiscoInventario $risco)
    {
        $ghes = Ghe::with('setor.unidade')->orderBy('nome')->get();
        $tipos = RiscoTipo::orderBy('grupo')->orderBy('nome')->get();
        return view('riscos.edit', compact('risco', 'ghes', 'tipos'));
    }

    public function update(RiscoInventarioRequest $request, RiscoInventario $risco)
    {
        $risco->update($request->validated());
        return redirect()->route('riscos.show', $risco)->with('success', 'Risco atualizado.');
    }

    public function destroy(RiscoInventario $risco)
    {
        $risco->delete();
        return redirect()->route('riscos.index')->with('success', 'Risco removido.');
    }
}
