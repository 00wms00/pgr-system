@extends('layouts.app')

@section('titulo', 'Plano de Ação')

@section('conteudo')
<div style="max-width:840px">

    @php
        $avaliacao = $plano->avaliacaoRisco;
        $risco     = $avaliacao->riscoInventario;
        $c         = App\Models\PlanoAcao::STATUS_CORES[$plano->status] ?? ['bg'=>'#f8fafc','text'=>'#475569'];
        $vencido   = $plano->status !== 'concluido' && $plano->prazo->isPast();
    @endphp

    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;margin-bottom:20px;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">Inventário</a>
        <span>/</span>
        <a href="{{ route('riscos.show', $risco) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->agente ?? $risco->fonte_geradora }}</a>
        <span>/</span>
        <a href="{{ route('avaliacoes.show', $avaliacao) }}" style="color:#3b82f6;text-decoration:none">Avaliação {{ $avaliacao->data_avaliacao->format('d/m/Y') }}</a>
        <span>/</span>
        <a href="{{ route('avaliacoes.planos.index', $avaliacao) }}" style="color:#3b82f6;text-decoration:none">Planos</a>
        <span>/</span>
        <span>Plano #{{ $plano->id }}</span>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap">
                <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">
                    {{ App\Models\PlanoAcao::TIPOS_CONTROLE[$plano->tipo_controle] ?? $plano->tipo_controle }}
                </h2>
                <span style="font-size:.73rem;font-weight:600;background:{{ $c['bg'] }};color:{{ $c['text'] }};padding:2px 10px;border-radius:20px">
                    {{ App\Models\PlanoAcao::STATUS[$plano->status] ?? $plano->status }}
                </span>
                @if($vencido)
                <span style="font-size:.73rem;font-weight:600;background:#fef2f2;color:#991b1b;padding:2px 8px;border-radius:20px">
                    Vencido
                </span>
                @endif
            </div>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                {{ $risco->agente ?? $risco->fonte_geradora }}
                &middot; GHE {{ $risco->ghe->nome }}
            </p>
        </div>
        @can('update', $plano)
        <a href="{{ route('planos.edit', $plano) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- Detalhes principais --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:20px;margin-bottom:14px">
        <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 8px">Descrição da Ação</p>
        <p style="font-size:.95rem;color:#1e293b;line-height:1.65;margin:0">{{ $plano->descricao }}</p>
    </div>

    {{-- Meta --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
        <div style="background:#fff;border-radius:8px;border:1px solid #e2e8f0;padding:14px 16px">
            <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 4px">Responsável</p>
            <p style="font-size:.9rem;font-weight:600;color:#1e293b;margin:0">{{ $plano->responsavel }}</p>
        </div>
        <div style="background:#fff;border-radius:8px;border:{{ $vencido ? '1px solid #fca5a5' : '1px solid #e2e8f0' }};padding:14px 16px">
            <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 4px">Prazo</p>
            <p style="font-size:.9rem;font-weight:600;color:{{ $vencido ? '#ef4444' : '#1e293b' }};margin:0">
                {{ $plano->prazo->format('d/m/Y') }}
                @if($vencido)
                <span style="font-size:.75rem;font-weight:500;color:#ef4444;margin-left:6px">({{ $plano->prazo->diffForHumans() }})</span>
                @else
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $plano->prazo->diffForHumans() }})</span>
                @endif
            </p>
        </div>
    </div>

    @if($plano->observacao)
    <div style="background:#fff;border-radius:8px;border:1px solid #e2e8f0;padding:14px 16px;margin-bottom:14px">
        <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 6px">Observação</p>
        <p style="font-size:.88rem;color:#374151;line-height:1.6;margin:0">{{ $plano->observacao }}</p>
    </div>
    @endif

    {{-- Contexto da Avaliação --}}
    <div style="background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;padding:14px 16px">
        <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 8px">Avaliação de Origem</p>
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
            @php
                $corAv = match($avaliacao->classificacao) {
                    'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca'],
                    'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa'],
                    'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a'],
                    default    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0'],
                };
            @endphp
            <div style="width:44px;height:44px;border-radius:8px;background:{{ $corAv['bg'] }};border:1px solid {{ $corAv['border'] }};display:flex;flex-direction:column;align-items:center;justify-content:center">
                <span style="font-size:1rem;font-weight:900;color:{{ $corAv['text'] }};line-height:1">{{ $avaliacao->nivel_risco }}</span>
                <span style="font-size:.55rem;font-weight:700;color:{{ $corAv['text'] }};text-transform:uppercase">{{ ucfirst($avaliacao->classificacao) }}</span>
            </div>
            <div>
                <p style="font-size:.85rem;font-weight:600;color:#374151;margin:0">P{{ $avaliacao->probabilidade }} &times; S{{ $avaliacao->severidade }}</p>
                <p style="font-size:.78rem;color:#64748b;margin:0">{{ $avaliacao->data_avaliacao->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('avaliacoes.show', $avaliacao) }}"
                style="font-size:.8rem;color:#3b82f6;text-decoration:none;margin-left:auto">
                Ver avaliação →
            </a>
        </div>
    </div>

</div>
@endsection
