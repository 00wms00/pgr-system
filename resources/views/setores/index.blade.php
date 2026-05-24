<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Setores</h2>
            <a href="{{ route('setores.create') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                + Novo Setor
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
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-left">Unidade</th>
                            <th class="px-4 py-3 text-left">Descrição</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($setores as $setor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $setor->nome }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $setor->unidade->nome }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $setor->descricao ?? '—' }}</td>
                            <td class="px-4 py-3 text-right space-x-3">
                                <a href="{{ route('setores.edit', $setor) }}"
                                   class="text-blue-600 hover:underline text-xs">Editar</a>
                                <form action="{{ route('setores.destroy', $setor) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Remover este setor?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-400 text-sm">
                                Nenhum setor cadastrado.
                                <a href="{{ route('setores.create') }}" class="text-blue-600 hover:underline ml-1">Criar o primeiro</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $setores->links() }}</div>
        </div>
    </div>
</x-app-layout>
