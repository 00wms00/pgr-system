@extends('layouts.app')

@section('titulo', 'Avaliação ' . $avaliacao->data_avaliacao->format('d/m/Y'))

@section('conteudo')
<div style="max-width:840px">

    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;margin-bottom:20px;flex-wrap:wrap">
        <a href="{{ route('riscos.index') }}" style="color:#64748b;text-decoration:none">Inventário</a>
        <span>/</span>
        <a href="{{ route('riscos.show', $risco) }}" style="color:#3b82f6;text-decoration:none">{{ $risco->agente ?? $risco->fonte_geradora }}</a>
        <span>/</span>
        <a href="{{ route('riscos.avaliacoes.index', $risco) }}" style="color:#3b82f6;text-decoration:none">Avaliações</a>
        <span>/</span>
        <span>{{ $avaliacao->data_avaliacao->format('d/m/Y') }}</span>
    </div>

    @php
        $cor = match($avaliacao->classificacao) {
            'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','border'=>'#fecaca','label'=>'Crítico'],
            'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','border'=>'#fed7aa','label'=>'Alto'],
            'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','border'=>'#fef08a','label'=>'Moderado'],
            'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','border'=>'#bbf7d0','label'=>'Baixo'],
            default    => ['bg'=>'#f8fafc','text'=>'#475569','border'=>'#e2e8f0','label'=>'—'],
        };
    @endphp

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div style="display:flex;align-items:center;gap:16px">
            {{-- Nível visual --}}
            <div style="width:64px;height:64px;border-radius:10px;background:{{ $cor['bg'] }};border:1px solid {{ $cor['border'] }};display:flex;flex-direction:column;align-items:center;justify-content:center">
                <span style="font-size:1.6rem;font-weight:900;color:{{ $cor['text'] }};line-height:1">{{ $avaliacao->nivel_risco }}</span>
                <span style="font-size:.6rem;font-weight:700;color:{{ $cor['text'] }};text-transform:uppercase;letter-spacing:.04em">{{ $cor['label'] }}</span>
            </div>
            <div>
                <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 4px">
                    P{{ $avaliacao->probabilidade }} &times; S{{ $avaliacao->severidade }} = {{ $avaliacao->nivel_risco }}
                </h2>
                <p style="font-size:.8rem;color:#64748b;margin:0">
                    {{ $avaliacao->data_avaliacao->format('d/m/Y') }}
                    @if($avaliacao->avaliador)
                    &middot; <strong>{{ $avaliacao->avaliador->name }}</strong>
                    @endif
                    @if($avaliacao->metodologia)
                    &middot;
                    {{ match($avaliacao->metodologia) {
                        'qualitativo'       => 'Qualitativo',
                        'quantitativo'      => 'Quantitativo',
                        'semi_quantitativo' => 'Semi-quantitativo',
                        default             => $avaliacao->metodologia,
                    } }}
                    @endif
                </p>
            </div>
        </div>
        @can('update', $avaliacao)
        <a href="{{ route('avaliacoes.edit', $avaliacao) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- Justificativa --}}
    @if($avaliacao->justificativa)
    <div style="background:#fff;border-radius:8px;border:1px solid #e2e8f0;padding:16px;margin-bottom:16px">
        <p style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 6px">Justificativa / Contexto</p>
        <p style="font-size:.88rem;color:#374151;margin:0;line-height:1.6">{{ $avaliacao->justificativa }}</p>
    </div>
    @endif

    {{-- Matriz de Risco visual (5x5) --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:20px;margin-bottom:16px">
        <h3 style="font-size:.85rem;font-weight:700;color:#374151;margin:0 0 14px">Matriz de Risco 5×5</h3>
        <div style="overflow-x:auto">
            <table style="border-collapse:collapse;min-width:320px">
                <thead>
                    <tr>
                        <th style="width:48px"></th>
                        @for($s = 1; $s <= 5; $s++)
                        <th style="padding:6px 4px;text-align:center;font-size:.7rem;font-weight:600;color:#64748b">S{{ $s }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @for($p = 5; $p >= 1; $p--)
                    <tr>
                        <td style="padding:4px 8px;font-size:.7rem;font-weight:600;color:#64748b;text-align:right">P{{ $p }}</td>
                        @for($s = 1; $s <= 5; $s++)
                        @php
                            $n = $p * $s;
                            $cls = $n <= 4 ? 'baixo' : ($n <= 9 ? 'moderado' : ($n <= 16 ? 'alto' : 'critico'));
                            $bg  = ['baixo'=>'#dcfce7','moderado'=>'#fef9c3','alto'=>'#ffedd5','critico'=>'#fee2e2'][$cls];
                            $ativo = ($p === $avaliacao->probabilidade && $s === $avaliacao->severidade);
                        @endphp
                        <td style="width:40px;height:36px;text-align:center;background:{{ $bg }};border:1px solid #fff;font-size:.72rem;font-weight:{{ $ativo ? '900' : '500' }};color:#374151;{{ $ativo ? 'outline:2px solid #1e40af;outline-offset:-2px;' : '' }}">
                            {{ $n }}
                        </td>
                        @endfor
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <p style="font-size:.73rem;color:#94a3b8;margin:8px 0 0">A célula destacada em azul representa o ponto avaliado.</p>
    </div>

    {{-- Planos de Ação vinculados --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                Planos de Ação
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $avaliacao->planosAcao->count() }})</span>
            </h3>
        </div>
        @if($avaliacao->planosAcao->isEmpty())
        <div style="padding:28px;text-align:center">
            <p style="font-size:.85rem;color:#94a3b8;margin:0">Nenhum plano de ação vinculado a esta avaliação.</p>
        </div>
        @else
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc">
                    <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Ação</th>
                    <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Responsável</th>
                    <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Prazo</th>
                    <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($avaliacao->planosAcao as $plano)
                <tr style="border-top:1px solid #f1f5f9">
                    <td style="padding:10px 16px;font-size:.82rem;color:#374151">{{ Str::limit($plano->acao ?? $plano->descricao, 80) }}</td>
                    <td style="padding:10px 16px;font-size:.82rem;color:#475569">{{ $plano->responsavel ?? '—' }}</td>
                    <td style="padding:10px 16px;font-size:.82rem;color:#475569">{{ $plano->prazo ? \Carbon\Carbon::parse($plano->prazo)->format('d/m/Y') : '—' }}</td>
                    <td style="padding:10px 16px">
                        <span style="font-size:.75rem;font-weight:600;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:5px">
                            {{ ucfirst($plano->status ?? 'pendente') }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection
