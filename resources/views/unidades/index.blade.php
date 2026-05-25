@extends('layouts.app')

@section('titulo', 'Unidades')

@section('conteudo')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
    <div>
        <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0">Unidades</h2>
        <p style="font-size:.8rem;color:#64748b;margin:2px 0 0">Unidades / estabelecimentos da empresa</p>
    </div>
    @can('create', App\Models\Unidade::class)
    <a href="{{ route('unidades.create') }}"
        style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Nova Unidade
    </a>
    @endcan
</div>

@if($unidades->isEmpty())
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:10px;border:1px solid #e2e8f0">
        <svg width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <p style="font-size:.9rem;font-weight:600;color:#475569;margin:0 0 4px">Nenhuma unidade cadastrada</p>
        <p style="font-size:.8rem;color:#94a3b8;margin:0 0 16px">Cadastre a primeira unidade / estabelecimento.</p>
        @can('create', App\Models\Unidade::class)
        <a href="{{ route('unidades.create') }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            Cadastrar Unidade
        </a>
        @endcan
    </div>
@else
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Código</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Nome</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Endereço</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Setores</th>
                    <th style="padding:10px 16px;text-align:right;font-size:.75rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.05em">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unidades as $unidade)
                <tr style="border-bottom:1px solid #f1f5f9;transition:background .1s" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px;font-size:.82rem;color:#64748b;font-family:monospace">
                        {{ $unidade->codigo ?? '—' }}
                    </td>
                    <td style="padding:12px 16px">
                        <a href="{{ route('unidades.show', $unidade) }}"
                            style="font-size:.85rem;font-weight:600;color:#1e293b;text-decoration:none">
                            {{ $unidade->nome }}
                        </a>
                    </td>
                    <td style="padding:12px 16px;font-size:.82rem;color:#64748b">
                        {{ $unidade->endereco ?? '—' }}
                    </td>
                    <td style="padding:12px 16px">
                        <span style="display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:22px;background:#dbeafe;color:#1d4ed8;border-radius:11px;font-size:.72rem;font-weight:700;padding:0 6px">
                            {{ $unidade->setores_count ?? $unidade->setores()->count() }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('unidades.show', $unidade) }}"
                                title="Ver" style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @can('update', $unidade)
                            <a href="{{ route('unidades.edit', $unidade) }}"
                                title="Editar" style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endcan
                            @can('delete', $unidade)
                            <form method="POST" action="{{ route('unidades.destroy', $unidade) }}"
                                onsubmit="return confirm('Remover a unidade \"{{ addslashes($unidade->nome) }}\"? Os setores e GHEs vinculados também serão afetados.')">
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

        @if($unidades->hasPages())
        <div style="padding:12px 16px;border-top:1px solid #f1f5f9">
            {{ $unidades->links() }}
        </div>
        @endif
    </div>
@endif
@endsection
