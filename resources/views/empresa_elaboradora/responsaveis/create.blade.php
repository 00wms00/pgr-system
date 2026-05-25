<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('empresa-elaboradora.index') }}" class="hover:underline">Empresas Elaboradoras</a>
            <span>/</span>
            <a href="{{ route('empresa-elaboradora.show', $empresaElaboradora) }}" class="hover:underline">
                {{ $empresaElaboradora->nomeExibicao() }}
            </a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Novo Responsável Técnico</span>
        </div>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <form method="POST"
              action="{{ route('empresa-elaboradora.responsaveis.store', $empresaElaboradora) }}"
              class="space-y-6">
            @csrf
            @include('empresa_elaboradora.responsaveis._form')
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Salvar
                </button>
                <a href="{{ route('empresa-elaboradora.show', $empresaElaboradora) }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
