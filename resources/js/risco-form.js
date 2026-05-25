/**
 * Alpine.js component: riscoForm()
 * Gerencia o formulário de inventário de riscos com cálculo
 * automático via Matriz de Risco Inteligente (Especificação 1).
 *
 * Uso no Blade:
 *   <form x-data="riscoForm({ riscoTipoId: {{ old('risco_tipo_id', '') }} })">
 */
window.riscoForm = function (opts = {}) {
    return {
        // --- estado ---
        riscoTipoId: opts.riscoTipoId ?? '',
        agenteId: opts.agenteId ?? '',
        valorMedido: opts.valorMedido ?? '',
        agentes: [],
        agenteAtual: null,
        calculando: false,

        riscoCalc: {
            classificacao: null,
            classificacao_label: null,
            probabilidade: null,
            severidade: null,
            nivel: null,
            gatilho: false,
            descricao_gatilho: null,
            nivel_acao: null,
            limite_tolerancia: null,
            norma: '',
            unidade: '',
            bgColor: '#f9fafb',
            borderColor: '#e5e7eb',
            textColor: '#374151',
            icon: 'ℹ️',
        },

        // --- ciclo de vida ---
        init() {
            if (this.riscoTipoId) this.carregarAgentes(this.riscoTipoId);
            this.$watch('riscoTipoId', v => {
                this.agenteId = '';
                this.agenteAtual = null;
                this.valorMedido = '';
                this.resetCalc();
                if (v) this.carregarAgentes(v);
                else this.agentes = [];
            });
        },

        // --- métodos ---
        async carregarAgentes(riscoTipoId) {
            if (!riscoTipoId) return;
            const res = await fetch(`/agentes/por-risco-tipo/${riscoTipoId}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            this.agentes = res.ok ? await res.json() : [];
        },

        onAgenteChange() {
            this.agenteAtual = this.agentes.find(a => a.id == this.agenteId) ?? null;
            this.valorMedido = '';
            this.resetCalc();
        },

        async calcular() {
            const valor = parseFloat(this.valorMedido);
            if (!this.agenteId || isNaN(valor)) return;
            this.calculando = true;
            try {
                const res = await fetch(
                    `/agentes/${this.agenteId}/calcular?valor=${valor}`,
                    { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }
                );
                if (!res.ok) return;
                const data = await res.json();
                this.aplicarResultado(data);
            } finally {
                this.calculando = false;
            }
        },

        aplicarResultado(data) {
            const cores = {
                baixo:    { bg: '#f0fdf4', border: '#16a34a', text: '#14532d', icon: '✅' },
                moderado: { bg: '#fffbeb', border: '#d97706', text: '#78350f', icon: '⚠️' },
                alto:     { bg: '#fff7ed', border: '#ea580c', text: '#7c2d12', icon: '🔴' },
                critico:  { bg: '#fef2f2', border: '#dc2626', text: '#7f1d1d', icon: '🚨' },
            };
            const c = cores[data.classificacao] ?? cores.moderado;
            this.riscoCalc = {
                classificacao:       data.classificacao,
                classificacao_label: data.classificacao_label,
                probabilidade:       data.probabilidade,
                severidade:          data.severidade,
                nivel:               data.nivel,
                gatilho:             data.gatilho,
                descricao_gatilho:   data.descricao_gatilho,
                nivel_acao:          data.nivel_acao,
                limite_tolerancia:   data.limite_tolerancia,
                norma:               data.norma_referencia,
                unidade:             this.agenteAtual?.unidade_medida ?? '',
                bgColor:             c.bg,
                borderColor:         c.border,
                textColor:           c.text,
                icon:                c.icon,
            };
        },

        resetCalc() {
            this.riscoCalc = {
                classificacao: null, classificacao_label: null,
                probabilidade: null, severidade: null, nivel: null,
                gatilho: false, descricao_gatilho: null,
                nivel_acao: null, limite_tolerancia: null,
                norma: '', unidade: '',
                bgColor: '#f9fafb', borderColor: '#e5e7eb', textColor: '#374151', icon: 'ℹ️',
            };
        },
    };
};
