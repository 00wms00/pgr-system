<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('unidades.index') }}" class="hover:text-blue-600">Unidades</a>
                    <span class="mx-1">›</span>
                    <span>{{ $unidade->nome }}</span>
                </p>
                <h2 class="text-xl font-semibold text-gray-800">{{ $unidade->nome }}</h2>
                <p class="text-sm text-gray-500 font-mono">{{ $unidade->codigo }}</p>
            </div>
            <a href="{{ route('unidades.edit', $unidade) }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Setores --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">Setores</h3>
                    <a href="{{ route('setores.create') }}?unidade_id={{ $unidade->id }}"
                       class="text-xs text-blue-600 hover:underline">+ Novo Setor</a>
                </div>
                @forelse($unidade->setores as $setor)
                <div class="px-4 py-3 border-b border-gray-50 last:border-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium">{{ $setor->nome }}</p>
                            @if($setor->descricao)
                            <p class="text-xs text-gray-500">{{ $setor->descricao }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400">{{ $setor->ghes->count() }} GHE(s)</span>
                    </div>
                </div>
                @empty
                <div class="px-4 py-8 text-center text-sm text-gray-400">Nenhum setor cadastrado.</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
