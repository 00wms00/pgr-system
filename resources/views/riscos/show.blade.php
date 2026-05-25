@extends('layouts.app')

@section('titulo', $risco->agente ?? $risco->fonte_geradora)

@section('conteudo')
<div style="max-width:840px">

    {{-- Breadcrumb --}}
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">← Inventário</a>
        <span>/</span>
        <a href="{{ route('unidades.show', $risco->ghe->setor->unidade) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->setor->unidade->nome }}</a>
        <span>/</span>
        <a href="{{ route('setores.show', $risco->ghe->setor) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->setor->nome }}</a>
        <span>/</span>
        <a href="{{ route('ghes.show', $risco->ghe) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->nome }}</a>
    </div>

    @php
        $cor = match($risco->classificacao_calculada) {
            'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca','label'=>'Crítico'],
            'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa','label'=>'Alto'],
            'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a','label'=>'Moderado'],
            'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0','label'=>'Baixo'],
            default    => null,
        };

        $corCls = [
            'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca','label'=>'Crítico'],
            'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa','label'=>'Alto'],
            'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a','label'=>'Moderado'],
            'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0','label'=>'Baixo'],
        ];
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:4px">
                <h2 style="font-size:1.2rem;font-weight:700;color:#1e293b;margin:0">{{ $risco->agente ?? $risco->fonte_geradora }}</h2>
                @if($cor)
                <span style="background:{{ $cor['bg'] }};color:{{ $cor['text'] }};border:1px solid {{ $cor['border'] }};padding:2px 10px;border-radius:20px;font-size:.72rem;font-weight:600">
                    {{ $cor['label'] }}
                </span>
                @endif
            </div>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                <span style="background:#f1f5f9;padding:1px 7px;border-radius:4px;font-size:.75rem;font-weight:600;color:#475569">{{ $risco->riscoTipo->codigo_esocial }}</span>
                {{ $risco->riscoTipo->nome }} &middot; {{ $risco->riscoTipo->grupo }}
            </p>
        </div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            @can('create', [App\Models\AvaliacaoRisco::class, $risco])
            <a href="{{ route('riscos.avaliacoes.create', $risco) }}"
               style="display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;padding:8px 16px;border-radius:8px;font-size:.83rem;font-weight:600;text-decoration:none">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Nova Avaliação
            </a>
            @endcan
            @can('update', $risco)
            <a href="{{ route('riscos.edit', $risco) }}"
               style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:8px 14px;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
            @endcan
        </div>
    </div>

    {{-- Grid de campos --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">
        @php
        $campos = [
            'Fonte Geradora'  => $risco->fonte_geradora,
            'Via de Absorção' => $risco->via_absorcao,
            'Técnica Utilizada'=> $risco->tecnica_utilizada,
            'GHE'             => $risco->ghe->nome,
        ];
        @endphp
        @foreach($campos as $label => $valor)
        @if($valor)
        <div style="background:#fff;border-radius:8px;border:1px solid #e2e8f0;padding:14px 16px">
            <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 4px">{{ $label }}</p>
            <p style="font-size:.88rem;color:#1e293b;margin:0">{{ $valor }}</p>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Textos longos --}}
    @foreach([
        'Possíveis Lesões'              => $risco->possiveis_lesoes,
        'Danos à Saúde'                 => $risco->danos_saude,
        'Medidas de Controle Existentes' => $risco->medidas_existentes,
        'Observações'                   => $risco->observacoes,
    ] as $label => $valor)
    @if($valor)
    <div style="background:#fff;border-radius:8px;border:1px solid #e2e8f0;padding:14px 16px;margin-bottom:12px">
        <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 6px">{{ $label }}</p>
        <p style="font-size:.88rem;color:#374151;margin:0;line-height:1.6">{{ $valor }}</p>
    </div>
    @endif
    @endforeach

    {{-- Medição Quantitativa --}}
    @if($risco->valor_medido || $risco->classificacao_calculada)
    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:16px;margin-bottom:16px">
        <h3 style="font-size:.82rem;font-weight:700;color:#0369a1;margin:0 0 12px">Medição Quantitativa</h3>
        <div style="display:flex;gap:24px;flex-wrap:wrap">
            @if($risco->valor_medido)
            <div>
                <p style="font-size:.72rem;color:#0284c7;font-weight:600;margin:0 0 2px">Valor Medido</p>
                <p style="font-size:1.1rem;font-weight:700;color:#0369a1;margin:0">{{ $risco->valor_medido }}</p>
            </div>
            @endif
            @if($risco->probabilidade_calculada)
            <div>
                <p style="font-size:.72rem;color:#64748b;font-weight:600;margin:0 0 2px">Probabilidade</p>
                <p style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">{{ $risco->probabilidade_calculada }}/5</p>
            </div>
            @endif
            @if($risco->severidade_calculada)
            <div>
                <p style="font-size:.72rem;color:#64748b;font-weight:600;margin:0 0 2px">Severidade</p>
                <p style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">{{ $risco->severidade_calculada }}/5</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Avaliações --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;margin-bottom:8px">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:10px">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                Avaliações
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $risco->avaliacoes->count() }})</span>
            </h3>
            @can('create', [App\Models\AvaliacaoRisco::class, $risco])
            <a href="{{ route('riscos.avaliacoes.create', $risco) }}"
               style="display:inline-flex;align-items:center;gap:5px;background:#eff6ff;color:#2563eb;padding:5px 12px;border-radius:6px;font-size:.78rem;font-weight:600;text-decoration:none">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Nova
            </a>
            @endcan
        </div>

        @if($risco->avaliacoes->isEmpty())
            <div style="padding:32px;text-align:center">
                <svg width="32" height="32" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
                <p style="font-size:.85rem;color:#94a3b8;margin:0 0 12px">Nenhuma avaliação registrada.</p>
                @can('create', [App\Models\AvaliacaoRisco::class, $risco])
                <a href="{{ route('riscos.avaliacoes.create', $risco) }}"
                   style="display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;padding:8px 16px;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Registrar primeira avaliação
                </a>
                @endcan
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Data</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Classificação</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Nível (P×S)</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Planos</th>
                        <th style="padding:9px 16px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($risco->avaliacoes->sortByDesc('data_avaliacao') as $av)
                    @php
                        $cc = $corCls[$av->classificacao] ?? null;
                        $nPlanos = $av->planosAcao->count();
                    @endphp
                    <tr style="border-top:1px solid #f1f5f9;transition:background .1s" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <td style="padding:10px 16px;font-size:.82rem;color:#475569">
                            {{ \Carbon\Carbon::parse($av->data_avaliacao)->format('d/m/Y') }}
                        </td>
                        <td style="padding:10px 16px">
                            @if($cc)
                            <span style="background:{{ $cc['bg'] }};color:{{ $cc['text'] }};border:1px solid {{ $cc['border'] }};padding:2px 9px;border-radius:20px;font-size:.7rem;font-weight:700">
                                {{ $cc['label'] }}
                            </span>
                            @else
                                <span style="color:#94a3b8;font-size:.8rem">—</span>
                            @endif
                        </td>
                        <td style="padding:10px 16px;font-size:.82rem;color:#374151;font-variant-numeric:tabular-nums">
                            @if($av->nivel_risco)
                                {{ $av->probabilidade }}×{{ $av->severidade }} = <strong>{{ $av->nivel_risco }}</strong>
                            @else
                                —
                            @endif
                        </td>
                        <td style="padding:10px 16px">
                            @if($nPlanos > 0)
                                <span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:20px;font-size:.7rem;font-weight:600">{{ $nPlanos }} plano{{ $nPlanos > 1 ? 's' : '' }}</span>
                            @else
                                <span style="background:#f1f5f9;color:#94a3b8;padding:2px 8px;border-radius:20px;font-size:.7rem">sem plano</span>
                            @endif
                        </td>
                        <td style="padding:10px 16px;text-align:right">
                            {{-- rota shallow: avaliacoes.show recebe só o id da avaliação --}}
                            <a href="{{ route('avaliacoes.show', $av) }}"
                               style="font-size:.78rem;font-weight:600;color:#2563eb;text-decoration:none">
                                Ver &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
