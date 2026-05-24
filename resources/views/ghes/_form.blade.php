{{-- Unidade → Setor (cascata via Alpine) --}}
<div x-data="{
    unidades: {{ $unidades->map(fn($u) => ['id' => $u->id, 'nome' => $u->nome, 'setores' => $u->setores->map(fn($s) => ['id' => $s->id, 'nome' => $s->nome])])->toJson() }},
    unidadeId: '{{ old('unidade_id', $ghe->setor->unidade_id ?? '') }}',
    setorId: '{{ old('setor_id', $ghe->setor_id ?? '') }}',
    get setoresFiltrados() {
        const u = this.unidades.find(u => u.id == this.unidadeId);
        return u ? u.setores : [];
    }
}" class="space-y-4">

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Unidade <span class="text-red-500">*</span>
            </label>
            <select x-model="unidadeId"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Selecione...</option>
                <template x-for="u in unidades" :key="u.id">
                    <option :value="u.id" x-text="u.nome"></option>
                </template>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Setor <span class="text-red-500">*</span>
            </label>
            <select name="setor_id" x-model="setorId"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('setor_id') border-red-400 @enderror">
                <option value="">Selecione a unidade primeiro</option>
                <template x-for="s in setoresFiltrados" :key="s.id">
                    <option :value="s.id" x-text="s.nome"></option>
                </template>
            </select>
            @error('setor_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Código <span class="text-red-500">*</span>
            </label>
            <input type="text" name="codigo"
                   value="{{ old('codigo', $ghe->codigo ?? '') }}"
                   placeholder="GHE-01"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 @error('codigo') border-red-400 @enderror">
            @error('codigo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nome <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nome"
                   value="{{ old('nome', $ghe->nome ?? '') }}"
                   placeholder="Ex: Operadores de Máquinas"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nome') border-red-400 @enderror">
            @error('nome')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Descrição das Atividades
            <span class="text-gray-400 font-normal text-xs">(opcional)</span>
        </label>
        <textarea name="descricao_atividades" rows="3"
                  placeholder="Descreva as principais atividades realizadas por este grupo..."
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descricao_atividades', $ghe->descricao_atividades ?? '') }}</textarea>
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" name="ativo" id="ativo" value="1"
               {{ old('ativo', $ghe->ativo ?? true) ? 'checked' : '' }}
               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <label for="ativo" class="text-sm text-gray-700">GHE ativo</label>
    </div>

</div>
