@extends('layouts.app')
@section('titulo', 'Dashboard')

@section('conteudo')
@php
    $corCls = [
        'critico'  => ['bg' => '#fca5a5', 'text' => '#7f1d1d', 'border' => '#dc2626', 'label' => 'Crítico'],
        'alto'     => ['bg' => '#fdba74', 'text' => '#7c2d12', 'border' => '#ea580c', 'label' => 'Alto'],
        'moderado' => ['bg' => '#fef08a', 'text' => '#713f12', 'border' => '#ca8a04', 'label' => 'Moderado'],
        'baixo'    => ['bg' => '#bbf7d0', 'text' => '#14532d', 'border' => '#16a34a', 'label' => 'Baixo'],
    ];
    $corSt = [
        'pendente'     => ['bg' => '#f3f4f6', 'text' => '#374151', 'label' => 'Pendente',     'dot' => '#9ca3af'],
        'em_andamento' => ['bg' => '#bfdbfe', 'text' => '#1e3a8a', 'label' => 'Em andamento', 'dot' => '#60a5fa'],
        'concluido'    => ['bg' => '#bbf7d0', 'text' => '#14532d', 'label' => 'Concluído',    'dot' => '#34d399'],
    ];
    $totalAvaliacoes   = array_sum($classificacoes);
    $totalPlanosStatus = array_sum($planosPorStatus);
@endphp

