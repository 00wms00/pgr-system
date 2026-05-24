<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Avaliação de Risco</h2>
            @canwrite
                <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="rounded-md border px-4 py-2">Editar</a>
            @endcanwrite
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6 grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-lg">Dados da Avaliação</h3>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div><dt class="font-semibold">Data</dt><dd>{{ $avaliacao->data_avaliacao?->format('d/m/Y') }}</dd></div>
                        <div><dt class="font-semibold">Metodologia</dt><dd>{{ $avaliacao->metodologia ?: '—' }}</dd></div>
                        <div><dt class="font-semibold">Probabilidade</dt><dd>{{ $avaliacao->probabilidade }}</dd></div>
                        <div><dt class="font-semibold">Severidade</dt><dd>{{ $avaliacao->severidade }}</dd></div>
                        <div><dt class="font-semibold">Nível</dt><dd>{{ $avaliacao->nivel_risco }}</dd></div>
                        <div><dt class="font-semibold">Classificação</dt><dd class="uppercase">{{ $avaliacao->classificacao }}</dd></div>
                    </dl>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Risco Relacionado</h3>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div><dt class="font-semibold">GHE</dt><dd>{{ $avaliacao->riscoInventario->ghe->nome }}</dd></div>
                        <div><dt class="font-semibold">Tipo</dt><dd>{{ $avaliacao->riscoInventario->riscoTipo->categoria }} — {{ $avaliacao->riscoInventario->riscoTipo->nome }}</dd></div>
                        <div><dt class="font-semibold">Agente</dt><dd>{{ $avaliacao->riscoInventario->agente }}</dd></div>
                        <div><dt class="font-semibold">Justificativa</dt><dd>{{ $avaliacao->justificativa ?: '—' }}</dd></div>
                    </dl>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Matriz 5×5</h3>
                <div class="grid grid-cols-5 gap-2">
                    @for($sev = 1; $sev <= 5; $sev++)
                        @for($prob = 1; $prob <= 5; $prob++)
                            @php($value = $prob * $sev)
                            <div class="rounded-md border p-3 text-center text-sm font-semibold {{ $value > 12 ? 'bg-red-100' : ($value > 4 ? 'bg-yellow-100' : 'bg-green-100') }} {{ $avaliacao->probabilidade === $prob && $avaliacao->severidade === $sev ? 'ring-2 ring-indigo-600' : '' }}">
                                <div>{{ $value }}</div>
                                @if($avaliacao->probabilidade === $prob && $avaliacao->severidade === $sev)
                                    <div class="text-[10px] text-gray-600">Atual</div>
                                @endif
                            </div>
                        @endfor
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
