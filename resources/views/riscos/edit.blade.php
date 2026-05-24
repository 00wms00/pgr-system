<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Risco do Inventário</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('riscos.update', $risco) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('riscos._form')
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('riscos.show', $risco) }}" class="px-4 py-2 rounded-md border">Cancelar</a>
                        <x-primary-button>Salvar alterações</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
