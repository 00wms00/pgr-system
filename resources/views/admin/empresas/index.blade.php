<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empresas</h2>
            <a href="{{ route('admin.empresas.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white text-sm">+ Nova Empresa</a>
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
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Razão Social</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">CNPJ</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Usuários</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Unidades</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($empresas as $empresa)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $empresa->razao_social }}</div>
                                    @if($empresa->nome_fantasia)
                                        <div class="text-xs text-gray-500">{{ $empresa->nome_fantasia }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-mono text-sm">{{ $empresa->cnpj }}</td>
                                <td class="px-4 py-3">{{ $empresa->usuarios_count }}</td>
                                <td class="px-4 py-3">{{ $empresa->unidades_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $empresa->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $empresa->ativo ? 'Ativa' : 'Inativa' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right space-x-3">
                                    <a href="{{ route('admin.empresas.show', $empresa) }}" class="text-indigo-600 text-sm">Ver</a>
                                    <a href="{{ route('admin.empresas.edit', $empresa) }}" class="text-yellow-600 text-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.empresas.destroy', $empresa) }}" class="inline" onsubmit="return confirm('Remover empresa?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 text-sm">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Nenhuma empresa cadastrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $empresas->links() }}</div>
        </div>
    </div>
</x-app-layout>
