@extends('layouts.app')

@section('titulo', $unidade->nome)

@section('conteudo')
<div style="max-width:800px">

    {{-- Breadcrumb --}}
    <div style="margin-bottom:20px">
        <a href="{{ route('unidades.index') }}"
            style="display:inline-flex;align-items:center;gap:5px;font-size:.8rem;color:#64748b;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Unidades
        </a>
    </div>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.2rem;font-weight:700;color:#1e293b;margin:0 0 2px">{{ $unidade->nome }}</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">
                {{ $unidade->codigo ? 'Código: ' . $unidade->codigo . ' · ' : '' }}
                {{ $unidade->endereco ?? 'Endereço não informado' }}
            </p>
        </div>
        @can('update', $unidade)
        <a href="{{ route('unidades.edit', $unidade) }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#f1f5f9;color:#475569;padding:7px 14px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar
        </a>
        @endcan
    </div>

    {{-- Setores --}}
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between">
            <h3 style="font-size:.9rem;font-weight:700;color:#1e293b;margin:0">
                Setores
                <span style="font-size:.75rem;font-weight:500;color:#64748b;margin-left:6px">({{ $unidade->setores->count() }})</span>
            </h3>
        </div>

        @if($unidade->setores->isEmpty())
            <div style="padding:32px;text-align:center">
                <p style="font-size:.85rem;color:#94a3b8;margin:0">Nenhum setor cadastrado nesta unidade.</p>
            </div>
        @else
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="background:#f8fafc">
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">Setor</th>
                        <th style="padding:9px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase">GHEs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unidade->setores as $setor)
                    <tr style="border-top:1px solid #f1f5f9">
                        <td style="padding:10px 16px;font-size:.85rem;color:#1e293b;font-weight:500">{{ $setor->nome }}</td>
                        <td style="padding:10px 16px">
                            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:22px;background:#dbeafe;color:#1d4ed8;border-radius:11px;font-size:.72rem;font-weight:700;padding:0 6px">
                                {{ $setor->ghes->count() }}
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
