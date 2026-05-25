@extends('layouts.app')

@section('titulo', $setor->nome)

@section('conteudo')
<div style="max-width:800px">

    {{-- Breadcrumb --}}
    <div style="margin-bottom:20px;display:flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b">
        <a href="{{ route('setores.index') }}" style="color:#64748b;text-decoration:none">← Setores</a>
        <span>/</span>
        <a href="{{ route('unidades.show', $setor->unidade) }}" style="color:#3b82f6;text-decoration:none">
            {{ $setor->unidade->nome }}
        </a>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.2rem;font-weight:700;color:#1e293b;margin:0 0 2px">{{ $setor->nome }}</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                Unidade: <a href="{{ route('unidades.show', $setor->unidade) }}" style="color:#3b82f6;text-decoration:none">{{ $setor->unidade->nome }}</a>
                @if($setor->descricao)
                    &nbsp;&middot;&nbsp;{{ $setor->descricao }}
                @endif
            </p>
        </div>
        @can('update', $setor)
        <a href="{{ route('setores.edit', $setor) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- GHEs --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                GHEs
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $setor->ghes->count() }})</span>
            </h3>
        </div>
        @if($setor->ghes->isEmpty())
            <div style="padding:32px;text-align:center">
                <p style="font-size:.85rem;color:#94a3b8;margin:0">Nenhum GHE cadastrado neste setor.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">GHE</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setor->ghes as $ghe)
                    <tr style="border-top:1px solid #f1f5f9">
                        <td style="padding:10px 16px;font-size:.85rem;font-weight:600;color:#1e293b">{{ $ghe->nome }}</td>
                        <td style="padding:10px 16px;font-size:.82rem;color:#64748b">{{ $ghe->descricao ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
