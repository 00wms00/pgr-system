@php
    $p = old('probabilidade', $avaliacao->probabilidade ?? null);
    $s = old('severidade',    $avaliacao->severidade    ?? null);
@endphp

<div class="space-y-6">

    {{-- ============================================================
         BLOCO QUANTITATIVO — só aparece se o tipo de risco tem
         agentes quantitativos cadastrados (ex: Ruído, Calor, etc.)
    ============================================================ --}}
    <div x-show="agentes.length > 0" x-transition style="display:none">
        <div style="border:1px solid #c7d2fe;border-radius:8px;padding:16px;background:#eef2ff">
            <p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#4338ca;margin-bottom:12px">
                📊 Medição Quantitativa (opcional)
            </p>

            {{-- Seleção do agente específico --}}
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
                    <option value="">— Selecione para medição quantitativa —</option>
                    <template x-for="ag in agentes" :key="ag.id">
                        <option :value="ag.id" x-text="ag.nome"></option>
                    </template>
                </select>
            </div>

            {{-- Campo de valor medido --}}
            <div x-show="agenteId" x-transition>
                <label
                    style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px"
                    x-text="agenteAtual?.campo_label ?? 'Valor Medido'"
                ></label>
                <div style="display:flex;align-items:center">
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
                <p style="font-size:.7rem;color:#9ca3af;margin-top:3px">Pressione Tab ou clique fora para calcular automaticamente</p>
            </div>

            {{-- Resultado do cálculo --}}
            <div x-show="riscoCalc.classificacao" x-transition style="margin-top:12px">
                <div style="display:flex;gap:12px;flex-wrap:wrap">
                    <div style="background:#fff;border:1px solid #d1d5db;border-radius:6px;padding:8px 14px;text-align:center;min-width:80px">
                        <p style="font-size:.65rem;color:#6b7280;margin-bottom:2px">Probabilidade</p>
                        <p style="font-size:1.2rem;font-weight:700;color:#1e293b" x-text="riscoCalc.probabilidade"></p>
                    </div>
                    <div style="background:#fff;border:1px solid #d1d5db;border-radius:6px;padding:8px 14px;text-align:center;min-width:80px">
                        <p style="font-size:.65rem;color:#6b7280;margin-bottom:2px">Severidade</p>
                        <p style="font-size:1.2rem;font-weight:700;color:#1e293b" x-text="riscoCalc.severidade"></p>
                    </div>
                    <div style="background:#fff;border:1px solid #d1d5db;border-radius:6px;padding:8px 14px;text-align:center;flex:1;min-width:120px">
                        <p style="font-size:.65rem;color:#6b7280;margin-bottom:2px">Classificação</p>
                        <p style="font-size:.9rem;font-weight:700" x-text="riscoCalc.classificacao"></p>
                    </div>
                </div>
                <p style="font-size:.72rem;color:#6b7280;margin-top:8px">✅ Os valores foram preenchidos automaticamente na matriz abaixo.</p>
            </div>

            {{-- Campos hidden para sincronizar com a matriz --}}
            <input type="hidden" name="probabilidade_calculada" :value="riscoCalc.probabilidade">
            <input type="hidden" name="severidade_calculada"    :value="riscoCalc.severidade">
        </div>
    </div>

    {{-- ============================================================
         DATA
    ============================================================ --}}
    <div>
        <x-input-label for="data_avaliacao" value="Data da Avaliação" />
        <x-text-input id="data_avaliacao" name="data_avaliacao" type="date" class="mt-1 block w-48"
            :value="old('data_avaliacao', isset($avaliacao) ? $avaliacao->data_avaliacao?->format('Y-m-d') : now()->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('data_avaliacao')" class="mt-1" />
    </div>

    {{-- ============================================================
         MATRIZ P × S
    ============================================================ --}}
    <div>
        <x-input-label value="Selecione a célula na Matriz P × S" />
        @if($errors->has('probabilidade') || $errors->has('severidade'))
            <p class="mt-1 text-sm text-red-600">Selecione uma célula na matriz.</p>
        @endif
        <div class="mt-2">
            @include('avaliacoes._matrix', ['selectedP' => $p, 'selectedS' => $s, 'interactive' => true])
        </div>
    </div>

    {{-- ============================================================
         METODOLOGIA
    ============================================================ --}}
    <div>
        <x-input-label for="metodologia" value="Metodologia" />
        <x-text-input id="metodologia" name="metodologia" type="text" class="mt-1 block w-full"
            :value="old('metodologia', $avaliacao->metodologia ?? 'Matriz 5x5 (P x S)')" />
        <x-input-error :messages="$errors->get('metodologia')" class="mt-1" />
    </div>

    {{-- ============================================================
         JUSTIFICATIVA
    ============================================================ --}}
    <div>
        <x-input-label for="justificativa" value="Justificativa" />
        <textarea id="justificativa" name="justificativa" rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
        >{{ old('justificativa', $avaliacao->justificativa ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('justificativa')" class="mt-1" />
    </div>

</div>
