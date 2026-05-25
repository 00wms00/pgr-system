{{-- Requer: $risco (RiscoInventario). Opcional: $avaliacao (para editar) --}}

<div style="display:grid;gap:20px">

    {{-- Matriz visual P x S --}}
    <div x-data="matrizRisco({{ old('probabilidade', $avaliacao->probabilidade ?? $defaults['probabilidade'] ?? '') }}, {{ old('severidade', $avaliacao->severidade ?? $defaults['severidade'] ?? '') }})">

        <p style="font-size:.82rem;font-weight:600;color:#374151;margin:0 0 12px">Probabilidade &times; Severidade <span style="color:#ef4444">*</span></p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:16px">
            {{-- Probabilidade --}}
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                    <label style="font-size:.8rem;font-weight:600;color:#374151">Probabilidade</label>
                    <span x-text="probLabel" style="font-size:.78rem;font-weight:600;color:#3b82f6"></span>
                </div>
                <input type="range" name="probabilidade" min="1" max="5" step="1"
                    x-model="prob" @input="calcular"
                    style="width:100%;accent-color:#3b82f6">
                <div style="display:flex;justify-content:space-between;font-size:.7rem;color:#94a3b8;margin-top:2px">
                    <span>1 &ndash; Muito Baixa</span><span>5 &ndash; Muito Alta</span>
                </div>
            </div>
            {{-- Severidade --}}
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                    <label style="font-size:.8rem;font-weight:600;color:#374151">Severidade</label>
                    <span x-text="sevLabel" style="font-size:.78rem;font-weight:600;color:#3b82f6"></span>
                </div>
                <input type="range" name="severidade" min="1" max="5" step="1"
                    x-model="sev" @input="calcular"
                    style="width:100%;accent-color:#3b82f6">
                <div style="display:flex;justify-content:space-between;font-size:.7rem;color:#94a3b8;margin-top:2px">
                    <span>1 &ndash; Desprezível</span><span>5 &ndash; Catástrofe</span>
                </div>
            </div>
        </div>

        {{-- Resultado calculado --}}
        <div :style="'background:' + resultadoBg + ';border:1px solid ' + resultadoBorder"
            style="border-radius:8px;padding:14px 18px;display:flex;align-items:center;gap:16px;transition:background .25s">
            <div style="text-align:center;min-width:64px">
                <div :style="'color:' + resultadoColor"
                    style="font-size:2rem;font-weight:900;line-height:1" x-text="nivel"></div>
                <div :style="'color:' + resultadoColor"
                    style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em" x-text="classificacaoLabel"></div>
            </div>
            <div>
                <p :style="'color:' + resultadoColor" style="font-size:.85rem;font-weight:700;margin:0 0 2px"
                    x-text="'Nível de Risco: ' + nivel + ' (P' + prob + ' × S' + sev + ')'">
                </p>
                <p :style="'color:' + resultadoColor" style="font-size:.78rem;margin:0;opacity:.8"
                    x-text="descricaoRisco">
                </p>
            </div>
        </div>

    </div>

    {{-- Data da Avaliação --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div>
            <label for="data_avaliacao" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
                Data da Avaliação <span style="color:#ef4444">*</span>
            </label>
            <input type="date" id="data_avaliacao" name="data_avaliacao"
                value="{{ old('data_avaliacao', isset($avaliacao) ? $avaliacao->data_avaliacao->format('Y-m-d') : now()->format('Y-m-d')) }}"
                max="{{ now()->format('Y-m-d') }}"
                style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('data_avaliacao') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
            @error('data_avaliacao')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="metodologia" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Metodologia</label>
            <select id="metodologia" name="metodologia"
                style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff">
                <option value="">Não informado</option>
                <option value="qualitativo"     @selected(old('metodologia', $avaliacao->metodologia ?? '') === 'qualitativo')>Qualitativo</option>
                <option value="semi_quantitativo" @selected(old('metodologia', $avaliacao->metodologia ?? '') === 'semi_quantitativo')>Semi-quantitativo</option>
                <option value="quantitativo"   @selected(old('metodologia', $avaliacao->metodologia ?? '') === 'quantitativo')>Quantitativo</option>
            </select>
        </div>
    </div>

    {{-- Justificativa --}}
    <div>
        <label for="justificativa" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">Justificativa / Contexto</label>
        <textarea id="justificativa" name="justificativa" rows="3" maxlength="2000"
            placeholder="Descreva as condições avaliadas, critérios adotados, observações relevantes..."
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('justificativa', $avaliacao->justificativa ?? '') }}</textarea>
    </div>

</div>

@push('scripts')
<script>
function matrizRisco(probInicial, sevInicial) {
    const PROB_LABELS = { 1:'Muito Baixa', 2:'Baixa', 3:'Média', 4:'Alta', 5:'Muito Alta' };
    const SEV_LABELS  = { 1:'Desprezível', 2:'Marginal', 3:'Crítica', 4:'Catastrófica', 5:'Catástrofe' };
    const DESCRICOES  = {
        baixo:    'Risco aceitável. Monitorar periódicamente.',
        moderado: 'Requer controles. Plano de ação recomendado.',
        alto:     'Controles imediatos necessários. Ação prioritária.',
        critico:  'Risco inaceitável. Intervenção imediata obrigatória.',
    };
    return {
        prob: probInicial || 3,
        sev:  sevInicial  || 3,
        get nivel()             { return this.prob * this.sev; },
        get classificacao()     {
            const n = this.nivel;
            if (n <= 4)  return 'baixo';
            if (n <= 9)  return 'moderado';
            if (n <= 16) return 'alto';
            return 'critico';
        },
        get classificacaoLabel(){ return { baixo:'Baixo', moderado:'Moderado', alto:'Alto', critico:'Crítico' }[this.classificacao]; },
        get descricaoRisco()    { return DESCRICOES[this.classificacao]; },
        get probLabel()         { return PROB_LABELS[this.prob] || this.prob; },
        get sevLabel()          { return SEV_LABELS[this.sev]   || this.sev; },
        get resultadoBg()       { return { baixo:'#f0fdf4', moderado:'#fefce8', alto:'#fff7ed', critico:'#fef2f2' }[this.classificacao]; },
        get resultadoBorder()   { return { baixo:'#bbf7d0', moderado:'#fef08a', alto:'#fed7aa', critico:'#fecaca' }[this.classificacao]; },
        get resultadoColor()    { return { baixo:'#166534', moderado:'#854d0e', alto:'#9a3412', critico:'#991b1b' }[this.classificacao]; },
        calcular() {},
    };
}
</script>
@endpush
