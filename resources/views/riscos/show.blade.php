@extends('layouts.app')

@section('titulo', $risco->agente ?? $risco->fonte_geradora)

@section('conteudo')
<div style="max-width:840px">

    {{-- Breadcrumb --}}
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">← Inventário</a>
        <span>/</span>
        <a href="{{ route('ghes.show', $risco->ghe) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->nome }}</a>
        <span>/</span>
        <a href="{{ route('setores.show', $risco->ghe->setor) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->setor->nome }}</a>
        <span>/</span>
        <a href="{{ route('unidades.show', $risco->ghe->setor->unidade) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->ghe->setor->unidade->nome }}</a>
    </div>

    @php
        $cor = match($risco->classificacao_calculada) {
            'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca','label'=>'Crítico'],
            'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa','label'=>'Alto'],
            'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a','label'=>'Moderado'],
            'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0','label'=>'Baixo'],
            default    => null,
        };
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
        @can('update', $risco)
        <a href="{{ route('riscos.edit', $risco) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- Grid de campos --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px">

        @php
        $campos = [
            'Fonte Geradora'              => $risco->fonte_geradora,
            'Via de Absorção'             => $risco->via_absorcao,
            'Técnica Utilizada'           => $risco->tecnica_utilizada,
            'GHE'                         => $risco->ghe->nome,
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
        'Possíveis Lesões'             => $risco->possiveis_lesoes,
        'Danos à Saúde'                => $risco->danos_saude,
        'Medidas de Controle Existentes'=> $risco->medidas_existentes,
        'Observações'                  => $risco->observacoes,
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
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                Avaliações
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $risco->avaliacoes->count() }})</span>
            </h3>
        </div>
        @if($risco->avaliacoes->isEmpty())
            <div style="padding:28px;text-align:center">
                <p style="font-size:.85rem;color:#94a3b8;margin:0">Nenhuma avaliação registrada para este risco.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Data</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Resultado</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Responsável</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($risco->avaliacoes->sortByDesc('created_at') as $av)
                    <tr style="border-top:1px solid #f1f5f9">
                        <td style="padding:10px 16px;font-size:.82rem;color:#475569">{{ $av->created_at->format('d/m/Y') }}</td>
                        <td style="padding:10px 16px;font-size:.82rem;color:#374151">{{ $av->resultado ?? $av->conclusao ?? '—' }}</td>
                        <td style="padding:10px 16px;font-size:.82rem;color:#64748b">{{ $av->responsavel ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
