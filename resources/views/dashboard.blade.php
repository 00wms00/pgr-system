@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('conteudo')
@php
    $corCls = [
        'critico'  => ['bg' => '#fef2f2', 'text' => '#991b1b', 'bar' => '#ef4444', 'label' => 'Crítico',  'icon' => '#dc2626'],
        'alto'     => ['bg' => '#fff7ed', 'text' => '#9a3412', 'bar' => '#f97316', 'label' => 'Alto',     'icon' => '#ea580c'],
        'moderado' => ['bg' => '#fefce8', 'text' => '#854d0e', 'bar' => '#eab308', 'label' => 'Moderado', 'icon' => '#ca8a04'],
        'baixo'    => ['bg' => '#f0fdf4', 'text' => '#166534', 'bar' => '#22c55e', 'label' => 'Baixo',    'icon' => '#16a34a'],
    ];
    $corSt = [
        'pendente'     => ['dot' => '#94a3b8', 'text' => '#475569', 'label' => 'Pendente'],
        'em_andamento' => ['dot' => '#3b82f6', 'text' => '#1d4ed8', 'label' => 'Em andamento'],
        'concluido'    => ['dot' => '#22c55e', 'text' => '#15803d', 'label' => 'Concluído'],
    ];
    $totalAvaliacoes   = array_sum($classificacoes);
    $totalPlanosStatus = array_sum($planosPorStatus);

    $kpis = [
        [
            'label'  => 'Unidades',
            'value'  => $totalUnidades,
            'route'  => 'unidades.index',
            'color'  => '#6366f1',
            'light'  => '#eef2ff',
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>',
        ],
        [
            'label'  => 'GHEs',
            'value'  => $totalGhes,
            'route'  => 'ghes.index',
            'color'  => '#8b5cf6',
            'light'  => '#f5f3ff',
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>',
        ],
        [
            'label'  => 'Riscos',
            'value'  => $totalRiscos,
            'route'  => 'riscos.index',
            'color'  => '#ef4444',
            'light'  => '#fef2f2',
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
        ],
        [
            'label'  => 'Planos de Ação',
            'value'  => $totalPlanos,
            'route'  => 'riscos.index',
            'color'  => '#10b981',
            'light'  => '#ecfdf5',
            'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
        ],
    ];
@endphp

