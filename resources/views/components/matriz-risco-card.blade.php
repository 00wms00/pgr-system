{{--
    Componente: Card de Feedback da Matriz de Risco Inteligente
    Uso: <x-matriz-risco-card />
    Controlado via Alpine.js — recebe dados do estado `riscoCalc`
--}}
<div
    x-show="riscoCalc.classificacao !== null"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-1"
    x-transition:enter-end="opacity-100 translate-y-0"
    :style="{
        border: '1px solid ' + riscoCalc.borderColor,
        background: riscoCalc.bgColor,
    }"
    style="border-radius:10px;padding:16px;margin-top:4px"
>
    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
        <div style="display:flex;align-items:center;gap:8px">
            <span x-html="riscoCalc.icon" style="font-size:1.2rem"></span>
            <span style="font-size:.82rem;font-weight:700" :style="{color: riscoCalc.textColor}">
                Nível de Risco: <span x-text="riscoCalc.classificacao_label"></span>
            </span>
        </div>
        <span
            style="font-size:1.4rem;font-weight:900;min-width:36px;text-align:center;border-radius:6px;padding:2px 8px"
            :style="{background: riscoCalc.borderColor, color: '#fff'}"
            x-text="riscoCalc.nivel"
        ></span>
    </div>

    {{-- Equação --}}
    <div style="font-size:.78rem;margin-bottom:10px;color:#374151">
        Probabilidade
        <strong x-text="riscoCalc.probabilidade"></strong>
        &times;
        Severidade
        <strong x-text="riscoCalc.severidade"></strong>
        =
        <strong x-text="riscoCalc.nivel"></strong>
        &nbsp;&mdash;&nbsp;
        <span x-text="riscoCalc.norma"></span>
    </div>

    {{-- Limites --}}
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:10px" x-show="riscoCalc.nivel_acao || riscoCalc.limite_tolerancia">
        <template x-if="riscoCalc.nivel_acao">
            <span style="font-size:.72rem;background:#fef3c7;color:#92400e;border-radius:99px;padding:2px 10px;font-weight:600">
                Nível de Ação: <span x-text="riscoCalc.nivel_acao"></span> <span x-text="riscoCalc.unidade"></span>
            </span>
        </template>
        <template x-if="riscoCalc.limite_tolerancia">
            <span style="font-size:.72rem;background:#fee2e2;color:#991b1b;border-radius:99px;padding:2px 10px;font-weight:600">
                Limite de Tolerância: <span x-text="riscoCalc.limite_tolerancia"></span> <span x-text="riscoCalc.unidade"></span>
            </span>
        </template>
    </div>

    {{-- Alerta de gatilho --}}
    <div
        x-show="riscoCalc.gatilho"
        style="background:rgba(255,255,255,.55);border-radius:7px;padding:10px 12px;font-size:.78rem;line-height:1.55"
        :style="{borderLeft: '3px solid ' + riscoCalc.borderColor}"
    >
        <p style="font-weight:700;margin-bottom:4px" :style="{color: riscoCalc.textColor}">
            ⚡ Plano de Ação gerado automaticamente
        </p>
        <p style="color:#374151" x-text="riscoCalc.descricao_gatilho"></p>
    </div>
</div>
