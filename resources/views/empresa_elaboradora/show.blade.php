<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('empresa-elaboradora.index') }}" class="hover:underline">Empresas Elaboradoras</a>
                <span>/</span>
                <span class="text-gray-900 font-medium">{{ $empresaElaboradora->nomeExibicao() }}</span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('empresa-elaboradora.edit', $empresaElaboradora) }}"
                   class="px-4 py-2 border border-gray-300 text-sm text-gray-700 rounded-md hover:bg-gray-50">Editar</a>
                <a href="{{ route('empresa-elaboradora.responsaveis.create', $empresaElaboradora) }}"
                   class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">+ Responsável Técnico</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Dados da Empresa Elaboradora --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Dados da Empresa Elaboradora</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Razão Social</dt>
                    <dd class="text-gray-900 font-medium">{{ $empresaElaboradora->razao_social }}</dd>
                </div>
                @if($empresaElaboradora->nome_fantasia)
                <div>
                    <dt class="text-gray-500">Nome Fantasia</dt>
                    <dd class="text-gray-900">{{ $empresaElaboradora->nome_fantasia }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-gray-500">CNPJ</dt>
                    <dd class="text-gray-900 font-mono">{{ $empresaElaboradora->cnpj }}</dd>
                </div>
                @if($empresaElaboradora->cnae_codigo)
                <div>
                    <dt class="text-gray-500">CNAE</dt>
                    <dd class="text-gray-900">{{ $empresaElaboradora->cnae_codigo }} — {{ $empresaElaboradora->cnae_descricao }}</dd>
                </div>
                @endif
                <div class="md:col-span-2">
                    <dt class="text-gray-500">Endereço</dt>
                    <dd class="text-gray-900">{{ $empresaElaboradora->enderecoFormatado() }}</dd>
                </div>
                @if($empresaElaboradora->telefone)
                <div>
                    <dt class="text-gray-500">Telefone</dt>
                    <dd class="text-gray-900">{{ $empresaElaboradora->telefone }}</dd>
                </div>
                @endif
                @if($empresaElaboradora->email)
                <div>
                    <dt class="text-gray-500">E-mail</dt>
                    <dd class="text-gray-900">{{ $empresaElaboradora->email }}</dd>
                </div>
                @endif
                @if($empresaElaboradora->site)
                <div>
                    <dt class="text-gray-500">Site</dt>
                    <dd><a href="{{ $empresaElaboradora->site }}" target="_blank" class="text-indigo-600 hover:underline">{{ $empresaElaboradora->site }}</a></dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- Responsáveis Técnicos --}}
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h3 class="text-base font-semibold text-gray-900">Responsáveis Técnicos</h3>
                <a href="{{ route('empresa-elaboradora.responsaveis.create', $empresaElaboradora) }}"
                   class="text-sm text-indigo-600 hover:underline">+ Adicionar</a>
            </div>

            @forelse($empresaElaboradora->responsaveis as $responsavel)
                <div class="border border-gray-200 rounded-lg p-4 mb-3 last:mb-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $responsavel->nome }}</p>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $responsavel->formacao }}
                                @if($responsavel->especializacao)
                                    — {{ $responsavel->especializacao }}
                                @endif
                            </p>
                            <div class="flex gap-4 mt-2 text-xs text-gray-500">
                                <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">
                                    {{ $responsavel->registroFormatado() }}
                                </span>
                                @if($responsavel->numero_art_rrt)
                                    <span>ART/RRT: {{ $responsavel->numero_art_rrt }}
                                        @if($responsavel->data_art_rrt)
                                            ({{ $responsavel->data_art_rrt->format('d/m/Y') }})
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2 text-sm">
                            <a href="{{ route('empresa-elaboradora.responsaveis.edit', [$empresaElaboradora, $responsavel]) }}"
                               class="text-gray-600 hover:underline">Editar</a>
                            <form method="POST"
                                  action="{{ route('empresa-elaboradora.responsaveis.destroy', [$empresaElaboradora, $responsavel]) }}"
                                  onsubmit="return confirm('Remover este responsável?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Remover</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 text-sm">
                    <p>Nenhum responsável técnico cadastrado.</p>
                    <a href="{{ route('empresa-elaboradora.responsaveis.create', $empresaElaboradora) }}"
                       class="text-indigo-600 hover:underline mt-1 inline-block">Adicionar responsável</a>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
