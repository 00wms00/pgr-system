<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsuarioRequest;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', User::class);

        $usuarios = User::with('empresa')
            ->orderBy('name')
            ->paginate(25);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        Gate::authorize('create', User::class);

        $empresas = Empresa::where('ativo', true)->orderBy('razao_social')->get();
        $roles    = UserRole::cases();

        return view('admin.usuarios.create', compact('empresas', 'roles'));
    }

    public function store(UsuarioRequest $request): RedirectResponse
    {
        Gate::authorize('create', User::class);

        User::create($request->validated());

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $usuario): View
    {
        Gate::authorize('update', $usuario);

        $empresas = Empresa::where('ativo', true)->orderBy('razao_social')->get();
        $roles    = UserRole::cases();

        return view('admin.usuarios.edit', compact('usuario', 'empresas', 'roles'));
    }

    public function update(UsuarioRequest $request, User $usuario): RedirectResponse
    {
        Gate::authorize('update', $usuario);

        $dados = $request->validated();

        // Só atualiza senha se informada
        if (empty($dados['password'])) {
            unset($dados['password']);
        }

        $usuario->update($dados);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário atualizado.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        Gate::authorize('delete', $usuario);

        // Impede auto-delete
        abort_if($usuario->id === auth()->id(), 403, 'Não é possível excluir o próprio usuário.');

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário removido.');
    }
}
