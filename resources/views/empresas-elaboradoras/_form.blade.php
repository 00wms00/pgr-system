{{-- Formulário compartilhado entre create e edit --}}

{{-- ── Seção: Dados da Empresa ──────────────────────────────────────────── --}}
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4 pb-2 border-b">Identificação da Empresa</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Razão Social --}}
        <div class="md:col-span-2">
            <label for="razao_social" class="block text-sm font-medium text-gray-700 mb-1">
                Razão Social <span class="text-red-500">*</span>
            </label>
            <input type="text" id="razao_social" name="razao_social"
                   value="{{ old('razao_social', $empresa->razao_social ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('razao_social') border-red-400 @enderror"
                   required>
            @error('razao_social')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nome Fantasia --}}
        <div>
            <label for="nome_fantasia" class="block text-sm font-medium text-gray-700 mb-1">Nome Fantasia</label>
            <input type="text" id="nome_fantasia" name="nome_fantasia"
                   value="{{ old('nome_fantasia', $empresa->nome_fantasia ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- CNPJ --}}
        <div>
            <label for="cnpj" class="block text-sm font-medium text-gray-700 mb-1">
                CNPJ <span class="text-red-500">*</span>
            </label>
            <input type="text" id="cnpj" name="cnpj"
                   value="{{ old('cnpj', $empresa->cnpj ?? '') }}"
                   placeholder="00.000.000/0000-00"
                   maxlength="18"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cnpj') border-red-400 @enderror"
                   required>
            @error('cnpj')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CNAE --}}
        <div>
            <label for="cnae_principal" class="block text-sm font-medium text-gray-700 mb-1">CNAE Principal</label>
            <input type="text" id="cnae_principal" name="cnae_principal"
                   value="{{ old('cnae_principal', $empresa->cnae_principal ?? '') }}"
                   placeholder="Ex: 71.12-0-00"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="cnae_descricao" class="block text-sm font-medium text-gray-700 mb-1">Descrição do CNAE</label>
            <input type="text" id="cnae_descricao" name="cnae_descricao"
                   value="{{ old('cnae_descricao', $empresa->cnae_descricao ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>

{{-- ── Seção: Endereço ──────────────────────────────────────────────────── --}}
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4 pb-2 border-b">Endereço</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <label for="logradouro" class="block text-sm font-medium text-gray-700 mb-1">Logradouro</label>
            <input type="text" id="logradouro" name="logradouro"
                   value="{{ old('logradouro', $empresa->logradouro ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="numero" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input type="text" id="numero" name="numero"
                   value="{{ old('numero', $empresa->numero ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="complemento" class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
            <input type="text" id="complemento" name="complemento"
                   value="{{ old('complemento', $empresa->complemento ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
            <input type="text" id="bairro" name="bairro"
                   value="{{ old('bairro', $empresa->bairro ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
            <input type="text" id="cidade" name="cidade"
                   value="{{ old('cidade', $empresa->cidade ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="uf" class="block text-sm font-medium text-gray-700 mb-1">UF</label>
                <input type="text" id="uf" name="uf"
                       value="{{ old('uf', $empresa->uf ?? '') }}"
                       maxlength="2" placeholder="SP"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm uppercase focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="cep" class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                <input type="text" id="cep" name="cep"
                       value="{{ old('cep', $empresa->cep ?? '') }}"
                       placeholder="00000-000" maxlength="9"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </div>
</div>

{{-- ── Seção: Contato ───────────────────────────────────────────────────── --}}
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4 pb-2 border-b">Contato</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
            <input type="text" id="telefone" name="telefone"
                   value="{{ old('telefone', $empresa->telefone ?? '') }}"
                   placeholder="(00) 00000-0000"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $empresa->email ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="site" class="block text-sm font-medium text-gray-700 mb-1">Site</label>
            <input type="url" id="site" name="site"
                   value="{{ old('site', $empresa->site ?? '') }}"
                   placeholder="https://"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('site') border-red-400 @enderror">
            @error('site')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

{{-- ── Seção: Responsável Técnico ───────────────────────────────────────── --}}
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-700 mb-4 pb-2 border-b">Responsável Técnico pela Elaboração</h3>
    <p class="text-xs text-gray-400 mb-4">
        Profissional que assina o PGR — Engenheiro de Segurança, Técnico de Segurança, etc.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label for="responsavel_nome" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
            <input type="text" id="responsavel_nome" name="responsavel_nome"
                   value="{{ old('responsavel_nome', $empresa->responsavel_nome ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="responsavel_cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo / Habilitação</label>
            <input type="text" id="responsavel_cargo" name="responsavel_cargo"
                   value="{{ old('responsavel_cargo', $empresa->responsavel_cargo ?? '') }}"
                   placeholder="Ex: Engenheiro de Segurança do Trabalho"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="responsavel_formacao" class="block text-sm font-medium text-gray-700 mb-1">Formação</label>
            <input type="text" id="responsavel_formacao" name="responsavel_formacao"
                   value="{{ old('responsavel_formacao', $empresa->responsavel_formacao ?? '') }}"
                   placeholder="Ex: Engenheiro de Produção"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="responsavel_especializacao" class="block text-sm font-medium text-gray-700 mb-1">Especialização</label>
            <input type="text" id="responsavel_especializacao" name="responsavel_especializacao"
                   value="{{ old('responsavel_especializacao', $empresa->responsavel_especializacao ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Registro profissional --}}
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label for="responsavel_registro_tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo Reg.</label>
                <select id="responsavel_registro_tipo" name="responsavel_registro_tipo"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">—</option>
                    @foreach(['CREA','CRBio','CRM','CRFA','CRBM','MTE'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('responsavel_registro_tipo', $empresa->responsavel_registro_tipo ?? '') === $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label for="responsavel_registro_numero" class="block text-sm font-medium text-gray-700 mb-1">Número do Registro</label>
                <input type="text" id="responsavel_registro_numero" name="responsavel_registro_numero"
                       value="{{ old('responsavel_registro_numero', $empresa->responsavel_registro_numero ?? '') }}"
                       placeholder="Ex: 335731 - CE"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label for="responsavel_rnp" class="block text-sm font-medium text-gray-700 mb-1">RNP</label>
            <input type="text" id="responsavel_rnp" name="responsavel_rnp"
                   value="{{ old('responsavel_rnp', $empresa->responsavel_rnp ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="responsavel_cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
            <input type="text" id="responsavel_cpf" name="responsavel_cpf"
                   value="{{ old('responsavel_cpf', $empresa->responsavel_cpf ?? '') }}"
                   placeholder="000.000.000-00"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="responsavel_nit" class="block text-sm font-medium text-gray-700 mb-1">NIT / PIS</label>
            <input type="text" id="responsavel_nit" name="responsavel_nit"
                   value="{{ old('responsavel_nit', $empresa->responsavel_nit ?? '') }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>

{{-- ── Status ───────────────────────────────────────────────────────────── --}}
<div class="bg-white shadow-sm rounded-lg p-6 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" name="ativo" value="1"
               {{ old('ativo', $empresa->ativo ?? true) ? 'checked' : '' }}
               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <span class="text-sm font-medium text-gray-700">Empresa ativa</span>
    </label>
</div>

{{-- ── Botões ───────────────────────────────────────────────────────────── --}}
<div class="flex items-center justify-end gap-3">
    <a href="{{ route('empresas-elaboradoras.index') }}"
       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">
        Cancelar
    </a>
    <button type="submit"
            class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
        Salvar
    </button>
</div>
