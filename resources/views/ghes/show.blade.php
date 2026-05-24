<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('ghes.index') }}" class="hover:text-blue-600">GHEs</a>
                    <span class="mx-1">›</span>
                    <span>{{ $ghe->nome }}</span>
                </p>
                <h2 class="text-xl font-semibold text-gray-800">{{ $ghe->nome }}</h2>
                <p class="text-xs text-gray-500 font-mono">
                    {{ $ghe->codigo }} · {{ $ghe->setor->nome }} · {{ $ghe->setor->unidade->nome }}
                </p>
            </div>
            <a href="{{ route('ghes.edit', $ghe) }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($ghe->descricao_atividades)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Descrição das Atividades</h3>
                <p class="text-sm text-gray-700">{{ $ghe->descricao_atividades }}</p>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Inventário de Riscos</h3>
                </div>
                <div class="px-4 py-8 text-center text-sm text-gray-400">
                    Inventário de riscos será implementado na Fase 3.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
