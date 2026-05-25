<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('avaliacoes.show', $plano->avaliacao_risco_id) }}" class="text-gray-400 hover:text-gray-600">&larr;</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Plano de A&ccedil;&atilde;o
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('planos.update', $plano) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="avaliacao_risco_id" value="{{ $plano->avaliacao_risco_id }}">
                    @include('planos._form', ['plano' => $plano])
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <a href="{{ route('avaliacoes.show', $plano->avaliacao_risco_id) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                            Atualizar Plano
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
