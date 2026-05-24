<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Unidades</h2>
            <a href="{{ route('unidades.create') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                + Nova Unidade
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
                            <th class="px-4 py-3 text-left">Endereço</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($unidades as $unidade)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-mono text-gray-600">{{ $unidade->codigo }}</td>
                            <td class="px-4 py-3 font-medium">{{ $unidade->nome }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $unidade->endereco ?? '—' }}</td>
                            <td class="px-4 py-3 text-right space-x-3">
                                <a href="{{ route('unidades.edit', $unidade) }}"
                                   class="text-blue-600 hover:underline text-xs">Editar</a>
                                <form action="{{ route('unidades.destroy', $unidade) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Remover esta unidade?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-400 text-sm">
                                Nenhuma unidade cadastrada.
                                <a href="{{ route('unidades.create') }}" class="text-blue-600 hover:underline ml-1">Criar a primeira</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $unidades->links() }}</div>
        </div>
    </div>
</x-app-layout>
