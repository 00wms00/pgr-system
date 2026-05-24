{{--
    Componente: Matriz 5x5 Probabilidade x Severidade
    Props:
      $selectedP   (int|null) probabilidade pre-selecionada
      $selectedS   (int|null) severidade pre-selecionada
      $interactive (bool)     true = clicavel, false = so visualizacao
--}}
@php
    $labels_p = [
        5 => ['num' => '5', 'sub' => 'Muito Alta / Frequente'],
        4 => ['num' => '4', 'sub' => 'Alta / Provavel'],
        3 => ['num' => '3', 'sub' => 'Media / Ocasional'],
        2 => ['num' => '2', 'sub' => 'Baixa / Remota'],
        1 => ['num' => '1', 'sub' => 'Muito Baixa / Improvavel'],
    ];
    $labels_s = [
        1 => 'Insignificante',
        2 => 'Leve',
        3 => 'Moderado',
        4 => 'Grave',
        5 => 'Catastrofico',
    ];

    // Retorna cor de fundo, cor do texto e nome
    $cor = function(int $n): array {
        if ($n <= 4)  return ['bg' => '#bbf7d0', 'text' => '#14532d', 'border' => '#16a34a', 'nome' => 'Baixo'];
        if ($n <= 9)  return ['bg' => '#fef08a', 'text' => '#713f12', 'border' => '#ca8a04', 'nome' => 'Moderado'];
        if ($n <= 16) return ['bg' => '#fdba74', 'text' => '#7c2d12', 'border' => '#ea580c', 'nome' => 'Alto'];
        return             ['bg' => '#fca5a5', 'text' => '#7f1d1d', 'border' => '#dc2626', 'nome' => 'Critico'];
    };

    $selectedP   = $selectedP   ?? null;
    $selectedS   = $selectedS   ?? null;
    $interactive = $interactive ?? false;
@endphp

