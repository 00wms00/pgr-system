@extends('layouts.app')

@section('titulo', 'Setores')

@section('conteudo')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
    <div>
        <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">Setores</h2>
        <p style="font-size:.8rem;color:#64748b;margin:2px 0 0">Setores vinculados às unidades da empresa</p>
    </div>
    @can('create', App\Models\Setor::class)
    <a href="{{ route('setores.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Novo Setor
    </a>
    @endcan
</div>

@if($setores->isEmpty())
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0">
        <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
        </svg>
        <p style="font-size:.9rem;font-weight:600;color:#475569;margin:0 0 4px">Nenhum setor cadastrado</p>
        <p style="font-size:.8rem;color:#94a3b8;margin:0 0 16px">Cadastre o primeiro setor vinculado a uma unidade.</p>
        @can('create', App\Models\Setor::class)
        <a href="{{ route('setores.create') }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            Cadastrar Setor
        </a>
        @endcan
    </div>
@else
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Setor</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Unidade</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Descrição</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">GHEs</th>
                    <th style="padding:10px 16px;text-align:right;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($setores as $setor)
                <tr style="border-bottom:1px solid #f1f5f9" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px">
                        <a href="{{ route('setores.show', $setor) }}"
                            style="font-size:.85rem;font-weight:600;color:#1e293b;text-decoration:none">
                            {{ $setor->nome }}
                        </a>
                    </td>
                    <td style="padding:12px 16px">
                        <a href="{{ route('unidades.show', $setor->unidade) }}"
                            style="font-size:.82rem;color:#3b82f6;text-decoration:none">
                            {{ $setor->unidade->nome }}
                        </a>
                    </td>
                    <td style="padding:12px 16px;font-size:.82rem;color:#64748b;max-width:260px">
                        <span style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $setor->descricao ?? '—' }}
                        </span>
                    </td>
                    <td style="padding:12px 16px">
                        <span style="display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:22px;background:#dbeafe;color:#1d4ed8;border-radius:11px;font-size:.72rem;font-weight:700;padding:0 6px">
                            {{ $setor->ghes()->count() }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('setores.show', $setor) }}" title="Ver"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @can('update', $setor)
                            <a href="{{ route('setores.edit', $setor) }}" title="Editar"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endcan
                            @can('delete', $setor)
                            <form method="POST" action="{{ route('setores.destroy', $setor) }}"
                                onsubmit="return confirm('Remover o setor \"{{ addslashes($setor->nome) }}\"?')">
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
        @if($setores->hasPages())
        <div style="padding:12px 16px;border-top:1px solid #f1f5f9">{{ $setores->links() }}</div>
        @endif
    </div>
@endif
@endsection
