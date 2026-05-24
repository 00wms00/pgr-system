<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Risco do Inventário</h2>
            <div class="flex gap-2">
                @canwrite
                    <a href="{{ route('riscos.edit', $risco) }}" class="rounded-md border px-4 py-2">Editar</a>
                    <a href="{{ route('avaliacoes.create', $risco) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-white">Nova Avaliação</a>
                @endcanwrite
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6 grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-lg">Identificação</h3>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div><dt class="font-semibold">GHE</dt><dd>{{ $risco->ghe->nome }}</dd></div>
                        <div><dt class="font-semibold">Setor / Unidade</dt><dd>{{ $risco->ghe->setor->nome }} / {{ $risco->ghe->setor->unidade->nome }}</dd></div>
                        <div><dt class="font-semibold">Tipo</dt><dd>{{ $risco->riscoTipo->categoria }} — {{ $risco->riscoTipo->nome }}</dd></div>
                        <div><dt class="font-semibold">Agente</dt><dd>{{ $risco->agente }}</dd></div>
                    </dl>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Descrição</h3>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div><dt class="font-semibold">Fonte Geradora</dt><dd>{{ $risco->fonte_geradora ?: '—' }}</dd></div>
                        <div><dt class="font-semibold">Possíveis Lesões</dt><dd>{{ $risco->possiveis_lesoes ?: '—' }}</dd></div>
                        <div><dt class="font-semibold">Danos à Saúde</dt><dd>{{ $risco->danos_saude ?: '—' }}</dd></div>
                        <div><dt class="font-semibold">Medidas Existentes</dt><dd>{{ $risco->medidas_existentes ?: '—' }}</dd></div>
                        <div><dt class="font-semibold">Observações</dt><dd>{{ $risco->observacoes ?: '—' }}</dd></div>
                    </dl>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-lg">Histórico de Avaliações</h3>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase">Data</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase">P</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase">S</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase">Nível</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase">Classificação</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($risco->avaliacoes as $avaliacao)
                                <tr>
                                    <td class="px-4 py-3">{{ $avaliacao->data_avaliacao?->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ $avaliacao->probabilidade }}</td>
                                    <td class="px-4 py-3">{{ $avaliacao->severidade }}</td>
                                    <td class="px-4 py-3">{{ $avaliacao->nivel_risco }}</td>
                                    <td class="px-4 py-3 uppercase">{{ $avaliacao->classificacao }}</td>
                                    <td class="px-4 py-3 text-right"><a href="{{ route('avaliacoes.show', $avaliacao) }}" class="text-indigo-600">Ver</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Nenhuma avaliação registrada.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