<div x-data="matrizRisco({{ $selectedP ?? 'null' }}, {{ $selectedS ?? 'null' }})">

    @if($interactive)
        <input type="hidden" name="probabilidade" :value="prob">
        <input type="hidden" name="severidade"    :value="sev">
    @endif

    {{-- Badge resultado (modo interativo) --}}
    @if($interactive)
    <div class="mb-3 h-8 flex items-center gap-2">
        <template x-if="prob && sev">
            <div x-html="badgeHtml()" class="inline-flex"></div>
        </template>
        <template x-if="!prob || !sev">
            <span style="font-size:0.85rem;color:#6b7280;font-style:italic">Clique em uma c&eacute;lula da matriz para selecionar</span>
        </template>
    </div>
    @endif

    {{-- Tabela --}}
    <div style="overflow-x:auto">
        <table style="border-collapse:separate;border-spacing:0;font-size:0.78rem">
            <thead>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="5" style="text-align:center;padding-bottom:4px;font-size:0.7rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em">
                        Severidade &rarr;
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    @foreach($labels_s as $s => $sub)
                        <th style="width:72px;padding:4px 2px;font-weight:600;color:#374151;text-align:center">
                            <div style="font-size:0.85rem">{{ $s }}</div>
                            <div style="font-size:0.65rem;font-weight:400;color:#9ca3af">{{ $sub }}</div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($labels_p as $p => $lp)
                    <tr>
                        @if($loop->first)
                            <td rowspan="5" style="padding-right:4px;vertical-align:middle">
                                <div style="writing-mode:vertical-lr;transform:rotate(180deg);font-size:0.7rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;white-space:nowrap">
                                    &larr; Probabilidade
                                </div>
                            </td>
                        @endif
                        <td style="padding-right:8px;padding-top:3px;padding-bottom:3px;vertical-align:middle;white-space:nowrap">
                            <div style="font-weight:600;color:#374151">{{ $lp['num'] }}</div>
                            <div style="font-size:0.65rem;color:#9ca3af">{{ $lp['sub'] }}</div>
                        </td>

                        @foreach($labels_s as $s => $sub)
                            @php
                                $n   = $p * $s;
                                $c   = $cor($n);
                                $sel = ($p === $selectedP && $s === $selectedS);
                            @endphp
                            <td style="padding:2px">
                                <button
                                    type="button"
                                    @if($interactive)
                                        @click="select({{ $p }}, {{ $s }})"
                                        :style="prob == {{ $p }} && sev == {{ $s }}
                                            ? 'background:{{ $c['bg'] }};color:{{ $c['text'] }};outline:3px solid {{ $c['border'] }};outline-offset:2px;transform:scale(1.08);z-index:10;position:relative;box-shadow:0 2px 8px rgba(0,0,0,.18)'
                                            : 'background:{{ $c['bg'] }};color:{{ $c['text'] }};'"
                                    @endif
                                    style="
                                        width:68px;
                                        height:46px;
                                        border:none;
                                        border-radius:5px;
                                        display:flex;
                                        flex-direction:column;
                                        align-items:center;
                                        justify-content:center;
                                        gap:1px;
                                        cursor:{{ $interactive ? 'pointer' : 'default' }};
                                        transition:transform .12s,box-shadow .12s;
                                        background:{{ $c['bg'] }};
                                        color:{{ $c['text'] }};
                                        @if($sel && !$interactive)
                                            outline:3px solid {{ $c['border'] }};
                                            outline-offset:2px;
                                            transform:scale(1.06);
                                            box-shadow:0 2px 8px rgba(0,0,0,.18);
                                            position:relative;
                                            z-index:10;
                                        @endif
                                    "
                                    @if(!$interactive) disabled @endif
                                >
                                    <span style="font-size:1rem;font-weight:700;line-height:1">{{ $n }}</span>
                                    <span style="font-size:0.6rem;opacity:.85">{{ $c['nome'] }}</span>
                                </button>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Legenda --}}
    <div style="margin-top:10px;display:flex;flex-wrap:wrap;gap:12px;font-size:0.75rem;color:#374151">
        <span style="display:flex;align-items:center;gap:5px"><span style="display:inline-block;width:14px;height:14px;border-radius:3px;background:#bbf7d0"></span> Baixo (1–4)</span>
        <span style="display:flex;align-items:center;gap:5px"><span style="display:inline-block;width:14px;height:14px;border-radius:3px;background:#fef08a"></span> Moderado (5–9)</span>
        <span style="display:flex;align-items:center;gap:5px"><span style="display:inline-block;width:14px;height:14px;border-radius:3px;background:#fdba74"></span> Alto (10–16)</span>
        <span style="display:flex;align-items:center;gap:5px"><span style="display:inline-block;width:14px;height:14px;border-radius:3px;background:#fca5a5"></span> Cr&iacute;tico (17–25)</span>
    </div>
</div>

@once
@push('scripts')
<script>
function matrizRisco(initP, initS) {
    const cores = (n) => {
        if (n <= 4)  return { bg:'#bbf7d0', text:'#14532d', border:'#16a34a', nome:'Baixo' };
        if (n <= 9)  return { bg:'#fef08a', text:'#713f12', border:'#ca8a04', nome:'Moderado' };
        if (n <= 16) return { bg:'#fdba74', text:'#7c2d12', border:'#ea580c', nome:'Alto' };
        return             { bg:'#fca5a5', text:'#7f1d1d', border:'#dc2626', nome:'Critico' };
    };
    return {
        prob: initP,
        sev:  initS,
        select(p, s) { this.prob = p; this.sev = s; },
        badgeHtml() {
            if (!this.prob || !this.sev) return '';
            const n = this.prob * this.sev;
            const c = cores(n);
            return `<span style="display:inline-flex;align-items:center;gap:6px;border-radius:9999px;padding:3px 12px;font-size:0.85rem;font-weight:600;background:${c.bg};color:${c.text}">
                ${this.prob} &times; ${this.sev} = <strong>${n}</strong> &mdash; ${c.nome}
            </span>`;
        }
    };
}
</script>
@endpush
@endonce
