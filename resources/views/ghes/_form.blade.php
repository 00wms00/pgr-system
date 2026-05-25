{{--
    Requer: $unidades (Unidade collection, cada uma com ->setores carregados)
    Opcional: $ghe (para editar, com ->setor_id preenchido)
--}}
<div x-data="gheForm({{ json_encode($unidades->map(fn($u) => [
    'id'     => $u->id,
    'nome'   => $u->nome,
    'codigo' => $u->codigo,
    'setores'=> $u->setores->map(fn($s) => ['id'=>$s->id,'nome'=>$s->nome])->values(),
])->values()) }}, {{ $ghe->setor->unidade_id ?? old('unidade_id', 'null') }}, {{ $ghe->setor_id ?? old('setor_id', 'null') }})" style="display:grid;gap:20px">

    {{-- Select Unidade --}}
    <div>
        <label for="unidade_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Unidade <span style="color:#ef4444">*</span>
        </label>
        <select id="unidade_id" x-model="unidadeId" @change="onUnidadeChange"
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff;outline:none">
            <option value="">Selecione uma unidade...</option>
            <template x-for="u in unidades" :key="u.id">
                <option :value="u.id" x-text="u.nome + (u.codigo ? ' (' + u.codigo + ')' : '')"></option>
            </template>
        </select>
    </div>

    {{-- Select Setor (filtrado pela Unidade) --}}
    <div>
        <label for="setor_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Setor <span style="color:#ef4444">*</span>
        </label>
        <select id="setor_id" name="setor_id" x-model="setorId"
            :disabled="!unidadeId"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('setor_id') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff;outline:none">
            <option value="">Selecione um setor...</option>
            <template x-for="s in setoresFiltrados" :key="s.id">
                <option :value="s.id" x-text="s.nome"></option>
            </template>
        </select>
        @error('setor_id')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Código --}}
    <div>
        <label for="codigo" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Código <span style="color:#94a3b8;font-weight:400">(opcional)</span>
        </label>
        <input type="text" id="codigo" name="codigo"
            value="{{ old('codigo', $ghe->codigo ?? '') }}"
            placeholder="Ex.: GHE-01" maxlength="20"
            style="width:100%;max-width:200px;padding:8px 12px;border:1px solid {{ $errors->has('codigo') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('codigo')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nome --}}
    <div>
        <label for="nome" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Nome do GHE <span style="color:#ef4444">*</span>
        </label>
        <input type="text" id="nome" name="nome"
            value="{{ old('nome', $ghe->nome ?? '') }}"
            placeholder="Ex.: Operadores de Máquinas" maxlength="150" autofocus
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('nome') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('nome')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Descrição das Atividades --}}
    <div>
        <label for="descricao_atividades" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Descrição das Atividades <span style="color:#94a3b8;font-weight:400">(opcional)</span>
        </label>
        <textarea id="descricao_atividades" name="descricao_atividades" rows="4"
            placeholder="Descreva as atividades realizadas por este grupo de trabalhadores..."
            maxlength="1000"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('descricao_atividades') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none;resize:vertical">{{ old('descricao_atividades', $ghe->descricao_atividades ?? '') }}</textarea>
        @error('descricao_atividades')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Ativo --}}
    <div style="display:flex;align-items:center;gap:10px">
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" id="ativo" name="ativo" value="1"
            {{ old('ativo', $ghe->ativo ?? true) ? 'checked' : '' }}
            style="width:16px;height:16px;accent-color:#3b82f6;cursor:pointer">
        <label for="ativo" style="font-size:.85rem;font-weight:600;color:#374151;cursor:pointer">GHE Ativo</label>
        <span style="font-size:.75rem;color:#94a3b8">(GHEs inativos não aparecem no inventário de riscos)</span>
    </div>

</div>

@push('scripts')
<script>
function gheForm(unidades, unidadeIdInicial, setorIdInicial) {
    return {
        unidades: unidades,
        unidadeId: unidadeIdInicial ? String(unidadeIdInicial) : '',
        setorId: setorIdInicial ? String(setorIdInicial) : '',
        get setoresFiltrados() {
            if (!this.unidadeId) return [];
            const u = this.unidades.find(u => String(u.id) === String(this.unidadeId));
            return u ? u.setores : [];
        },
        onUnidadeChange() {
            // Limpa setor ao trocar unidade (exceto na carga inicial)
            this.setorId = '';
        }
    };
}
</script>
@endpush
