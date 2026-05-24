<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">GHEs — Grupos Homogêneos de Exposição</h2>
            <a href="{{ route('ghes.create') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                + Novo GHE
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-alert />
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left">Código</th>
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-left">Setor / Unidade</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ghes as $ghe)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono text-gray-600 text-xs">{{ $ghe->codigo }}</td>
                            <td class="px-4 py-3 font-medium">{{ $ghe->nome }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $ghe->setor->nome }}
                                <span class="text-gray-400">· {{ $ghe->setor->unidade->nome }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $ghe->ativo ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $ghe->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-3">
                                <a href="{{ route('ghes.edit', $ghe) }}"
                                   class="text-blue-600 hover:underline text-xs">Editar</a>
                                <form action="{{ route('ghes.destroy', $ghe) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Remover este GHE?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-400 text-sm">
                                Nenhum GHE cadastrado.
                                <a href="{{ route('ghes.create') }}" class="text-blue-600 hover:underline ml-1">Criar o primeiro</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $ghes->links() }}</div>
        </div>
    </div>
</x-app-layout>
