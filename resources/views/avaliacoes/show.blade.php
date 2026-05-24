<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Avaliação &mdash; {{ $avaliacao->riscoInventario->riscoTipo->nome ?? 'Risco' }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('avaliacoes.edit', $avaliacao) }}" class="rounded-md border px-4 py-2 text-sm">Editar</a>
                <a href="{{ route('planos.create', $avaliacao) }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white">+ Plano de Ação</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-md bg-green-50 p-4 text-green-800">{{ session('success') }}</div>
            @endif

            {{-- Contexto do risco --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Contexto do Risco</h3>
                <dl class="grid sm:grid-cols-3 gap-4 text-sm">
                    <div><dt class="font-medium text-gray-500">GHE</dt><dd>{{ $avaliacao->riscoInventario->ghe->nome }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Setor</dt><dd>{{ $avaliacao->riscoInventario->ghe->setor->nome }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Unidade</dt><dd>{{ $avaliacao->riscoInventario->ghe->setor->unidade->nome }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Grupo de Risco</dt><dd>{{ $avaliacao->riscoInventario->riscoTipo->grupo }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Tipo de Risco</dt><dd>{{ $avaliacao->riscoInventario->riscoTipo->nome }}</dd></div>
                    <div><dt class="font-medium text-gray-500">Fonte Geradora</dt><dd>{{ $avaliacao->riscoInventario->fonte_geradora }}</dd></div>
                </dl>
            </div>

            {{-- Matriz resultado --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Resultado da Avaliação</h3>
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    {{-- Matriz visual --}}
                    <div>
                        @include('avaliacoes._matrix', [
                            'selectedP'   => $avaliacao->probabilidade,
                            'selectedS'   => $avaliacao->severidade,
                            'interactive' => false
                        ])
                    </div>
                    {{-- Resumo --}}
                    <div class="space-y-4 text-sm">
                        <dl class="space-y-2">
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Probabilidade</dt>
                                <dd class="font-semibold">{{ $avaliacao->probabilidade }}</dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Severidade</dt>
                                <dd class="font-semibold">{{ $avaliacao->severidade }}</dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Nível de Risco</dt>
                                <dd class="font-bold text-lg">{{ $avaliacao->nivel_risco }}</dd>
                            </div>
                            <div class="flex gap-2 items-center">
                                <dt class="font-medium text-gray-500 w-32">Classificação</dt>
                                <dd>
                                    @php
                                        $badgeColors = [
                                            'baixo'    => 'bg-green-100 text-green-800',
                                            'moderado' => 'bg-yellow-100 text-yellow-800',
                                            'alto'     => 'bg-orange-100 text-orange-800',
                                            'critico'  => 'bg-red-100 text-red-800',
                                        ];
                                        $badgeColor = $badgeColors[$avaliacao->classificacao] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $badgeColor }}">
                                        {{ ucfirst($avaliacao->classificacao) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Metodologia</dt>
                                <dd>{{ $avaliacao->metodologia }}</dd>
                            </div>
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Data</dt>
                                <dd>{{ $avaliacao->data_avaliacao->format('d/m/Y') }}</dd>
                            </div>
                            @if($avaliacao->avaliador)
                            <div class="flex gap-2">
                                <dt class="font-medium text-gray-500 w-32">Avaliado por</dt>
                                <dd>{{ $avaliacao->avaliador->name }}</dd>
                            </div>
                            @endif
                        </dl>
                        @if($avaliacao->justificativa)
                            <div class="pt-2 border-t">
                                <p class="font-medium text-gray-500 mb-1">Justificativa</p>
                                <p class="text-gray-700 leading-relaxed">{{ $avaliacao->justificativa }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Planos de Ação --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-700">Planos de Ação ({{ $avaliacao->planosAcao->count() }})</h3>
                    <a href="{{ route('planos.create', $avaliacao) }}" class="text-sm text-indigo-600">+ Novo plano</a>
                </div>
                @if($avaliacao->planosAcao->isEmpty())
                    <p class="text-gray-400 text-sm italic text-center py-4">Nenhum plano de ação cadastrado.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase text-xs">Tipo</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase text-xs">Descrição</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase text-xs">Responsável</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase text-xs">Prazo</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase text-xs">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($avaliacao->planosAcao as $plano)
                                @php
                                    $statusColors = [
                                        'pendente'     => 'bg-gray-100 text-gray-700',
                                        'em_andamento' => 'bg-blue-100 text-blue-700',
                                        'concluido'    => 'bg-green-100 text-green-700',
                                    ];
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">{{ \App\Models\PlanoAcao::TIPOS_CONTROLE[$plano->tipo_controle] ?? $plano->tipo_controle }}</td>
                                    <td class="px-4 py-3">{{ $plano->descricao }}</td>
                                    <td class="px-4 py-3">{{ $plano->responsavel }}</td>
                                    <td class="px-4 py-3 tabular-nums">{{ $plano->prazo->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusColors[$plano->status] ?? '' }}">
                                            {{ \App\Models\PlanoAcao::STATUS[$plano->status] ?? $plano->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('planos.edit', $plano) }}" class="text-yellow-600">Editar</a>
                                        <form method="POST" action="{{ route('planos.destroy', $plano) }}" class="inline" onsubmit="return confirm('Remover plano?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
