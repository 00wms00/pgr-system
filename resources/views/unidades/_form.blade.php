<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Código <span class="text-red-500">*</span>
            <span class="text-gray-400 font-normal text-xs ml-1">(ex: SP-01)</span>
        </label>
        <input type="text" name="codigo"
               value="{{ old('codigo', $unidade->codigo ?? '') }}"
               placeholder="SP-01"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 @error('codigo') border-red-400 @enderror">
        @error('codigo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nome <span class="text-red-500">*</span>
        </label>
        <input type="text" name="nome"
               value="{{ old('nome', $unidade->nome ?? '') }}"
               placeholder="Planta Industrial SP"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-400 @enderror">
        @error('nome')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Endereço
        <span class="text-gray-400 font-normal text-xs">(opcional)</span>
    </label>
    <input type="text" name="endereco"
           value="{{ old('endereco', $unidade->endereco ?? '') }}"
           placeholder="Rua, número, bairro — Cidade, UF"
           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    @error('endereco')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
