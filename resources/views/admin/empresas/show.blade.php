<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $empresa->razao_social }}</h2>
            <a href="{{ route('admin.empresas.edit', $empresa) }}" class="rounded-md border px-4 py-2 text-sm">Editar</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6 grid md:grid-cols-2 gap-6">
                <dl class="space-y-3 text-sm">
                    <div><dt class="font-semibold">Razão Social</dt><dd>{{ $empresa->razao_social }}</dd></div>
                    <div><dt class="font-semibold">Nome Fantasia</dt><dd>{{ $empresa->nome_fantasia ?: '—' }}</dd></div>
                    <div><dt class="font-semibold">CNPJ</dt><dd class="font-mono">{{ $empresa->cnpj }}</dd></div>
                    <div><dt class="font-semibold">Endereço</dt><dd>{{ $empresa->endereco ?: '—' }}</dd></div>
                    <div><dt class="font-semibold">Status</dt><dd>{{ $empresa->ativo ? 'Ativa' : 'Inativa' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Usuários</h3>
                    <a href="{{ route('admin.usuarios.create') }}" class="text-sm text-indigo-600">+ Novo usuário</a>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">Nome</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">E-mail</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase">Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($empresa->usuarios as $usuario)
                            <tr>
                                <td class="px-4 py-3">{{ $usuario->name }}</td>
                                <td class="px-4 py-3">{{ $usuario->email }}</td>
                                <td class="px-4 py-3 uppercase text-xs">{{ $usuario->role?->value }}</td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('admin.usuarios.edit', $usuario) }}" class="text-indigo-600 text-sm">Editar</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Nenhum usuário.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Unidades</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse($empresa->unidades as $unidade)
                        <li class="py-2 flex justify-between text-sm">
                            <span>{{ $unidade->nome }}</span>
                            <a href="{{ route('unidades.show', $unidade) }}" class="text-indigo-600">Ver</a>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500">Nenhuma unidade.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
