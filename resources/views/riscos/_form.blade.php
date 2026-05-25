{{--
    Requer: $ghes (Ghe collection com setor.unidade),
            $tipos (RiscoTipo collection com agentesQuantitativos carregados)
    Opcional: $risco (para editar), $selectedGheId
--}}
@php
    $editandoGheId       = $risco->ghe_id ?? $selectedGheId ?? old('ghe_id');
    $editandoTipoId      = $risco->risco_tipo_id ?? old('risco_tipo_id');
    $editandoAgenteQId   = $risco->agente_quantitativo_id ?? old('agente_quantitativo_id');
    // Serializa tipos com agentes p/ Alpine
    $tiposJson = $tipos->map(fn($t) => [
        'id'      => $t->id,
        'agentes' => $t->agentesQuantitativos->map(fn($a) => [
            'id'           => $a->id,
            'nome'         => $a->nome,
            'unidade'      => $a->unidade_medida,
            'campo_label'  => $a->campo_label,
            'nivel_acao'   => $a->nivel_acao,
            'lt'           => $a->limite_tolerancia,
            'step'         => $a->input_step ?? '0.01',
        ])->values(),
    ])->keyBy('id');
@endphp

<div x-data="riscoForm({{ $tiposJson->toJson() }}, '{{ $editandoTipoId }}', '{{ $editandoAgenteQId }}')" style="display:grid;gap:20px">

    {{-- GHE --}}
    <div>
        <label for="ghe_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            GHE <span style="color:#ef4444">*</span>
        </label>
        <select id="ghe_id" name="ghe_id" required
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('ghe_id') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
            <option value="">Selecione um GHE...</option>
            @foreach($ghes as $ghe)
            <option value="{{ $ghe->id }}" @selected($editandoGheId == $ghe->id)>
                {{ $ghe->nome }} — {{ $ghe->setor->nome }} / {{ $ghe->setor->unidade->nome }}
            </option>
            @endforeach
        </select>
        @error('ghe_id')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Tipo de Risco (eSocial Tab. 24) --}}
    <div>
        <label for="risco_tipo_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Tipo de Risco <span style="color:#ef4444">*</span>
            <span style="font-size:.72rem;font-weight:400;color:#94a3b8">(Tabela 24 eSocial)</span>
        </label>
        <select id="risco_tipo_id" name="risco_tipo_id" required
            x-model="tipoId" @change="onTipoChange"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('risco_tipo_id') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
            <option value="">Selecione o tipo de risco...</option>
            @foreach($tipos->groupBy('grupo') as $grupo => $itens)
            <optgroup label="── {{ $grupo }}">
                @foreach($itens as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->codigo_esocial }} — {{ $tipo->nome }}</option>
                @endforeach
            </optgroup>
            @endforeach
        </select>
        @error('risco_tipo_id')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Agente / Perigo --}}
    <div>
        <label for="agente" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Agente / Perigo
        </label>
        <input type="text" id="agente" name="agente"
            value="{{ old('agente', $risco->agente ?? '') }}" maxlength="255"
            placeholder="Ex.: Ruído contínuo, Agente químico X, Levantamento de peso..."
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('agente') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
        @error('agente')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Fonte Geradora --}}
    <div>
        <label for="fonte_geradora" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Fonte Geradora <span style="color:#ef4444">*</span>
        </label>
        <textarea id="fonte_geradora" name="fonte_geradora" rows="2" maxlength="500"
            placeholder="Descreva o equipamento, processo ou situação que gera o risco..."
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('fonte_geradora') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('fonte_geradora', $risco->fonte_geradora ?? '') }}</textarea>
        @error('fonte_geradora')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Via de Absorção / Técnica --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div>
            <label for="via_absorcao" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Via de Absorção</label>
            <input type="text" id="via_absorcao" name="via_absorcao"
                value="{{ old('via_absorcao', $risco->via_absorcao ?? '') }}" maxlength="255"
                placeholder="Respiratória, Cutânea, Oral..."
                style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b">
        </div>
        <div>
            <label for="tecnica_utilizada" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Técnica Utilizada</label>
            <input type="text" id="tecnica_utilizada" name="tecnica_utilizada"
                value="{{ old('tecnica_utilizada', $risco->tecnica_utilizada ?? '') }}" maxlength="255"
                placeholder="Qualitativo, Dosimetria, NHO-01..."
                style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b">
        </div>
    </div>

    {{-- Possíveis Lesões / Danos à Saúde --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div>
            <label for="possiveis_lesoes" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Possíveis Lesões</label>
            <textarea id="possiveis_lesoes" name="possiveis_lesoes" rows="3" maxlength="1000"
                placeholder="Surdez, dermatite, contusão..."
                style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('possiveis_lesoes', $risco->possiveis_lesoes ?? '') }}</textarea>
        </div>
        <div>
            <label for="danos_saude" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Danos à Saúde</label>
            <textarea id="danos_saude" name="danos_saude" rows="3" maxlength="1000"
                placeholder="PAIR, intoxicação crônica, LER..."
                style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('danos_saude', $risco->danos_saude ?? '') }}</textarea>
        </div>
    </div>

    {{-- Medidas Existentes --}}
    <div>
        <label for="medidas_existentes" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Medidas de Controle Existentes</label>
        <textarea id="medidas_existentes" name="medidas_existentes" rows="2" maxlength="1000"
            placeholder="EPIs, EPCs, procedimentos, treinamentos já implementados..."
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('medidas_existentes', $risco->medidas_existentes ?? '') }}</textarea>
    </div>

    {{-- Seção: Medição Quantitativa (visível só se o tipo tiver agentes quantitativos) --}}
    <div x-show="agentes.length > 0" x-transition
        style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:16px;display:grid;gap:16px">

        <h4 style="font-size:.82rem;font-weight:700;color:#0369a1;margin:0;display:flex;align-items:center;gap:6px">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Medição Quantitativa
            <span style="font-size:.72rem;font-weight:400;color:#0284c7">(opcional — para riscos com avaliação instrumental)</span>
        </h4>

        {{-- Agente Quantitativo --}}
        <div>
            <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Agente Quantitativo</label>
            <select name="agente_quantitativo_id" x-model="agenteId" @change="onAgenteChange"
                style="width:100%;padding:8px 12px;border:1px solid #bae6fd;border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
                <option value="">Selecione o agente...</option>
                <template x-for="a in agentes" :key="a.id">
                    <option :value="a.id" x-text="a.nome + ' (' + a.unidade + ')'" :selected="String(a.id) === String(agenteId)"></option>
                </template>
            </select>
        </div>

        {{-- Valor Medido --}}
        <div x-show="agenteAtual" x-transition style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div>
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
                    <span x-text="agenteAtual ? agenteAtual.campo_label : 'Valor Medido'"></span>
                    <span x-show="agenteAtual" style="color:#94a3b8;font-weight:400" x-text="agenteAtual ? '(' + agenteAtual.unidade + ')' : ''"></span>
                </label>
                <input type="number" name="valor_medido"
                    :step="agenteAtual ? agenteAtual.step : '0.01'"
                    min="0"
                    value="{{ old('valor_medido', $risco->valor_medido ?? '') }}"
                    style="width:100%;padding:8px 12px;border:1px solid #bae6fd;border-radius:7px;font-size:.85rem;color:#1e293b">
            </div>
            <div x-show="agenteAtual" style="display:flex;flex-direction:column;gap:4px;justify-content:flex-end;padding-bottom:8px">
                <template x-if="agenteAtual && agenteAtual.nivel_acao">
                    <p style="font-size:.75rem;color:#0369a1;margin:0">
                        Nível de Ação: <strong x-text="agenteAtual.nivel_acao + ' ' + agenteAtual.unidade"></strong>
                    </p>
                </template>
                <template x-if="agenteAtual && agenteAtual.lt">
                    <p style="font-size:.75rem;color:#dc2626;margin:0">
                        Limite de Tolerância: <strong x-text="agenteAtual.lt + ' ' + agenteAtual.unidade"></strong>
                    </p>
                </template>
            </div>
        </div>

        {{-- Classificação manual (se não houver medição automática) --}}
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
            <div>
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Probabilidade (1-5)</label>
                <input type="number" name="probabilidade_calculada" min="1" max="5" step="1"
                    value="{{ old('probabilidade_calculada', $risco->probabilidade_calculada ?? '') }}"
                    style="width:100%;padding:8px 12px;border:1px solid #bae6fd;border-radius:7px;font-size:.85rem;color:#1e293b">
            </div>
            <div>
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Severidade (1-5)</label>
                <input type="number" name="severidade_calculada" min="1" max="5" step="1"
                    value="{{ old('severidade_calculada', $risco->severidade_calculada ?? '') }}"
                    style="width:100%;padding:8px 12px;border:1px solid #bae6fd;border-radius:7px;font-size:.85rem;color:#1e293b">
            </div>
            <div>
                <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Classificação</label>
                <select name="classificacao_calculada"
                    style="width:100%;padding:8px 12px;border:1px solid #bae6fd;border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
                    <option value="">—</option>
                    @foreach(['baixo'=>'Baixo','moderado'=>'Moderado','alto'=>'Alto','critico'=>'Crítico'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('classificacao_calculada', $risco->classificacao_calculada ?? '') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Observações --}}
    <div>
        <label for="observacoes" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="2" maxlength="1000"
            placeholder="Informações complementares relevantes..."
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('observacoes', $risco->observacoes ?? '') }}</textarea>
    </div>

</div>

@push('scripts')
<script>
function riscoForm(tiposMap, tipoIdInicial, agenteIdInicial) {
    return {
        tipoId:      String(tipoIdInicial || ''),
        agenteId:    String(agenteIdInicial || ''),
        tiposMap:    tiposMap,
        get agentes() {
            return (this.tiposMap[this.tipoId] || {agentes:[]}).agentes;
        },
        get agenteAtual() {
            if (!this.agenteId) return null;
            return this.agentes.find(a => String(a.id) === String(this.agenteId)) || null;
        },
        onTipoChange() {
            this.agenteId = '';
        },
        onAgenteChange() {
            // futuro: auto-preencher campos com base na faixa
        }
    };
}
</script>
@endpush
