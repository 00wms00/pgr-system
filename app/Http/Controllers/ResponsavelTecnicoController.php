<?php

namespace App\Http\Controllers;

use App\Enums\TipoRegistro;
use App\Http\Requests\StoreResponsavelTecnicoRequest;
use App\Http\Requests\UpdateResponsavelTecnicoRequest;
use App\Models\EmpresaElaboradora;
use App\Models\ResponsavelTecnico;

class ResponsavelTecnicoController extends Controller
{
    public function create(EmpresaElaboradora $empresaElaboradora)
    {
        $this->authorize('update', $empresaElaboradora);

        $tiposRegistro = TipoRegistro::options();
        $ufs = $this->listaUFs();

        return view('empresa_elaboradora.responsaveis.create', compact(
            'empresaElaboradora',
            'tiposRegistro',
            'ufs'
        ));
    }

    public function store(StoreResponsavelTecnicoRequest $request, EmpresaElaboradora $empresaElaboradora)
    {
        $this->authorize('update', $empresaElaboradora);

        $empresaElaboradora->todosResponsaveis()->create($request->validated());

        return redirect()
            ->route('empresa-elaboradora.show', $empresaElaboradora)
            ->with('success', 'Responsável técnico adicionado com sucesso.');
    }

    public function edit(EmpresaElaboradora $empresaElaboradora, ResponsavelTecnico $responsavel)
    {
        $this->authorize('update', $empresaElaboradora);

        abort_if($responsavel->empresa_elaboradora_id !== $empresaElaboradora->id, 404);

        $tiposRegistro = TipoRegistro::options();
        $ufs = $this->listaUFs();

        return view('empresa_elaboradora.responsaveis.edit', compact(
            'empresaElaboradora',
            'responsavel',
            'tiposRegistro',
            'ufs'
        ));
    }

    public function update(UpdateResponsavelTecnicoRequest $request, EmpresaElaboradora $empresaElaboradora, ResponsavelTecnico $responsavel)
    {
        $this->authorize('update', $empresaElaboradora);

        abort_if($responsavel->empresa_elaboradora_id !== $empresaElaboradora->id, 404);

        $responsavel->update($request->validated());

        return redirect()
            ->route('empresa-elaboradora.show', $empresaElaboradora)
            ->with('success', 'Responsável técnico atualizado.');
    }

    public function destroy(EmpresaElaboradora $empresaElaboradora, ResponsavelTecnico $responsavel)
    {
        $this->authorize('update', $empresaElaboradora);

        abort_if($responsavel->empresa_elaboradora_id !== $empresaElaboradora->id, 404);

        $responsavel->delete();

        return redirect()
            ->route('empresa-elaboradora.show', $empresaElaboradora)
            ->with('success', 'Responsável técnico removido.');
    }

    private function listaUFs(): array
    {
        return [
            'AC','AL','AP','AM','BA','CE','DF','ES','GO',
            'MA','MT','MS','MG','PA','PB','PR','PE','PI',
            'RJ','RN','RS','RO','RR','SC','SP','SE','TO',
        ];
    }
}
