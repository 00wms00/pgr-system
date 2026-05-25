@extends('layouts.app')

@section('titulo', 'Avaliações — ' . ($risco->agente ?? $risco->fonte_geradora))

@section('conteudo')
<div style="max-width:900px">

    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;margin-bottom:20px;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">Inventário</a>
        <span>/</span>
        <a href="{{ route('riscos.show', $risco) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->agente ?? $risco->fonte_geradora }}</a>
        <span>/</span>
        <span>Avaliações</span>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 4px">Avaliações de Risco</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                {{ $risco->agente ?? $risco->fonte_geradora }}
                &mdash;
                <span style="background:#f1f5f9;padding:1px 7px;border-radius:4px;font-size:.73rem;font-weight:600;color:#475569">{{ $risco->riscoTipo->codigo_esocial }}</span>
                {{ $risco->ghe->nome }} / {{ $risco->ghe->setor->nome }}
            </p>
        </div>
        @can('create', [App\Models\AvaliacaoRisco::class, $risco])
        <a href="{{ route('riscos.avaliacoes.create', $risco) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nova Avaliação
        </a>
        @endcan
    </div>

    @if($avaliacoes->isEmpty())
        <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0">
            <svg width="36" height="36" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p style="font-size:.9rem;font-weight:600;color:#475569;margin:0 0 4px">Nenhuma avaliação registrada</p>
            <p style="font-size:.8rem;color:#94a3b8;margin:0 0 16px">Registre a primeira avaliação de probabilidade e severidade.</p>
            @can('create', [App\Models\AvaliacaoRisco::class, $risco])
            <a href="{{ route('riscos.avaliacoes.create', $risco) }}"
                style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
                Registrar Avaliação
            </a>
            @endcan
        </div>
    @else
        <div style="display:grid;gap:12px">
            @foreach($avaliacoes as $av)
            @php
                $cor = match($av->classificacao) {
                    'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca','dot'=>'#ef4444','label'=>'Crítico'],
                    'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa','dot'=>'#f97316','label'=>'Alto'],
                    'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a','dot'=>'#eab308','label'=>'Moderado'],
                    'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0','dot'=>'#22c55e','label'=>'Baixo'],
                    default    => ['bg'=>'#f8fafc','text'=>'#475569','border'=>'#e2e8f0','dot'=>'#94a3b8','label'=>'—'],
                };
            @endphp
            <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px 20px">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap">
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                        {{-- Badge de classificação --}}
                        <div style="min-width:56px;text-align:center">
                            <div style="width:48px;height:48px;border-radius:8px;background:{{ $cor['bg'] }};border:1px solid {{ $cor['border'] }};display:flex;align-items:center;justify-content:center;margin:0 auto">
                                <span style="font-size:1.1rem;font-weight:800;color:{{ $cor['text'] }}">{{ $av->nivel_risco }}</span>
                            </div>
                            <p style="font-size:.65rem;font-weight:700;color:{{ $cor['text'] }};margin:3px 0 0;text-transform:uppercase;letter-spacing:.04em">{{ $cor['label'] }}</p>
                        </div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                                <span style="font-size:.9rem;font-weight:700;color:#1e293b">P{{ $av->probabilidade }} &times; S{{ $av->severidade }}</span>
                                <span style="font-size:.73rem;background:#f1f5f9;color:#64748b;padding:1px 7px;border-radius:4px">
                                    {{ match($av->metodologia) {
                                        'qualitativo'       => 'Qualitativo',
                                        'quantitativo'      => 'Quantitativo',
                                        'semi_quantitativo' => 'Semi-quantitativo',
                                        default             => 'Método n/i',
                                    } }}
                                </span>
                            </div>
                            <p style="font-size:.78rem;color:#64748b;margin:0">
                                {{ $av->data_avaliacao->format('d/m/Y') }}
                                @if($av->avaliador)
                                &middot; Avaliado por <strong style="color:#475569">{{ $av->avaliador->name }}</strong>
                                @endif
                            </p>
                            @if($av->justificativa)
                            <p style="font-size:.8rem;color:#374151;margin:6px 0 0;max-width:600px">{{ Str::limit($av->justificativa, 120) }}</p>
                            @endif
                        </div>
                    </div>
                    <div style="display:flex;gap:6px;align-items:center">
                        <a href="{{ route('avaliacoes.show', $av) }}" title="Ver"
                            style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @can('update', $av)
                        <a href="{{ route('avaliacoes.edit', $av) }}" title="Editar"
                            style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @endcan
                        @can('delete', $av)
                        <form method="POST" action="{{ route('avaliacoes.destroy', $av) }}"
                            onsubmit="return confirm('Remover esta avaliação?')">
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
        @if($avaliacoes->hasPages())
        <div style="margin-top:16px">{{ $avaliacoes->links() }}</div>
        @endif
    @endif
</div>
@endsection
