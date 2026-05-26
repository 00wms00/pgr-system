@extends('layouts.app')
@section('titulo', 'GHE — ' . $ghe->nome)

@section('conteudo')
@php
    $unidade = $ghe->setor->unidade->nome ?? '—';
    $setor   = $ghe->setor->nome ?? '—';
@endphp

<div style="max-width:860px">

    {{-- Cabeçalho --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:24px;flex-wrap:wrap">
        <div>
            <p style="font-size:.75rem;color:#94a3b8;margin:0">{{ $unidade }} / {{ $setor }}</p>
            <h2 style="font-size:1.25rem;font-weight:800;color:#1e293b;margin:4px 0 6px">{{ $ghe->nome }}</h2>
            <div style="display:flex;gap:8px;align-items:center">
                <span style="font-size:.78rem;color:#64748b;font-weight:600">Código: {{ $ghe->codigo }}</span>
                @if($ghe->qtd_funcionarios !== null)
                <span style="font-size:.78rem;color:#64748b">·</span>
                <span style="font-size:.78rem;color:#64748b">{{ $ghe->qtd_funcionarios }} funcionário{{ $ghe->qtd_funcionarios !== 1 ? 's' : '' }}</span>
                @endif
                <span style="font-size:.72rem;font-weight:600;padding:2px 9px;border-radius:99px;background:{{ $ghe->ativo ? '#f0fdf4' : '#f8fafc' }};color:{{ $ghe->ativo ? '#15803d' : '#94a3b8' }}">
                    {{ $ghe->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </div>
        </div>
        <div style="display:flex;gap:8px">
            @can('update', $ghe)
            <a href="{{ route('ghes.edit', $ghe) }}"
               style="padding:8px 16px;background:#0f766e;color:#fff;border-radius:8px;font-size:.83rem;font-weight:600;text-decoration:none">Editar</a>
            @endcan
            <a href="{{ route('ghes.index') }}"
               style="padding:8px 14px;background:#f1f5f9;color:#475569;border-radius:8px;font-size:.83rem;font-weight:600;text-decoration:none">← Voltar</a>
        </div>
    </div>

    {{-- CBOs --}}
    @if($ghe->cbos->isNotEmpty())
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px">
        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:14px">CBOs — Códigos Brasileiros de Ocupações</p>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:8px 12px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase;width:130px">Código</th>
                    <th style="padding:8px 12px;text-align:left;font-size:.72rem;font-weight:600;color:#64748b;text-transform:uppercase">Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ghe->cbos as $cbo)
                <tr style="border-top:1px solid #f1f5f9">
                    <td style="padding:9px 12px;font-size:.83rem;font-weight:600;color:#374151;font-family:monospace">{{ $cbo->codigo }}</td>
                    <td style="padding:9px 12px;font-size:.83rem;color:#374151">{{ $cbo->descricao }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Cargos --}}
    @if($ghe->cargos->isNotEmpty())
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px">
        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:12px">Cargos / Funções</p>
        <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($ghe->cargos as $c)
            <span style="padding:4px 12px;background:#f1f5f9;border-radius:99px;font-size:.8rem;color:#374151;font-weight:500">{{ $c->cargo }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Descrição Atividades --}}
    @if($ghe->descricao_atividades)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px">
        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:10px">Descrição das Atividades Realizadas</p>
        <p style="font-size:.88rem;color:#374151;line-height:1.65;white-space:pre-line">{{ $ghe->descricao_atividades }}</p>
    </div>
    @endif

    {{-- Descrição Ambiente --}}
    @if($ghe->descricao_ambiente)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-bottom:16px">
        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:10px">Descrição do Ambiente de Trabalho</p>
        <p style="font-size:.88rem;color:#374151;line-height:1.65;white-space:pre-line">{{ $ghe->descricao_ambiente }}</p>
    </div>
    @endif

    {{-- Riscos vinculados --}}
    @if($ghe->riscosInventario->isNotEmpty())
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px">
        <p style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:12px">Riscos Identificados ({{ $ghe->riscosInventario->count() }})</p>
        <div style="display:flex;flex-direction:column;gap:6px">
            @foreach($ghe->riscosInventario as $r)
            <a href="{{ route('riscos.show', $r) }}"
               style="display:flex;align-items:center;justify-content:space-between;padding:9px 12px;background:#f8fafc;border-radius:8px;text-decoration:none;color:inherit">
                <span style="font-size:.83rem;font-weight:500;color:#374151">{{ $r->riscoTipo->nome ?? '—' }}</span>
                <span style="font-size:.72rem;color:#94a3b8">Ver →</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
