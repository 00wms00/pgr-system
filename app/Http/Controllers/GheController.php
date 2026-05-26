<?php

namespace App\Http\Controllers;

use App\Http\Requests\GheRequest;
use App\Models\Ghe;
use App\Models\Setor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GheController extends Controller
{
    use AuthorizesRequests;

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function setoresAutorizados(): \Illuminate\Database\Eloquent\Collection
    {
        return Setor::whereHas('unidade', fn ($q) =>
            $q->where('empresa_id', auth()->user()->empresa_id)
        )->orderBy('nome')->get();
    }

    private function syncCbos(Ghe $ghe, array $cbos): void
    {
        $ghe->cbos()->delete();
        foreach ($cbos as $cbo) {
            if (!empty($cbo['codigo']) && !empty($cbo['descricao'])) {
                $ghe->cbos()->create([
                    'codigo'    => trim($cbo['codigo']),
                    'descricao' => trim($cbo['descricao']),
                ]);
            }
        }
    }

    private function syncCargos(Ghe $ghe, array $cargos): void
    {
        $ghe->cargos()->delete();
        foreach ($cargos as $cargo) {
            if (filled($cargo)) {
                $ghe->cargos()->create(['cargo' => trim($cargo)]);
            }
        }
    }

    // -----------------------------------------------------------------------
    // CRUD
    // -----------------------------------------------------------------------

    public function index(): View
    {
        $ghes = Ghe::with(['setor.unidade', 'cbos', 'cargos'])
            ->whereHas('setor.unidade', fn ($q) =>
                $q->where('empresa_id', auth()->user()->empresa_id)
            )
            ->orderBy('nome')
            ->paginate(20);

        return view('ghes.index', compact('ghes'));
    }

    public function create(): View
    {
        $setores = $this->setoresAutorizados();
        $ghe     = new Ghe();
        return view('ghes.create', compact('setores', 'ghe'));
    }

    public function store(GheRequest $request): RedirectResponse
    {
        $dados = $request->safe()->except(['cbos', 'cargos']);
        $dados['ativo'] = $request->boolean('ativo', true);

        $ghe = Ghe::create($dados);

        $this->syncCbos($ghe, $request->input('cbos', []));
        $this->syncCargos($ghe, $request->input('cargos', []));

        return redirect()->route('ghes.index')
            ->with('success', 'GHE cadastrado com sucesso.');
    }

    public function show(Ghe $ghe): View
    {
        $this->authorize('view', $ghe);
        $ghe->load(['setor.unidade', 'cbos', 'cargos', 'riscosInventario.riscoTipo']);
        return view('ghes.show', compact('ghe'));
    }

    public function edit(Ghe $ghe): View
    {
        $this->authorize('update', $ghe);
        $ghe->load(['cbos', 'cargos']);
        $setores = $this->setoresAutorizados();
        return view('ghes.edit', compact('ghe', 'setores'));
    }

    public function update(GheRequest $request, Ghe $ghe): RedirectResponse
    {
        $this->authorize('update', $ghe);

        $dados = $request->safe()->except(['cbos', 'cargos']);
        $dados['ativo'] = $request->boolean('ativo', true);

        $ghe->update($dados);

        $this->syncCbos($ghe, $request->input('cbos', []));
        $this->syncCargos($ghe, $request->input('cargos', []));

        return redirect()->route('ghes.show', $ghe)
            ->with('success', 'GHE atualizado com sucesso.');
    }

    public function destroy(Ghe $ghe): RedirectResponse
    {
        $this->authorize('delete', $ghe);
        $ghe->delete();
        return redirect()->route('ghes.index')
            ->with('success', 'GHE removido.');
    }
}
