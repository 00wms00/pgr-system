<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Avaliação de Risco</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">Risco</h3>
                <p class="mt-2 text-sm text-gray-600">{{ $avaliacao->riscoInventario->ghe->nome }} • {{ $avaliacao->riscoInventario->riscoTipo->categoria }} / {{ $avaliacao->riscoInventario->riscoTipo->nome }} • {{ $avaliacao->riscoInventario->agente }}</p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('avaliacoes.update', $avaliacao) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('avaliacoes._form')
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="px-4 py-2 rounded-md border">Cancelar</a>
                        <x-primary-button>Salvar alterações</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
