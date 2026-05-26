@extends('layouts.app')
@section('titulo', 'Planos de Ação')

@section('conteudo')
@php
    $statusOpcoes = [
        ''             => 'Todos',
        'em_andamento' => 'Em andamento',
        'pendente'     => 'Pendente',
        'concluido'    => 'Concluído',
    ];
    $statusCores = [
        'em_andamento' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
        'concluido'    => ['bg' => '#f0fdf4', 'text' => '#15803d'],
        'pendente'     => ['bg' => '#f8fafc', 'text' => '#475569'],
    ];
    $statusLabels = [
        'em_andamento' => 'Em andamento',
        'concluido'    => 'Concluído',
        'pendente'     => 'Pendente',
    ];
    $totalGeral = array_sum($totaisPorStatus);
@endphp

<div style="max-width:1100px">

    {{-- Cabeçalho --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.2rem;font-weight:800;color:#1e293b;margin:0 0 4px">Planos de Ação</h2>
            <p style="font-size:.8rem;color:#94a3b8;margin:0">{{ $totalGeral }} plano{{ $totalGeral !== 1 ? 's' : '' }} cadastrado{{ $totalGeral !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    {{-- Totalizadores por status --}}
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
        @foreach(['em_andamento' => ['cor'=>'#3b82f6','label'=>'Em andamento'], 'pendente' => ['cor'=>'#94a3b8','label'=>'Pendente'], 'concluido' => ['cor'=>'#22c55e','label'=>'Concluído']] as $k => $info)
        <div style="background:#fff;border:1px solid #f1f5f9;border-radius:10px;padding:12px 18px;display:flex;align-items:center;gap:10px;min-width:130px">
            <span style="width:10px;height:10px;border-radius:50%;background:{{ $info['cor'] }};flex-shrink:0"></span>
            <div>
                <p style="font-size:1.3rem;font-weight:800;color:#1e293b;margin:0;line-height:1">{{ $totaisPorStatus[$k] ?? 0 }}</p>
                <p style="font-size:.7rem;color:#94a3b8;margin:2px 0 0">{{ $info['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('planos.all') }}"
          style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;align-items:center">
        <input type="text" name="busca" value="{{ $busca }}"
               placeholder="Buscar por ação ou responsável…"
               style="flex:1;min-width:200px;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#374151;outline:none">
        <select name="status"
                style="padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#374151;background:#fff">
            @foreach($statusOpcoes as $val => $label)
            <option value="{{ $val }}" {{ $status === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit"
                style="padding:8px 16px;background:#0f766e;color:#fff;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer">
            Filtrar
        </button>
        @if($busca || $status)
        <a href="{{ route('planos.all') }}"
           style="padding:8px 12px;font-size:.82rem;color:#64748b;text-decoration:none">Limpar</a>
        @endif
    </form>

    {{-- Tabela --}}
    <div style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;overflow:hidden">
        @if($planos->isEmpty())
        <div style="padding:48px;text-align:center">
            <svg width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p style="font-size:.88rem;color:#94a3b8;margin:0">Nenhum plano encontrado.</p>
        </div>
        @else
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Ação</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Risco</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Responsável</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Prazo</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Status</th>
                    <th style="padding:10px 16px;text-align:center;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($planos as $plano)
                @php
                    $sc     = $statusCores[$plano->status] ?? $statusCores['pendente'];
                    $sl     = $statusLabels[$plano->status] ?? 'Pendente';
                    $dias   = $plano->prazo ? (int) now()->diffInDays($plano->prazo, false) : null;
                    $atrasado = $dias !== null && $dias < 0 && $plano->status !== 'concluido';
                @endphp
                <tr style="border-top:1px solid #f1f5f9;{{ $atrasado ? 'background:#fff5f5;' : '' }}">
                    <td style="padding:11px 16px;font-size:.83rem;color:#374151;max-width:240px">
                        {{ Str::limit($plano->acao ?? $plano->descricao, 70) }}
                    </td>
                    <td style="padding:11px 16px;font-size:.8rem;color:#475569">
                        {{ $plano->avaliacaoRisco?->riscoInventario?->riscoTipo?->nome ?? '—' }}
                    </td>
                    <td style="padding:11px 16px;font-size:.82rem;color:#475569">
                        {{ $plano->responsavel ?? '—' }}
                    </td>
                    <td style="padding:11px 16px;font-size:.82rem;white-space:nowrap">
                        @if($plano->prazo)
                            <span style="color:{{ $atrasado ? '#dc2626' : '#475569' }};font-weight:{{ $atrasado ? '700' : '400' }}">
                                {{ \Carbon\Carbon::parse($plano->prazo)->format('d/m/Y') }}
                            </span>
                            @if($atrasado)
                            <span style="font-size:.7rem;color:#dc2626;display:block">{{ abs($dias) }}d atrasado</span>
                            @endif
                        @else
                            <span style="color:#cbd5e1">—</span>
                        @endif
                    </td>
                    <td style="padding:11px 16px">
                        <span style="font-size:.75rem;font-weight:600;background:{{ $sc['bg'] }};color:{{ $sc['text'] }};padding:3px 9px;border-radius:5px">
                            {{ $sl }}
                        </span>
                    </td>
                    <td style="padding:11px 16px;text-align:center;white-space:nowrap">
                        <a href="{{ route('planos.show', $plano) }}"
                           title="Ver"
                           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#475569;text-decoration:none;margin-right:3px">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="{{ route('planos.edit', $plano) }}"
                           title="Editar"
                           style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;background:#f1f5f9;color:#475569;text-decoration:none">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Paginação --}}
        @if($planos->hasPages())
        <div style="padding:14px 16px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end">
            {{ $planos->links() }}
        </div>
        @endif
        @endif
    </div>

</div>
@endsection
