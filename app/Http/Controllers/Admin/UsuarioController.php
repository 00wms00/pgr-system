<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsuarioRequest;
use App\Models\Empresa;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('empresa')->orderBy('name')->paginate(20);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $empresas = Empresa::where('ativo', true)->orderBy('razao_social')->get();
        return view('admin.usuarios.create', compact('empresas'));
    }

    public function store(UsuarioRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $usuario)
    {
        $empresas = Empresa::where('ativo', true)->orderBy('razao_social')->get();
        return view('admin.usuarios.edit', compact('usuario', 'empresas'));
    }

    public function update(UsuarioRequest $request, User $usuario)
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $usuario->update($data);
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário atualizado.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário removido.');
    }
}
