{{-- Seção: Identificação --}}
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Identificação</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Razão Social <span class="text-red-500">*</span></label>
            <input type="text" name="razao_social"
                   value="{{ old('razao_social', $empresaElaboradora->razao_social ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 @error('razao_social') border-red-500 @enderror"
                   required />
            @error('razao_social')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
            <input type="text" name="nome_fantasia"
                   value="{{ old('nome_fantasia', $empresaElaboradora->nome_fantasia ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">CNPJ <span class="text-red-500">*</span></label>
            <input type="text" name="cnpj"
                   value="{{ old('cnpj', $empresaElaboradora->cnpj ?? '') }}"
                   placeholder="00.000.000/0000-00"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm @error('cnpj') border-red-500 @enderror"
                   required />
            @error('cnpj')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Código CNAE</label>
            <input type="text" name="cnae_codigo"
                   value="{{ old('cnae_codigo', $empresaElaboradora->cnae_codigo ?? '') }}"
                   placeholder="71.12-0-00"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Descrição CNAE</label>
            <input type="text" name="cnae_descricao"
                   value="{{ old('cnae_descricao', $empresaElaboradora->cnae_descricao ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

    </div>
</div>

{{-- Seção: Endereço --}}
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Endereço</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Logradouro <span class="text-red-500">*</span></label>
            <input type="text" name="logradouro"
                   value="{{ old('logradouro', $empresaElaboradora->logradouro ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Número <span class="text-red-500">*</span></label>
            <input type="text" name="numero"
                   value="{{ old('numero', $empresaElaboradora->numero ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Complemento</label>
            <input type="text" name="complemento"
                   value="{{ old('complemento', $empresaElaboradora->complemento ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Bairro <span class="text-red-500">*</span></label>
            <input type="text" name="bairro"
                   value="{{ old('bairro', $empresaElaboradora->bairro ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">CEP <span class="text-red-500">*</span></label>
            <input type="text" name="cep"
                   value="{{ old('cep', $empresaElaboradora->cep ?? '') }}"
                   placeholder="00.000-000"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Cidade <span class="text-red-500">*</span></label>
            <input type="text" name="cidade"
                   value="{{ old('cidade', $empresaElaboradora->cidade ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">UF <span class="text-red-500">*</span></label>
            <select name="uf"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                    required>
                <option value="">--</option>
                @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                    <option value="{{ $uf }}" @selected(old('uf', $empresaElaboradora->uf ?? '') === $uf)>
                        {{ $uf }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
</div>

{{-- Seção: Contato --}}
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">Contato</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" name="telefone"
                   value="{{ old('telefone', $empresaElaboradora->telefone ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" name="email"
                   value="{{ old('email', $empresaElaboradora->email ?? '') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Site</label>
            <input type="url" name="site"
                   value="{{ old('site', $empresaElaboradora->site ?? '') }}"
                   placeholder="https://"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm" />
        </div>

    </div>
</div>
