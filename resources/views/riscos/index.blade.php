<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventário de Riscos</h2>
            @canwrite
                <a href="{{ route('riscos.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white">+ Novo Risco</a>
            @endcanwrite
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <form method="GET" class="bg-white p-4 shadow sm:rounded-lg flex gap-4 items-end">
                <div class="w-full max-w-md">
                    <x-input-label for="ghe_id" value="Filtrar por GHE" />
                    <select id="ghe_id" name="ghe_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">Todos</option>
                        @foreach($ghes as $ghe)
                            <option value="{{ $ghe->id }}" @selected(request('ghe_id') == $ghe->id)>{{ $ghe->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button>Filtrar</x-primary-button>
            </form>

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">GHE</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Categoria</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Agente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase">Última Avaliação</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($riscos as $risco)
                            @php($ultima = $risco->avaliacoes->sortByDesc('data_avaliacao')->first())
                            <tr>
                                <td class="px-4 py-3">{{ $risco->ghe->nome }}</td>
                                <td class="px-4 py-3">{{ $risco->riscoTipo->categoria }} / {{ $risco->riscoTipo->nome }}</td>
                                <td class="px-4 py-3">{{ $risco->agente }}</td>
                                <td class="px-4 py-3">
                                    @if($ultima)
                                        <span class="font-semibold">{{ strtoupper($ultima->classificacao) }}</span> — Nível {{ $ultima->nivel_risco }}
                                    @else
                                        <span class="text-gray-500">Sem avaliação</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('riscos.show', $risco) }}" class="text-indigo-600">Ver</a>
                                    @canwrite
                                        <a href="{{ route('avaliacoes.create', $risco) }}" class="text-green-600">Avaliar</a>
                                    @endcanwrite
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Nenhum risco cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $riscos->links() }}
        </div>
    </div>
</x-app-layout>
