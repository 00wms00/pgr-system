<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard PGR</h2>
            <span class="text-sm text-gray-500">{{ auth()->user()->empresa->nome ?? '' }}</span>
        </div>
    </x-slot>

    @php
        $corClassificacao = [
            'critico'  => ['bg' => '#fca5a5', 'text' => '#7f1d1d', 'border' => '#dc2626', 'label' => 'Crítico'],
            'alto'     => ['bg' => '#fdba74', 'text' => '#7c2d12', 'border' => '#ea580c', 'label' => 'Alto'],
            'moderado' => ['bg' => '#fef08a', 'text' => '#713f12', 'border' => '#ca8a04', 'label' => 'Moderado'],
            'baixo'    => ['bg' => '#bbf7d0', 'text' => '#14532d', 'border' => '#16a34a', 'label' => 'Baixo'],
        ];
        $corStatus = [
            'pendente'     => ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => 'Pendente'],
            'em_andamento' => ['bg' => '#bfdbfe', 'text' => '#1e3a8a', 'label' => 'Em andamento'],
            'concluido'    => ['bg' => '#bbf7d0', 'text' => '#14532d', 'label' => 'Concluído'],
        ];
        $totalAvaliacoes = array_sum($classificacoes);
        $totalPlanosStatus = array_sum($planosPorStatus);
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ============================================================
                 ALERTAS
            ============================================================ --}}
            @if($planosAtrasados > 0)
            <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:12px 16px;display:flex;align-items:center;gap:10px">
                <svg style="width:20px;height:20px;color:#dc2626;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                <span style="font-size:.875rem;color:#7f1d1d;font-weight:600">
                    {{ $planosAtrasados }} {{ Str::plural('plano', $planosAtrasados) }} {{ $planosAtrasados === 1 ? 'está atrasado' : 'estão atrasados' }}.
                </span>
                <a href="{{ route('riscos.index') }}" style="margin-left:auto;font-size:.8rem;color:#dc2626;font-weight:600">Ver riscos &rarr;</a>
            </div>
            @endif

            @if($planosProximos > 0)
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;display:flex;align-items:center;gap:10px">
                <svg style="width:20px;height:20px;color:#d97706;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span style="font-size:.875rem;color:#78350f;font-weight:500">
                    {{ $planosProximos }} {{ Str::plural('plano', $planosProximos) }} vencem nos próximos 30 dias.
                </span>
            </div>
            @endif

            {{-- ============================================================
                 KPIs
            ============================================================ --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px">
                @foreach([
                    ['label' => 'Unidades',      'value' => $totalUnidades,  'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'route' => 'unidades.index', 'color' => '#6366f1'],
                    ['label' => 'GHEs',          'value' => $totalGhes,      'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'route' => 'ghes.index', 'color' => '#8b5cf6'],
                    ['label' => 'Riscos',        'value' => $totalRiscos,    'icon' => 'M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z', 'route' => 'riscos.index', 'color' => '#ef4444'],
                    ['label' => 'Planos de Ação','value' => $totalPlanos,   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'route' => 'riscos.index', 'color' => '#10b981'],
                ] as $kpi)
                <a href="{{ route($kpi['route']) }}" style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px;display:flex;flex-direction:column;gap:10px;text-decoration:none;transition:box-shadow .15s" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.12)'" onmouseout="this.style.boxShadow='0 1px 4px rgba(0,0,0,.07)'">
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span style="font-size:.8rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.04em">{{ $kpi['label'] }}</span>
                        <span style="width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:{{ $kpi['color'] }}18">
                            <svg style="width:18px;height:18px;color:{{ $kpi['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"/></svg>
                        </span>
                    </div>
                    <span style="font-size:2rem;font-weight:700;color:#111827;line-height:1">{{ $kpi['value'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- ============================================================
                 GRAFICOS (barras inline SVG)
            ============================================================ --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px">

                {{-- Distribuicao de Avaliacoes por Classificacao --}}
                <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px">
                    <h3 style="font-size:.875rem;font-weight:600;color:#374151;margin-bottom:14px">Distribui&ccedil;&atilde;o de Riscos por Classifica&ccedil;&atilde;o</h3>
                    @if($totalAvaliacoes === 0)
                        <p style="font-size:.8rem;color:#9ca3af;font-style:italic">Nenhuma avalia&ccedil;&atilde;o registrada.</p>
                    @else
                        <div style="display:flex;flex-direction:column;gap:10px">
                            @foreach($corClassificacao as $key => $c)
                                @php
                                    $val = $classificacoes[$key] ?? 0;
                                    $pct = $totalAvaliacoes > 0 ? round($val / $totalAvaliacoes * 100) : 0;
                                @endphp
                                <div>
                                    <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:3px">
                                        <span style="font-weight:600;color:{{ $c['text'] }}">{{ $c['label'] }}</span>
                                        <span style="color:#6b7280">{{ $val }} ({{ $pct }}%)</span>
                                    </div>
                                    <div style="height:10px;background:#f3f4f6;border-radius:99px;overflow:hidden">
                                        <div style="height:100%;width:{{ $pct }}%;background:{{ $c['border'] }};border-radius:99px;transition:width .5s"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Planos por Status --}}
                <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px">
                    <h3 style="font-size:.875rem;font-weight:600;color:#374151;margin-bottom:14px">Planos de A&ccedil;&atilde;o por Status</h3>
                    @if($totalPlanosStatus === 0)
                        <p style="font-size:.8rem;color:#9ca3af;font-style:italic">Nenhum plano cadastrado.</p>
                    @else
                        {{-- Donut visual simples --}}
                        @php
                            $segments = [];
                            $offset = 25; // stroke-dashoffset start
                            $r = 36; $circ = 2 * M_PI * $r;
                            $colors = ['pendente' => '#9ca3af', 'em_andamento' => '#60a5fa', 'concluido' => '#34d399'];
                            foreach ($corStatus as $key => $cs) {
                                $v = $planosPorStatus[$key] ?? 0;
                                $pct = $totalPlanosStatus > 0 ? $v / $totalPlanosStatus : 0;
                                $segments[$key] = ['v' => $v, 'pct' => $pct, 'dash' => $pct * $circ, 'offset' => $offset, 'color' => $colors[$key], 'label' => $cs['label']];
                                $offset += $pct * $circ; // nao negativo
                            }
                            // recalcular offset correto (sentido horario a partir do topo)
                            $startAngle = -25; // deixa o circulo comecar no topo
                            $runningOffset = $circ * 0.25; // porcentagem que representa o gap de inicio
                            foreach ($segments as $key => &$seg) {
                                $seg['offset'] = $runningOffset;
                                $runningOffset -= $seg['dash'];
                            }
                            unset($seg);
                        @endphp
                        <div style="display:flex;align-items:center;gap:20px">
                            <svg viewBox="0 0 100 100" style="width:90px;height:90px;flex-shrink:0">
                                @foreach($segments as $seg)
                                <circle cx="50" cy="50" r="{{ $r }}"
                                    fill="none"
                                    stroke="{{ $seg['color'] }}"
                                    stroke-width="14"
                                    stroke-dasharray="{{ round($seg['dash'],2) }} {{ round($circ,2) }}"
                                    stroke-dashoffset="{{ round($seg['offset'],2) }}"
                                    transform="rotate(-90 50 50)"
                                />
                                @endforeach
                                <text x="50" y="54" text-anchor="middle" font-size="14" font-weight="700" fill="#111827">{{ $totalPlanosStatus }}</text>
                            </svg>
                            <div style="display:flex;flex-direction:column;gap:7px;font-size:.8rem">
                                @foreach($segments as $seg)
                                <div style="display:flex;align-items:center;gap:7px">
                                    <span style="width:10px;height:10px;border-radius:50%;background:{{ $seg['color'] }};flex-shrink:0"></span>
                                    <span style="color:#374151">{{ $seg['label'] }}</span>
                                    <span style="margin-left:auto;font-weight:600;color:#111827;padding-left:12px">{{ $seg['v'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============================================================
                 TABELAS INFERIORES
            ============================================================ --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px">

                {{-- Riscos Criticos/Altos sem plano --}}
                <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px">
                    <h3 style="font-size:.875rem;font-weight:600;color:#374151;margin-bottom:12px">
                        Riscos Cr&iacute;ticos/Altos sem Plano de A&ccedil;&atilde;o
                    </h3>
                    @if($riscosSemPlano->isEmpty())
                        <div style="text-align:center;padding:20px 0">
                            <svg style="width:32px;height:32px;color:#34d399;margin:0 auto 8px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p style="font-size:.8rem;color:#6b7280">Nenhum risco cr&iacute;tico sem plano.</p>
                        </div>
                    @else
                        <div style="display:flex;flex-direction:column;gap:8px">
                            @foreach($riscosSemPlano as $risco)
                                @php $aval = $risco->avaliacoes->first(); @endphp
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;background:#fafafa;border-radius:6px;gap:8px">
                                    <div style="min-width:0">
                                        <p style="font-size:.8rem;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $risco->riscoTipo->nome }}</p>
                                        <p style="font-size:.72rem;color:#6b7280">{{ $risco->ghe->nome }}</p>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:6px;flex-shrink:0">
                                        @if($aval)
                                            @php $cc = $corClassificacao[$aval->classificacao] ?? null; @endphp
                                            @if($cc)
                                            <span style="background:{{ $cc['bg'] }};color:{{ $cc['text'] }};padding:1px 8px;border-radius:9999px;font-size:.7rem;font-weight:600">{{ $cc['label'] }}</span>
                                            @endif
                                            <a href="{{ route('avaliacoes.show', $aval->id) }}" style="font-size:.75rem;color:#6366f1;font-weight:600">Ver &rarr;</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Proximos Planos --}}
                <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px">
                    <h3 style="font-size:.875rem;font-weight:600;color:#374151;margin-bottom:12px">
                        Pr&oacute;ximos Planos a Vencer
                    </h3>
                    @if($proximosPlanos->isEmpty())
                        <p style="font-size:.8rem;color:#9ca3af;font-style:italic;text-align:center;padding:20px 0">Nenhum plano em aberto.</p>
                    @else
                        <div style="display:flex;flex-direction:column;gap:8px">
                            @foreach($proximosPlanos as $plano)
                                @php
                                    $diasRestantes = now()->diffInDays($plano->prazo, false);
                                    $prazoColor = $diasRestantes < 0 ? '#dc2626' : ($diasRestantes <= 7 ? '#d97706' : '#374151');
                                    $cs = $corStatus[$plano->status] ?? $corStatus['pendente'];
                                @endphp
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;background:#fafafa;border-radius:6px;gap:8px">
                                    <div style="min-width:0">
                                        <p style="font-size:.8rem;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                            {{ $plano->avaliacaoRisco->riscoInventario->riscoTipo->nome }}
                                        </p>
                                        <p style="font-size:.72rem;color:#6b7280">{{ $plano->responsavel }}</p>
                                    </div>
                                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:3px;flex-shrink:0">
                                        <span style="font-size:.75rem;font-weight:700;color:{{ $prazoColor }}">
                                            @if($diasRestantes < 0)
                                                {{ abs((int)$diasRestantes) }}d atrasado
                                            @elseif($diasRestantes === 0)
                                                Hoje
                                            @else
                                                {{ (int)$diasRestantes }}d restantes
                                            @endif
                                        </span>
                                        <span style="background:{{ $cs['bg'] }};color:{{ $cs['text'] }};padding:1px 7px;border-radius:9999px;font-size:.68rem;font-weight:600">
                                            {{ $cs['label'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            {{-- ============================================================
                 ATALHOS
            ============================================================ --}}
            <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.07);padding:20px">
                <h3 style="font-size:.875rem;font-weight:600;color:#374151;margin-bottom:14px">Acesso R&aacute;pido</h3>
                <div style="display:flex;flex-wrap:wrap;gap:10px">
                    @foreach([
                        ['label' => 'Nova Unidade',   'route' => 'unidades.create',  'color' => '#6366f1'],
                        ['label' => 'Novo Setor',     'route' => 'setores.create',   'color' => '#8b5cf6'],
                        ['label' => 'Novo GHE',       'route' => 'ghes.create',      'color' => '#a855f7'],
                        ['label' => 'Novo Risco',     'route' => 'riscos.create',    'color' => '#ef4444'],
                        ['label' => 'Ver todos os Riscos','route' => 'riscos.index', 'color' => '#374151'],
                    ] as $link)
                    <a href="{{ route($link['route']) }}"
                        style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none;color:{{ $link['color'] }};background:{{ $link['color'] }}12;border:1px solid {{ $link['color'] }}30;transition:background .15s"
                        onmouseover="this.style.background='{{ $link['color'] }}22'" onmouseout="this.style.background='{{ $link['color'] }}12'">
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
