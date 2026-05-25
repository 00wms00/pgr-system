<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Empresas Elaboradoras
            </h2>
            @can('create', App\Models\EmpresaElaboradora::class)
                <a href="{{ route('empresas-elaboradoras.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    + Nova Empresa
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-300 text-green-800 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cidade / UF</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($empresas as $empresa)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 text-sm">{{ $empresa->razao_social }}</div>
                                    @if($empresa->nome_fantasia)
                                        <div class="text-xs text-gray-500">{{ $empresa->nome_fantasia }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                    {{ $empresa->cnpj_formatado }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $empresa->responsavel_nome ?? '—' }}
                                    @if($empresa->responsavel_cargo)
                                        <div class="text-xs text-gray-400">{{ $empresa->responsavel_cargo }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                    {{ implode(' / ', array_filter([$empresa->cidade, $empresa->uf])) ?: '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($empresa->ativo)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="{{ route('empresas-elaboradoras.show', $empresa) }}" class="text-blue-600 hover:underline mr-3">Ver</a>
                                    @can('update', $empresa)
                                        <a href="{{ route('empresas-elaboradoras.edit', $empresa) }}" class="text-indigo-600 hover:underline mr-3">Editar</a>
                                    @endcan
                                    @can('delete', $empresa)
                                        <form action="{{ route('empresas-elaboradoras.destroy', $empresa) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Remover esta empresa elaboradora?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Remover</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Nenhuma empresa elaboradora cadastrada ainda.
                                    @can('create', App\Models\EmpresaElaboradora::class)
                                        <a href="{{ route('empresas-elaboradoras.create') }}" class="text-blue-600 hover:underline ml-1">Cadastrar agora</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $empresas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
