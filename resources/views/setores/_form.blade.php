<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Unidade <span class="text-red-500">*</span>
    </label>
    <select name="unidade_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('unidade_id') border-red-400 @enderror">
        <option value="">Selecione...</option>
        @foreach($unidades as $unidade)
        <option value="{{ $unidade->id }}"
                {{ old('unidade_id', $setor->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
            {{ $unidade->nome }} ({{ $unidade->codigo }})
        </option>
        @endforeach
    </select>
    @error('unidade_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Nome <span class="text-red-500">*</span>
    </label>
    <input type="text" name="nome"
           value="{{ old('nome', $setor->nome ?? '') }}"
           placeholder="Ex: Produção, Manutenção"
           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-400 @enderror">
    @error('nome')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Descrição
        <span class="text-gray-400 font-normal text-xs">(opcional)</span>
    </label>
    <input type="text" name="descricao"
           value="{{ old('descricao', $setor->descricao ?? '') }}"
           placeholder="Breve descrição das atividades do setor"
           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>