<style>
.dash-wrapper { max-width: 1180px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px; }
.dash-empresa { font-size: .8rem; color: #94a3b8; font-weight: 500; letter-spacing: .02em; }

/* Alertas */
.dash-alert { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; border: 1px solid; font-size: .83rem; font-weight: 500; }
.dash-alert-danger { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
.dash-alert-warn   { background: #fffbeb; border-color: #fde68a; color: #92400e; }

/* KPIs */
.dash-kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
.dash-kpi {
    display: flex; align-items: center; gap: 16px;
    background: #fff; border: 1px solid #f1f5f9;
    border-radius: 12px; padding: 20px;
    text-decoration: none; color: inherit;
    box-shadow: 0 1px 3px rgba(0,0,0,.05);
    transition: box-shadow .18s, transform .18s;
}
.dash-kpi:hover { box-shadow: 0 6px 20px rgba(0,0,0,.09); transform: translateY(-2px); }
.dash-kpi-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.dash-kpi-body { display: flex; flex-direction: column; gap: 2px; }
.dash-kpi-value { font-size: 1.9rem; font-weight: 800; line-height: 1; }
.dash-kpi-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; }

/* Charts row */
.dash-charts { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; }
.dash-card { background: #fff; border: 1px solid #f1f5f9; border-radius: 12px; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
.dash-card-title { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94a3b8; margin-bottom: 18px; }

/* Barras */
.cls-row { display: flex; flex-direction: column; gap: 13px; }
.cls-item { display: flex; flex-direction: column; gap: 5px; }
.cls-meta { display: flex; justify-content: space-between; align-items: center; }
.cls-name { font-size: .8rem; font-weight: 600; }
.cls-count { font-size: .75rem; color: #94a3b8; font-variant-numeric: tabular-nums; }
.cls-track { height: 8px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
.cls-fill { height: 100%; border-radius: 99px; transition: width .6s cubic-bezier(.16,1,.3,1); }

/* Donut */
.donut-wrap { display: flex; align-items: center; gap: 24px; }
.donut-legend { display: flex; flex-direction: column; gap: 10px; flex: 1; }
.donut-legend-item { display: flex; align-items: center; gap: 8px; font-size: .8rem; }
.donut-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.donut-lbl { color: #475569; flex: 1; }
.donut-val { font-weight: 700; color: #1e293b; font-variant-numeric: tabular-nums; }

/* Tabelas inferiores */
.dash-tables { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px; }
.dash-list { display: flex; flex-direction: column; gap: 8px; }
.dash-list-item {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
    padding: 10px 12px; background: #f8fafc; border-radius: 8px;
    border: 1px solid #f1f5f9;
}
.dash-list-main { min-width: 0; }
.dash-list-title { font-size: .8rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dash-list-sub   { font-size: .7rem; color: #94a3b8; margin-top: 1px; }
.dash-list-side  { flex-shrink: 0; text-align: right; display: flex; align-items: center; gap: 8px; }
.dash-badge { padding: 2px 9px; border-radius: 99px; font-size: .68rem; font-weight: 700; white-space: nowrap; }
.dash-link  { font-size: .72rem; font-weight: 600; color: #6366f1; text-decoration: none; }
.dash-link:hover { text-decoration: underline; }
.dash-empty { text-align: center; padding: 24px 0; }
.dash-empty svg { margin: 0 auto 8px; }
.dash-empty p { font-size: .78rem; color: #94a3b8; }

/* Dias vencimento */
.dias-ok      { font-size: .75rem; font-weight: 700; color: #475569; }
.dias-warn    { font-size: .75rem; font-weight: 700; color: #d97706; }
.dias-atraso  { font-size: .75rem; font-weight: 700; color: #dc2626; }

@media (max-width: 640px) {
    .dash-kpis    { grid-template-columns: repeat(2, 1fr); }
    .dash-charts  { grid-template-columns: 1fr; }
    .dash-tables  { grid-template-columns: 1fr; }
    .dash-kpi-value { font-size: 1.5rem; }
}
</style>

<div class="dash-wrapper">

    {{-- Empresa --}}
    <p class="dash-empresa">{{ auth()->user()->empresa->nome ?? '' }} &mdash; Visão geral do PGR</p>

    {{-- Alertas --}}
    @if($planosAtrasados > 0)
    <div class="dash-alert dash-alert-danger">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        <span>{{ $planosAtrasados }} {{ $planosAtrasados === 1 ? 'plano atrasado' : 'planos atrasados' }} &mdash; requer atenção imediata</span>
    </div>
    @endif

    @if($planosProximos > 0)
    <div class="dash-alert dash-alert-warn">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ $planosProximos }} {{ $planosProximos === 1 ? 'plano vence' : 'planos vencem' }} nos próximos 30 dias</span>
    </div>
    @endif

    {{-- KPIs --}}
    <div class="dash-kpis">
        @foreach($kpis as $kpi)
        <a href="{{ route($kpi['route']) }}" class="dash-kpi">
            <div class="dash-kpi-icon" style="background:{{ $kpi['light'] }}">
                <svg width="22" height="22" fill="none" stroke="{{ $kpi['color'] }}" stroke-width="1.75" viewBox="0 0 24 24">{!! $kpi['icon'] !!}</svg>
            </div>
            <div class="dash-kpi-body">
                <span class="dash-kpi-value" style="color:{{ $kpi['color'] }}">{{ $kpi['value'] }}</span>
                <span class="dash-kpi-label">{{ $kpi['label'] }}</span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Gráficos --}}
    <div class="dash-charts">

        {{-- Barras: Riscos por classificação --}}
        <div class="dash-card">
            <p class="dash-card-title">Riscos por Classificação</p>
            @if($totalAvaliacoes === 0)
                <div class="dash-empty">
                    <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                    <p>Nenhuma avaliação registrada</p>
                </div>
            @else
            <div class="cls-row">
                @foreach($corCls as $key => $c)
                    @php $v = $classificacoes[$key] ?? 0; $pct = $totalAvaliacoes ? round($v / $totalAvaliacoes * 100) : 0; @endphp
                    <div class="cls-item">
                        <div class="cls-meta">
                            <span class="cls-name" style="color:{{ $c['text'] }}">{{ $c['label'] }}</span>
                            <span class="cls-count">{{ $v }} &nbsp;({{ $pct }}%)</span>
                        </div>
                        <div class="cls-track">
                            <div class="cls-fill" style="width:{{ $pct }}%;background:{{ $c['bar'] }}"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Donut: Planos por status --}}
        <div class="dash-card">
            <p class="dash-card-title">Planos por Status</p>
            @if($totalPlanosStatus === 0)
                <div class="dash-empty">
                    <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375"/></svg>
                    <p>Nenhum plano cadastrado</p>
                </div>
            @else
            @php
                $r = 36; $circ = 2 * M_PI * $r;
                $dots = ['pendente' => '#94a3b8', 'em_andamento' => '#3b82f6', 'concluido' => '#22c55e'];
                $segs = []; $running = $circ * 0.25;
                foreach ($corSt as $key => $cs) {
                    $v = $planosPorStatus[$key] ?? 0;
                    $dash = $totalPlanosStatus ? ($v / $totalPlanosStatus) * $circ : 0;
                    $segs[] = ['dash' => $dash, 'offset' => $running, 'color' => $dots[$key], 'label' => $cs['label'], 'v' => $v];
                    $running -= $dash;
                }
            @endphp
            <div class="donut-wrap">
                <svg viewBox="0 0 100 100" style="width:96px;height:96px;flex-shrink:0">
                    @foreach($segs as $seg)
                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                        stroke="{{ $seg['color'] }}" stroke-width="16"
                        stroke-dasharray="{{ round($seg['dash'], 3) }} {{ round($circ, 3) }}"
                        stroke-dashoffset="{{ round($seg['offset'], 3) }}"
                        transform="rotate(-90 50 50)"/>
                    @endforeach
                    <text x="50" y="47" text-anchor="middle" font-size="13" font-weight="800" fill="#1e293b">{{ $totalPlanosStatus }}</text>
                    <text x="50" y="59" text-anchor="middle" font-size="7" fill="#94a3b8">planos</text>
                </svg>
                <div class="donut-legend">
                    @foreach($segs as $seg)
                    <div class="donut-legend-item">
                        <span class="donut-dot" style="background:{{ $seg['color'] }}"></span>
                        <span class="donut-lbl">{{ $seg['label'] }}</span>
                        <span class="donut-val">{{ $seg['v'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Tabelas inferiores --}}
    <div class="dash-tables">

        {{-- Críticos sem plano --}}
        <div class="dash-card">
            <p class="dash-card-title">Riscos Críticos/Altos sem Plano</p>
            @if($riscosSemPlano->isEmpty())
                <div class="dash-empty">
                    <svg width="28" height="28" fill="none" stroke="#22c55e" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Todos os riscos estão cobertos!</p>
                </div>
            @else
                <div class="dash-list">
                    @foreach($riscosSemPlano as $risco)
                        @php $av = $risco->avaliacoes->first(); $cc = $av ? ($corCls[$av->classificacao] ?? null) : null; @endphp
                        <div class="dash-list-item">
                            <div class="dash-list-main">
                                <p class="dash-list-title">{{ $risco->riscoTipo->nome }}</p>
                                <p class="dash-list-sub">{{ $risco->ghe->nome ?? '—' }}</p>
                            </div>
                            <div class="dash-list-side">
                                @if($cc)
                                    <span class="dash-badge" style="background:{{ $cc['bg'] }};color:{{ $cc['text'] }}">{{ $cc['label'] }}</span>
                                @endif
                                @if($av)
                                    <a href="{{ route('avaliacoes.show', $av->id) }}" class="dash-link">Ver &rarr;</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Próximos planos --}}
        <div class="dash-card">
            <p class="dash-card-title">Próximos Planos a Vencer</p>
            @if($proximosPlanos->isEmpty())
                <div class="dash-empty">
                    <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Nenhum plano em aberto</p>
                </div>
            @else
                <div class="dash-list">
                    @foreach($proximosPlanos as $plano)
                        @php
                            $dias = (int) now()->diffInDays($plano->prazo, false);
                            $diasCls = $dias < 0 ? 'dias-atraso' : ($dias <= 7 ? 'dias-warn' : 'dias-ok');
                            $diasLabel = $dias < 0 ? abs($dias).'d atrasado' : ($dias === 0 ? 'Hoje' : $dias.'d');
                            $cs = $corSt[$plano->status] ?? $corSt['pendente'];
                        @endphp
                        <div class="dash-list-item">
                            <div class="dash-list-main">
                                <p class="dash-list-title">{{ $plano->avaliacaoRisco->riscoInventario->riscoTipo->nome }}</p>
                                <p class="dash-list-sub">{{ $plano->responsavel }}</p>
                            </div>
                            <div class="dash-list-side" style="flex-direction:column;align-items:flex-end;gap:4px">
                                <span class="{{ $diasCls }}">{{ $diasLabel }}</span>
                                <span class="dash-badge" style="background:{{ $cs['dot'] }}22;color:{{ $cs['text'] }}">{{ $cs['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
