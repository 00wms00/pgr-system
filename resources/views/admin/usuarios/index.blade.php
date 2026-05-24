<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuários</h2>
            <a href="{{ route('admin.usuarios.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white text-sm">+ Novo Usuário</a>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-green-800">{{ session('success') }}</div>
            @endif
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">E-mail</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Empresa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Role</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td class="px-4 py-3">{{ $usuario->name }}</td>
                                <td class="px-4 py-3">{{ $usuario->email }}</td>
                                <td class="px-4 py-3">{{ $usuario->empresa?->nome_fantasia ?: $usuario->empresa?->razao_social ?: '—' }}</td>
                                <td class="px-4 py-3 uppercase text-xs font-semibold">{{ $usuario->role?->value }}</td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="text-yellow-600 text-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}" class="inline" onsubmit="return confirm('Remover usuário?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 text-sm">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum usuário cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $usuarios->links() }}</div>
        </div>
    </div>
</x-app-layout>
