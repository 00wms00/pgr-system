@extends('layouts.app')

@section('titulo', $ghe->nome)

@section('conteudo')
<div style="max-width:800px">

    {{-- Breadcrumb: GHEs / Unidade / Setor --}}
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;flex-wrap:wrap">
        <a href="{{ route('ghes.index') }}" style="color:#64748b;text-decoration:none">← GHEs</a>
        <span>/</span>
        <a href="{{ route('unidades.show', $ghe->setor->unidade) }}" style="color:#3b82f6;text-decoration:none">{{ $ghe->setor->unidade->nome }}</a>
        <span>/</span>
        <a href="{{ route('setores.show', $ghe->setor) }}" style="color:#3b82f6;text-decoration:none">{{ $ghe->setor->nome }}</a>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <h2 style="font-size:1.2rem;font-weight:700;color:#1e293b;margin:0">{{ $ghe->nome }}</h2>
                @if($ghe->ativo)
                    <span style="display:inline-flex;align-items:center;gap:4px;background:#dcfce7;color:#15803d;padding:2px 10px;border-radius:20px;font-size:.72rem;font-weight:600">
                        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block"></span>Ativo
                    </span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:4px;background:#f1f5f9;color:#64748b;padding:2px 10px;border-radius:20px;font-size:.72rem;font-weight:600">
                        <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block"></span>Inativo
                    </span>
                @endif
            </div>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                {{ $ghe->codigo ? 'Código: ' . $ghe->codigo . ' &middot; ' : '' }}
                Setor: {{ $ghe->setor->nome }}
            </p>
        </div>
        @can('update', $ghe)
        <a href="{{ route('ghes.edit', $ghe) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- Descrição das Atividades --}}
    @if($ghe->descricao_atividades)
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px 20px;margin-bottom:16px">
        <h3 style="font-size:.82rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.05em;margin:0 0 8px">Descrição das Atividades</h3>
        <p style="font-size:.88rem;color:#374151;margin:0;line-height:1.6">{{ $ghe->descricao_atividades }}</p>
    </div>
    @endif

    {{-- Riscos vinculados --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                Inventário de Riscos
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $ghe->riscosInventario->count() }})</span>
            </h3>
        </div>
        @if($ghe->riscosInventario->isEmpty())
            <div style="padding:32px;text-align:center">
                <p style="font-size:.85rem;color:#94a3b8;margin:0">Nenhum risco cadastrado neste GHE.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Risco</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ghe->riscosInventario as $risco)
                    <tr style="border-top:1px solid #f1f5f9">
                        <td style="padding:10px 16px;font-size:.85rem;font-weight:500;color:#1e293b">{{ $risco->agente ?? $risco->descricao ?? 'Risco #' . $risco->id }}</td>
                        <td style="padding:10px 16px;font-size:.82rem;color:#64748b">{{ $risco->tipo ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
