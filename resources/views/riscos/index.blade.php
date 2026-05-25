@extends('layouts.app')

@section('titulo', 'Inventário de Riscos')

@section('conteudo')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">Inventário de Riscos</h2>
        <p style="font-size:.8rem;color:#64748b;margin:2px 0 0">Todos os riscos identificados por GHE</p>
    </div>
    @can('create', App\Models\RiscoInventario::class)
    <a href="{{ route('riscos.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Novo Risco
    </a>
    @endcan
</div>

{{-- Filtro por GHE --}}
<form method="GET" action="{{ route('riscos.index') }}"
    style="display:flex;gap:10px;align-items:center;margin-bottom:16px;flex-wrap:wrap">
    <select name="ghe_id"
        style="padding:7px 10px;border:1px solid #d1d5db;border-radius:7px;font-size:.82rem;color:#374151;background:#fff;min-width:240px"
        onchange="this.form.submit()">
        <option value="">Todos os GHEs</option>
        @foreach($ghes as $ghe)
        <option value="{{ $ghe->id }}" @selected(request('ghe_id') == $ghe->id)>
            {{ $ghe->nome }} — {{ $ghe->setor->nome }}
        </option>
        @endforeach
    </select>
    @if(request('ghe_id'))
    <a href="{{ route('riscos.index') }}"
        style="font-size:.8rem;color:#64748b;text-decoration:none">Limpar filtro ×</a>
    @endif
</form>

@if($riscos->isEmpty())
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0">
        <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        <p style="font-size:.9rem;font-weight:600;color:#475569;margin:0 0 4px">Nenhum risco cadastrado</p>
        <p style="font-size:.8rem;color:#94a3b8;margin:0 0 16px">Identifique os perigos e riscos presentes nos GHEs.</p>
        @can('create', App\Models\RiscoInventario::class)
        <a href="{{ route('riscos.create') }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            Cadastrar Risco
        </a>
        @endcan
    </div>
@else
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">GHE / Setor</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Agente / Perigo</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Tipo (eSocial)</th>
                    <th style="padding:10px 16px;text-align:center;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Classificação</th>
                    <th style="padding:10px 16px;text-align:right;font-size:.73rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riscos as $risco)
                @php
                    $cor = match($risco->classificacao_calculada) {
                        'critico'  => ['bg'=>'#fef2f2','text'=>'#991b1b','dot'=>'#ef4444','label'=>'Crítico'],
                        'alto'     => ['bg'=>'#fff7ed','text'=>'#9a3412','dot'=>'#f97316','label'=>'Alto'],
                        'moderado' => ['bg'=>'#fefce8','text'=>'#854d0e','dot'=>'#eab308','label'=>'Moderado'],
                        'baixo'    => ['bg'=>'#f0fdf4','text'=>'#166534','dot'=>'#22c55e','label'=>'Baixo'],
                        default    => ['bg'=>'#f8fafc','text'=>'#475569','dot'=>'#94a3b8','label'=>'—'],
                    };
                @endphp
                <tr style="border-bottom:1px solid #f1f5f9" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px">
                        <a href="{{ route('ghes.show', $risco->ghe) }}"
                            style="font-size:.85rem;font-weight:600;color:#1e293b;text-decoration:none">
                            {{ $risco->ghe->nome }}
                        </a>
                        <p style="font-size:.75rem;color:#94a3b8;margin:2px 0 0">{{ $risco->ghe->setor->nome }} / {{ $risco->ghe->setor->unidade->nome }}</p>
                    </td>
                    <td style="padding:12px 16px">
                        <span style="font-size:.85rem;color:#374151">{{ $risco->agente ?? $risco->fonte_geradora }}</span>
                    </td>
                    <td style="padding:12px 16px">
                        <span style="font-size:.75rem;font-weight:600;background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:5px">{{ $risco->riscoTipo->codigo_esocial }}</span>
                        <span style="font-size:.78rem;color:#64748b;margin-left:6px">{{ $risco->riscoTipo->grupo }}</span>
                    </td>
                    <td style="padding:12px 16px;text-align:center">
                        <span style="display:inline-flex;align-items:center;gap:4px;background:{{ $cor['bg'] }};color:{{ $cor['text'] }};padding:2px 10px;border-radius:20px;font-size:.72rem;font-weight:600">
                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $cor['dot'] }};display:inline-block"></span>
                            {{ $cor['label'] }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('riscos.show', $risco) }}" title="Ver"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @can('update', $risco)
                            <a href="{{ route('riscos.edit', $risco) }}" title="Editar"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endcan
                            @can('delete', $risco)
                            <form method="POST" action="{{ route('riscos.destroy', $risco) }}"
                                onsubmit="return confirm('Remover este risco do inventário?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Remover"
                                    style="width:30px;height:30px;border-radius:6px;background:#fef2f2;border:none;display:inline-flex;align-items:center;justify-content:center;color:#ef4444;cursor:pointer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($riscos->hasPages())
        <div style="padding:12px 16px;border-top:1px solid #f1f5f9">{{ $riscos->links() }}</div>
        @endif
    </div>
@endif
@endsection
