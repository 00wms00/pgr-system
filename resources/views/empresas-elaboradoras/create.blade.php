<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('empresas-elaboradoras.index') }}" class="hover:text-gray-700">Empresas Elaboradoras</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Nova empresa</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('empresas-elaboradoras.store') }}" method="POST" novalidate>
                @csrf
                @include('empresas-elaboradoras._form')
            </form>
        </div>
    </div>
</x-app-layout>
