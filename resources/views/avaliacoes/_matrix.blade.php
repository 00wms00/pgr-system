{{--
    Componente reutilizavel: Matriz 5x5 Probabilidade x Severidade
    Props:
      $selectedP  (int|null) - probabilidade selecionada (1-5)
      $selectedS  (int|null) - severidade selecionada (1-5)
      $interactive (bool)    - se true, celulas sao clicaveis e atualizam os inputs
--}}
@php
    $labels_p = [
        1 => ['label' => '1 - Muito Baixa', 'sub' => 'Improvavel'],
        2 => ['label' => '2 - Baixa',        'sub' => 'Remota'],
        3 => ['label' => '3 - Media',         'sub' => 'Ocasional'],
        4 => ['label' => '4 - Alta',          'sub' => 'Provavel'],
        5 => ['label' => '5 - Muito Alta',    'sub' => 'Frequente'],
    ];
    $labels_s = [
        1 => ['label' => '1', 'sub' => 'Insignificante'],
        2 => ['label' => '2', 'sub' => 'Leve'],
        3 => ['label' => '3', 'sub' => 'Moderado'],
        4 => ['label' => '4', 'sub' => 'Grave'],
        5 => ['label' => '5', 'sub' => 'Catastrofico'],
    ];

    $classificar = function(int $n): array {
        return match(true) {
            $n <= 4  => ['label' => 'Baixo',    'bg' => 'bg-green-200',  'text' => 'text-green-900',  'ring' => 'ring-green-500'],
            $n <= 9  => ['label' => 'Moderado', 'bg' => 'bg-yellow-200', 'text' => 'text-yellow-900', 'ring' => 'ring-yellow-500'],
            $n <= 16 => ['label' => 'Alto',     'bg' => 'bg-orange-300', 'text' => 'text-orange-900', 'ring' => 'ring-orange-500'],
            default  => ['label' => 'Critico',  'bg' => 'bg-red-400',    'text' => 'text-red-900',    'ring' => 'ring-red-600'],
        };
    };

    $selectedP = $selectedP ?? null;
    $selectedS = $selectedS ?? null;
    $interactive = $interactive ?? false;
@endphp

<div x-data="matrizRisco({{ $selectedP ?? 'null' }}, {{ $selectedS ?? 'null' }})" class="overflow-x-auto">

    {{-- Inputs hidden sincronizados (so no modo interativo) --}}
    @if($interactive)
        <input type="hidden" name="probabilidade" :value="prob">
        <input type="hidden" name="severidade"    :value="sev">
    @endif

    {{-- Legenda resultado --}}
    <div class="mb-3 flex items-center gap-3" @if(!$interactive) style="display:flex" @endif>
        <span class="text-sm text-gray-600">Resultado:</span>
        <template x-if="prob && sev">
            <span
                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold"
                :class="classificacao().bg + ' ' + classificacao().text">
                <span x-text="prob + ' x ' + sev + ' = ' + (prob * sev)"></span>
                <span>&mdash;</span>
                <span x-text="classificacao().label"></span>
            </span>
        </template>
        <template x-if="!prob || !sev">
            <span class="text-sm text-gray-400 italic">Clique em uma celula para selecionar</span>
        </template>
    </div>

    <table class="border-collapse text-center text-xs select-none">
        <thead>
            <tr>
                {{-- celula vazia canto superior esquerdo --}}
                <td class="p-1" colspan="2"></td>
                <td colspan="5" class="pb-1 text-center text-xs font-semibold text-gray-600 uppercase tracking-wide">
                    Severidade &rarr;
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                @foreach($labels_s as $s => $ls)
                    <th class="w-20 px-1 py-2 font-semibold text-gray-700">
                        <div>{{ $ls['label'] }}</div>
                        <div class="font-normal text-gray-400">{{ $ls['sub'] }}</div>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach(array_reverse(array_keys($labels_p), true) as $p)
                <tr>
                    {{-- Label probabilidade (so na primeira linha do grupo) --}}
                    @if($loop->first)
                        <td rowspan="5" class="pr-2 text-xs font-semibold text-gray-600 uppercase tracking-wide whitespace-nowrap"
                            style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">
                            &larr; Probabilidade
                        </td>
                    @endif
                    <td class="pr-2 py-1 text-left font-medium text-gray-700 whitespace-nowrap">
                        <div>{{ $labels_p[$p]['label'] }}</div>
                        <div class="text-gray-400 font-normal">{{ $labels_p[$p]['sub'] }}</div>
                    </td>

                    @foreach($labels_s as $s => $ls)
                        @php
                            $nivel = $p * $s;
                            $cls = $classificar($nivel);
                            $isSelected = ($p === $selectedP && $s === $selectedS);
                        @endphp
                        <td class="p-0.5">
                            <button
                                type="{{ $interactive ? 'button' : 'button' }}"
                                @if($interactive)
                                    @click="select({{ $p }}, {{ $s }})"
                                    :class="{
                                        'ring-2 ring-offset-1 scale-105 shadow-md z-10 relative': prob == {{ $p }} && sev == {{ $s }},
                                        '{{ $cls['ring'] }}': prob == {{ $p }} && sev == {{ $s }}
                                    }"
                                @endif
                                class="w-16 h-12 rounded flex flex-col items-center justify-center gap-0.5 font-bold transition-all duration-150
                                    {{ $cls['bg'] }} {{ $cls['text'] }}
                                    @if($interactive) cursor-pointer hover:brightness-90 hover:scale-105 @else cursor-default @endif
                                    @if($isSelected && !$interactive) ring-2 ring-offset-1 ring-gray-800 scale-105 shadow @endif"
                                @if(!$interactive) disabled @endif
                            >
                                <span class="text-base leading-none">{{ $nivel }}</span>
                                <span class="text-[10px] font-normal opacity-75">{{ $cls['label'] }}</span>
                            </button>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Legenda --}}
    <div class="mt-3 flex flex-wrap gap-3 text-xs">
        <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-green-200"></span> Baixo (1-4)</span>
        <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-yellow-200"></span> Moderado (5-9)</span>
        <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-orange-300"></span> Alto (10-16)</span>
        <span class="flex items-center gap-1"><span class="inline-block w-4 h-4 rounded bg-red-400"></span> Critico (17-25)</span>
    </div>
</div>

@once
@push('scripts')
<script>
function matrizRisco(initP, initS) {
    return {
        prob: initP,
        sev:  initS,
        select(p, s) {
            this.prob = p;
            this.sev  = s;
        },
        classificacao() {
            const n = this.prob * this.sev;
            if (n <= 4)  return { label: 'Baixo',    bg: 'bg-green-200',  text: 'text-green-900' };
            if (n <= 9)  return { label: 'Moderado', bg: 'bg-yellow-200', text: 'text-yellow-900' };
            if (n <= 16) return { label: 'Alto',     bg: 'bg-orange-300', text: 'text-orange-900' };
                         return { label: 'Critico',  bg: 'bg-red-400',    text: 'text-red-900' };
        }
    }
}
</script>
@endpush
@endonce
