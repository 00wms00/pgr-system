{{--
    Componente: Campos dinâmicos de medição quantitativa
    Requer Alpine.js no contexto pai com x-data="riscoForm()"
--}}
<div x-show="agentes.length > 0" x-transition style="display:none">
    <div style="border:1px solid #e2e8f0;border-radius:8px;padding:16px;background:#f8fafc;margin-top:4px">
        <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6366f1;margin-bottom:12px">
            📊 Medição Quantitativa
        </p>

        {{-- Select do agente --}}
        <div style="margin-bottom:12px">
            <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px">
                Agente Específico
            </label>
            <select
                name="agente_quantitativo_id"
                x-model="agenteId"
                @change="onAgenteChange"
                style="width:100%;border:1px solid #d1d5db;border-radius:6px;padding:8px 10px;font-size:.85rem;background:#fff"
            >
                <option value="">— Selecione para medição quantitativa (opcional) —</option>
                <template x-for="ag in agentes" :key="ag.id">
                    <option :value="ag.id" x-text="ag.nome"></option>
                </template>
            </select>
        </div>

        {{-- Input de valor --}}
        <div x-show="agenteId" x-transition>
            <label
                style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px"
                x-text="agenteAtual?.campo_label ?? 'Valor Medido'"
            ></label>
            <div style="display:flex;align-items:center;gap:0">
                <input
                    type="number"
                    name="valor_medido"
                    x-model="valorMedido"
                    @blur="calcular"
                    :step="agenteAtual?.input_step ?? '0.1'"
                    min="0"
                    placeholder="0.0"
                    style="flex:1;border:1px solid #d1d5db;border-right:none;border-radius:6px 0 0 6px;padding:8px 10px;font-size:.95rem;font-weight:600"
                />
                <span
                    style="background:#e2e8f0;border:1px solid #d1d5db;border-radius:0 6px 6px 0;padding:8px 12px;font-size:.82rem;color:#374151;font-weight:700;white-space:nowrap"
                    x-text="agenteAtual?.unidade_medida ?? ''"
                ></span>
            </div>
            <p style="font-size:.7rem;color:#9ca3af;margin-top:3px">Pressione Tab ou clique fora do campo para calcular</p>
        </div>

        {{-- Card de resultado --}}
        <div style="margin-top:10px">
            <x-matriz-risco-card />
        </div>
    </div>
</div>

{{-- Campos hidden para envio no form --}}
<input type="hidden" name="probabilidade_calculada" :value="riscoCalc.probabilidade">
<input type="hidden" name="severidade_calculada"    :value="riscoCalc.severidade">
<input type="hidden" name="classificacao_calculada" :value="riscoCalc.classificacao">
