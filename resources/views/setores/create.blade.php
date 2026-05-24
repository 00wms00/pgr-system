<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Novo Setor</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form action="{{ route('setores.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @include('setores._form')
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                            Salvar Setor
                        </button>
                        <a href="{{ route('setores.index') }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
