<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">
                    <a href="{{ route('setores.index') }}" class="hover:text-blue-600">Setores</a>
                    <span class="mx-1">›</span>
                    <span>{{ $setor->nome }}</span>
                </p>
                <h2 class="text-xl font-semibold text-gray-800">{{ $setor->nome }}</h2>
                <p class="text-sm text-gray-500">{{ $setor->unidade->nome }}</p>
            </div>
            <a href="{{ route('setores.edit', $setor) }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">GHEs deste Setor</h3>
                    <a href="{{ route('ghes.create') }}" class="text-xs text-blue-600 hover:underline">+ Novo GHE</a>
                </div>
                @forelse($setor->ghes as $ghe)
                <div class="px-4 py-3 border-b border-gray-50 last:border-0 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium">{{ $ghe->nome }}</p>
                        <p class="text-xs text-gray-500 font-mono">{{ $ghe->codigo }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $ghe->ativo ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $ghe->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                @empty
                <div class="px-4 py-8 text-center text-sm text-gray-400">Nenhum GHE cadastrado.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
