<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('empresas-elaboradoras.index') }}" class="hover:text-gray-700">Empresas Elaboradoras</a>
                <span>/</span>
                <span class="text-gray-800 font-medium">{{ $empresa->razao_social }}</span>
            </div>
            @can('update', $empresa)
                <a href="{{ route('empresas-elaboradoras.edit', $empresa) }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                    Editar
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-300 text-green-800 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cabeçalho da empresa --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $empresa->razao_social }}</h3>
                        @if($empresa->nome_fantasia)
                            <p class="text-sm text-gray-500">{{ $empresa->nome_fantasia }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-1">CNPJ: <span class="font-mono">{{ $empresa->cnpj_formatado }}</span></p>
                    </div>
                    @if($empresa->ativo)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ativo</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Inativo</span>
                    @endif
                </div>

                @if($empresa->cnae_principal)
                    <p class="text-sm text-gray-500 mt-2">
                        CNAE: {{ $empresa->cnae_principal }}
                        @if($empresa->cnae_descricao) — {{ $empresa->cnae_descricao }} @endif
                    </p>
                @endif
            </div>

            {{-- Grid: Endereço + Contato --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Endereço</h4>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $empresa->endereco_completo ?: '—' }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Contato</h4>
                    <dl class="space-y-1 text-sm">
                        @if($empresa->telefone)
                            <div class="flex gap-2"><dt class="text-gray-400 w-20">Telefone</dt><dd class="text-gray-700">{{ $empresa->telefone }}</dd></div>
                        @endif
                        @if($empresa->email)
                            <div class="flex gap-2"><dt class="text-gray-400 w-20">E-mail</dt><dd><a href="mailto:{{ $empresa->email }}" class="text-blue-600 hover:underline">{{ $empresa->email }}</a></dd></div>
                        @endif
                        @if($empresa->site)
                            <div class="flex gap-2"><dt class="text-gray-400 w-20">Site</dt><dd><a href="{{ $empresa->site }}" target="_blank" class="text-blue-600 hover:underline">{{ $empresa->site }}</a></dd></div>
                        @endif
                        @if(!$empresa->telefone && !$empresa->email && !$empresa->site)
                            <p class="text-gray-400">—</p>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Responsável Técnico --}}
            @if($empresa->responsavel_nome)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Responsável Técnico pela Elaboração</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm">
                    <div><span class="text-gray-400">Nome:</span> <span class="font-medium text-gray-800 ml-1">{{ $empresa->responsavel_nome }}</span></div>
                    @if($empresa->responsavel_cargo)
                        <div><span class="text-gray-400">Cargo:</span> <span class="text-gray-700 ml-1">{{ $empresa->responsavel_cargo }}</span></div>
                    @endif
                    @if($empresa->responsavel_formacao)
                        <div><span class="text-gray-400">Formação:</span> <span class="text-gray-700 ml-1">{{ $empresa->responsavel_formacao }}</span></div>
                    @endif
                    @if($empresa->responsavel_especializacao)
                        <div><span class="text-gray-400">Especialização:</span> <span class="text-gray-700 ml-1">{{ $empresa->responsavel_especializacao }}</span></div>
                    @endif
                    @if($empresa->responsavel_registro_tipo || $empresa->responsavel_registro_numero)
                        <div>
                            <span class="text-gray-400">{{ $empresa->responsavel_registro_tipo ?? 'Registro' }}:</span>
                            <span class="font-mono text-gray-700 ml-1">{{ $empresa->responsavel_registro_numero }}</span>
                        </div>
                    @endif
                    @if($empresa->responsavel_rnp)
                        <div><span class="text-gray-400">RNP:</span> <span class="font-mono text-gray-700 ml-1">{{ $empresa->responsavel_rnp }}</span></div>
                    @endif
                    @if($empresa->responsavel_cpf)
                        <div><span class="text-gray-400">CPF:</span> <span class="font-mono text-gray-700 ml-1">{{ $empresa->responsavel_cpf }}</span></div>
                    @endif
                    @if($empresa->responsavel_nit)
                        <div><span class="text-gray-400">NIT/PIS:</span> <span class="font-mono text-gray-700 ml-1">{{ $empresa->responsavel_nit }}</span></div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
