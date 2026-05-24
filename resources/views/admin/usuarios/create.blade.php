<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Novo Usuário</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf
                    @include('admin.usuarios._form')
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.usuarios.index') }}" class="px-4 py-2 rounded-md border">Cancelar</a>
                        <x-primary-button>Criar usuário</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
