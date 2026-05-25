<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Empresas Elaboradoras
            </h2>
            <a href="{{ route('empresa-elaboradora.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                + Nova Elaboradora
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Cidade/UF</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Responsáveis</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($elaboradoras as $elaboradora)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $elaboradora->razao_social }}</div>
                                @if($elaboradora->nome_fantasia)
                                    <div class="text-xs text-gray-500">{{ $elaboradora->nome_fantasia }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $elaboradora->cnpj }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $elaboradora->cidade }}/{{ $elaboradora->uf }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $elaboradora->responsaveis_count > 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $elaboradora->responsaveis_count }}
                                    {{ $elaboradora->responsaveis_count === 1 ? 'responsável' : 'responsáveis' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $elaboradora->ativo ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $elaboradora->ativo ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('empresa-elaboradora.show', $elaboradora) }}"
                                   class="text-indigo-600 hover:underline">Ver</a>
                                <a href="{{ route('empresa-elaboradora.edit', $elaboradora) }}"
                                   class="text-gray-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p>Nenhuma empresa elaboradora cadastrada.</p>
                                    <a href="{{ route('empresa-elaboradora.create') }}"
                                       class="text-indigo-600 hover:underline text-sm">Cadastrar agora</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($elaboradoras->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $elaboradoras->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