<div style="max-width:1200px;margin:0 auto;display:flex;flex-direction:column;gap:20px">

    {{-- Subtitulo --}}
    <p style="font-size:.82rem;color:#64748b">Vis&atilde;o geral do PGR &mdash; {{ auth()->user()->empresa->nome ?? '' }}</p>

    {{-- Alertas --}}
    @if($planosAtrasados > 0)
    <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:11px 16px;display:flex;align-items:center;gap:10px">
        <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        <span style="font-size:.83rem;color:#7f1d1d;font-weight:600">{{ $planosAtrasados }} {{ $planosAtrasados === 1 ? 'plano atrasado' : 'planos atrasados' }}</span>
    </div>
    @endif

    @if($planosProximos > 0)
    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:11px 16px;display:flex;align-items:center;gap:10px">
        <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:.83rem;color:#78350f">{{ $planosProximos }} {{ $planosProximos === 1 ? 'plano vence' : 'planos vencem' }} nos próximos 30 dias</span>
    </div>
    @endif

    {{-- KPIs --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px">
        @foreach([
            ['label'=>'Unidades',       'value'=>$totalUnidades, 'route'=>'unidades.index', 'color'=>'#6366f1'],
            ['label'=>'GHEs',           'value'=>$totalGhes,     'route'=>'ghes.index',     'color'=>'#8b5cf6'],
            ['label'=>'Riscos',         'value'=>$totalRiscos,   'route'=>'riscos.index',   'color'=>'#ef4444'],
            ['label'=>'Planos de Ação', 'value'=>$totalPlanos,  'route'=>'riscos.index',   'color'=>'#10b981'],
        ] as $kpi)
        <a href="{{ route($kpi['route']) }}" style="background:#fff;border-radius:10px;padding:18px;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,.07);display:flex;flex-direction:column;gap:8px;border:1px solid #e2e8f0;transition:box-shadow .15s"
            onmouseover="this.style.boxShadow='0 4px 14px rgba(0,0,0,.1)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.07)'">
            <span style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8">{{ $kpi['label'] }}</span>
            <span style="font-size:2rem;font-weight:800;color:{{ $kpi['color'] }};line-height:1">{{ $kpi['value'] }}</span>
        </a>
        @endforeach
    </div>

    {{-- Graficos --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:14px">

        {{-- Barras: Riscos por classificacao --}}
        <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1px solid #e2e8f0">
            <p style="font-size:.82rem;font-weight:700;color:#374151;margin-bottom:14px">Riscos por Classifica&ccedil;&atilde;o</p>
            @if($totalAvaliacoes === 0)
                <p style="font-size:.78rem;color:#9ca3af;font-style:italic">Sem avalia&ccedil;&otilde;es.</p>
            @else
            <div style="display:flex;flex-direction:column;gap:11px">
                @foreach($corCls as $key => $c)
                    @php $v = $classificacoes[$key] ?? 0; $pct = $totalAvaliacoes ? round($v/$totalAvaliacoes*100) : 0; @endphp
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:.75rem;margin-bottom:3px">
                            <span style="font-weight:600;color:{{ $c['text'] }}">{{ $c['label'] }}</span>
                            <span style="color:#94a3b8">{{ $v }} ({{ $pct }}%)</span>
                        </div>
                        <div style="height:9px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $c['border'] }};border-radius:99px"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Donut: Planos por status --}}
        <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1px solid #e2e8f0">
            <p style="font-size:.82rem;font-weight:700;color:#374151;margin-bottom:14px">Planos por Status</p>
            @if($totalPlanosStatus === 0)
                <p style="font-size:.78rem;color:#9ca3af;font-style:italic">Sem planos cadastrados.</p>
            @else
            @php
                $r = 36; $circ = 2*M_PI*$r;
                $dots = ['pendente'=>'#9ca3af','em_andamento'=>'#60a5fa','concluido'=>'#34d399'];
                $segs = []; $running = $circ * 0.25;
                foreach($corSt as $key=>$cs){
                    $v = $planosPorStatus[$key] ?? 0;
                    $dash = $totalPlanosStatus ? ($v/$totalPlanosStatus)*$circ : 0;
                    $segs[] = ['dash'=>$dash,'offset'=>$running,'color'=>$dots[$key],'label'=>$cs['label'],'v'=>$v];
                    $running -= $dash;
                }
            @endphp
            <div style="display:flex;align-items:center;gap:20px">
                <svg viewBox="0 0 100 100" style="width:86px;height:86px;flex-shrink:0">
                    @foreach($segs as $seg)
                    <circle cx="50" cy="50" r="{{ $r }}" fill="none"
                        stroke="{{ $seg['color'] }}" stroke-width="15"
                        stroke-dasharray="{{ round($seg['dash'],2) }} {{ round($circ,2) }}"
                        stroke-dashoffset="{{ round($seg['offset'],2) }}"
                        transform="rotate(-90 50 50)"/>
                    @endforeach
                    <text x="50" y="55" text-anchor="middle" font-size="15" font-weight="800" fill="#1e293b">{{ $totalPlanosStatus }}</text>
                </svg>
                <div style="display:flex;flex-direction:column;gap:8px;font-size:.78rem">
                    @foreach($segs as $seg)
                    <div style="display:flex;align-items:center;gap:7px">
                        <span style="width:9px;height:9px;border-radius:50%;background:{{ $seg['color'] }};flex-shrink:0"></span>
                        <span style="color:#374151">{{ $seg['label'] }}</span>
                        <span style="margin-left:auto;padding-left:12px;font-weight:700;color:#1e293b">{{ $seg['v'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Tabelas inferiores --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px">

        {{-- Criticos sem plano --}}
        <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1px solid #e2e8f0">
            <p style="font-size:.82rem;font-weight:700;color:#374151;margin-bottom:12px">Riscos Cr&iacute;ticos/Altos sem Plano</p>
            @if($riscosSemPlano->isEmpty())
                <div style="text-align:center;padding:16px 0">
                    <svg width="28" height="28" fill="none" stroke="#34d399" stroke-width="2" viewBox="0 0 24 24" style="margin:0 auto 6px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p style="font-size:.75rem;color:#6b7280">Todos cobertos!</p>
                </div>
            @else
                <div style="display:flex;flex-direction:column;gap:7px">
                    @foreach($riscosSemPlano as $risco)
                        @php $av = $risco->avaliacoes->first(); @endphp
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;background:#f8fafc;border-radius:6px;border:1px solid #e2e8f0;gap:8px">
                            <div style="min-width:0">
                                <p style="font-size:.78rem;font-weight:600;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $risco->riscoTipo->nome }}</p>
                                <p style="font-size:.68rem;color:#64748b">{{ $risco->ghe->nome }}</p>
                            </div>
                            @if($av)
                                @php $cc = $corCls[$av->classificacao] ?? null; @endphp
                                <div style="display:flex;align-items:center;gap:6px;flex-shrink:0">
                                    @if($cc)<span style="background:{{ $cc['bg'] }};color:{{ $cc['text'] }};padding:1px 8px;border-radius:99px;font-size:.68rem;font-weight:700">{{ $cc['label'] }}</span>@endif
                                    <a href="{{ route('avaliacoes.show', $av->id) }}" style="font-size:.72rem;color:#6366f1;font-weight:600">Ver &rarr;</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Proximos planos --}}
        <div style="background:#fff;border-radius:10px;padding:20px;box-shadow:0 1px 3px rgba(0,0,0,.07);border:1px solid #e2e8f0">
            <p style="font-size:.82rem;font-weight:700;color:#374151;margin-bottom:12px">Pr&oacute;ximos Planos a Vencer</p>
            @if($proximosPlanos->isEmpty())
                <p style="font-size:.75rem;color:#9ca3af;font-style:italic;text-align:center;padding:16px 0">Nenhum plano em aberto.</p>
            @else
                <div style="display:flex;flex-direction:column;gap:7px">
                    @foreach($proximosPlanos as $plano)
                        @php
                            $dias = now()->diffInDays($plano->prazo, false);
                            $corDia = $dias < 0 ? '#dc2626' : ($dias <= 7 ? '#d97706' : '#374151');
                            $cs = $corSt[$plano->status] ?? $corSt['pendente'];
                        @endphp
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;background:#f8fafc;border-radius:6px;border:1px solid #e2e8f0;gap:8px">
                            <div style="min-width:0">
                                <p style="font-size:.78rem;font-weight:600;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $plano->avaliacaoRisco->riscoInventario->riscoTipo->nome }}</p>
                                <p style="font-size:.68rem;color:#64748b">{{ $plano->responsavel }}</p>
                            </div>
                            <div style="text-align:right;flex-shrink:0">
                                <p style="font-size:.72rem;font-weight:700;color:{{ $corDia }}">
                                    @if($dias < 0) {{ abs((int)$dias) }}d atrasado
                                    @elseif($dias == 0) Hoje
                                    @else {{ (int)$dias }}d
                                    @endif
                                </p>
                                <span style="background:{{ $cs['bg'] }};color:{{ $cs['text'] }};padding:1px 7px;border-radius:99px;font-size:.65rem;font-weight:600">{{ $cs['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
