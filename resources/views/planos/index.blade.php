@extends('layouts.app')

@section('titulo', 'Planos de Ação')

@section('conteudo')
<div style="max-width:920px">

    {{-- Breadcrumb --}}
    @php
        $risco = $avaliacao->riscoInventario;
    @endphp
    <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;margin-bottom:20px;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">Inventário</a>
        <span>/</span>
        <a href="{{ route('riscos.show', $risco) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->agente ?? $risco->fonte_geradora }}</a>
        <span>/</span>
        <a href="{{ route('avaliacoes.show', $avaliacao) }}" style="color:#3b82f6;text-decoration:none">Avaliação {{ $avaliacao->data_avaliacao->format('d/m/Y') }}</a>
        <span>/</span>
        <span>Planos de Ação</span>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 4px">Planos de Ação</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                {{ $risco->agente ?? $risco->fonte_geradora }}
                &mdash; Avaliação {{ $avaliacao->data_avaliacao->format('d/m/Y') }}
                &middot; Nível <strong>{{ $avaliacao->nivel_risco }}</strong>
            </p>
        </div>
        @can('create', [App\Models\PlanoAcao::class, $avaliacao])
        <a href="{{ route('avaliacoes.planos.create', $avaliacao) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Novo Plano
        </a>
        @endcan
    </div>

    @if($planos->isEmpty())
        <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0">
            <svg width="36" height="36" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p style="font-size:.9rem;font-weight:600;color:#475569;margin:0 0 4px">Nenhum plano cadastrado</p>
            <p style="font-size:.8rem;color:#94a3b8;margin:0 0 16px">Defina as ações para eliminar ou reduzir este risco.</p>
            @can('create', [App\Models\PlanoAcao::class, $avaliacao])
            <a href="{{ route('avaliacoes.planos.create', $avaliacao) }}"
                style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
                Cadastrar Plano
            </a>
            @endcan
        </div>
    @else
        <div style="display:grid;gap:10px">
            @foreach($planos as $plano)
            @php
                $c   = App\Models\PlanoAcao::STATUS_CORES[$plano->status] ?? ['bg'=>'#f8fafc','text'=>'#475569'];
                $vencido = $plano->status !== 'concluido' && $plano->prazo->isPast();
            @endphp
            <div style="background:#fff;border-radius:10px;border:1px solid {{ $vencido ? '#fca5a5' : '#e2e8f0' }};padding:16px 20px">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap">
                    <div style="flex:1;min-width:0">
                        {{-- Tipo + Status --}}
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap">
                            <span style="font-size:.75rem;font-weight:700;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:5px">
                                {{ App\Models\PlanoAcao::TIPOS_CONTROLE[$plano->tipo_controle] ?? $plano->tipo_controle }}
                            </span>
                            <span style="font-size:.73rem;font-weight:600;background:{{ $c['bg'] }};color:{{ $c['text'] }};padding:2px 8px;border-radius:20px">
                                {{ App\Models\PlanoAcao::STATUS[$plano->status] ?? $plano->status }}
                            </span>
                            @if($vencido)
                            <span style="font-size:.73rem;font-weight:600;background:#fef2f2;color:#991b1b;padding:2px 8px;border-radius:20px">
                                Vencido
                            </span>
                            @endif
                        </div>
                        {{-- Descrição --}}
                        <p style="font-size:.88rem;color:#1e293b;font-weight:500;margin:0 0 4px">
                            {{ Str::limit($plano->descricao, 120) }}
                        </p>
                        {{-- Meta --}}
                        <p style="font-size:.77rem;color:#64748b;margin:0">
                            <strong>Responsável:</strong> {{ $plano->responsavel }}
                            &middot;
                            <strong>Prazo:</strong>
                            <span style="color:{{ $vencido ? '#ef4444' : '#475569' }}">{{ $plano->prazo->format('d/m/Y') }}</span>
                        </p>
                    </div>
                    {{-- Ações --}}
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0">
                        <a href="{{ route('planos.show', $plano) }}" title="Ver"
                            style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @can('update', $plano)
                        <a href="{{ route('planos.edit', $plano) }}" title="Editar"
                            style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @endcan
                        @can('delete', $plano)
                        <form method="POST" action="{{ route('planos.destroy', $plano) }}"
                            onsubmit="return confirm('Remover este plano de ação?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Remover"
                                style="width:30px;height:30px;border-radius:6px;background:#fef2f2;border:none;display:inline-flex;align-items:center;justify-content:center;color:#ef4444;cursor:pointer">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
