@extends('layouts.app')
@section('titulo', 'Empresas')

@section('conteudo')
<div style="max-width:960px">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 2px">Empresas</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">{{ $empresas->total() }} empresa(s) cadastrada(s)</p>
        </div>
        <a href="{{ route('admin.empresas.create') }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nova Empresa
        </a>
    </div>

    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Razão Social</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">CNPJ</th>
                    <th style="padding:10px 16px;text-align:center;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Usuários</th>
                    <th style="padding:10px 16px;text-align:center;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Status</th>
                    <th style="padding:10px 16px;text-align:right;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresas as $empresa)
                <tr style="border-bottom:1px solid #f1f5f9">
                    <td style="padding:12px 16px">
                        <p style="font-size:.88rem;font-weight:600;color:#1e293b;margin:0">{{ $empresa->razao_social }}</p>
                        @if($empresa->nome_fantasia)
                        <p style="font-size:.75rem;color:#64748b;margin:2px 0 0">{{ $empresa->nome_fantasia }}</p>
                        @endif
                    </td>
                    <td style="padding:12px 16px;font-size:.82rem;color:#475569;font-family:monospace">{{ $empresa->cnpj }}</td>
                    <td style="padding:12px 16px;text-align:center">
                        <span style="font-size:.82rem;font-weight:600;color:#1e293b">{{ $empresa->usuarios_count }}</span>
                    </td>
                    <td style="padding:12px 16px;text-align:center">
                        @if($empresa->ativo)
                        <span style="font-size:.73rem;font-weight:600;background:#f0fdf4;color:#15803d;padding:2px 10px;border-radius:20px">Ativa</span>
                        @else
                        <span style="font-size:.73rem;font-weight:600;background:#f8fafc;color:#64748b;padding:2px 10px;border-radius:20px">Inativa</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;text-align:right">
                        <div style="display:inline-flex;gap:6px;align-items:center">
                            <a href="{{ route('admin.empresas.edit', $empresa) }}" title="Editar"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if($empresa->usuarios_count === 0)
                            <form method="POST" action="{{ route('admin.empresas.destroy', $empresa) }}"
                                onsubmit="return confirm('Excluir empresa {{ addslashes($empresa->razao_social) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Excluir"
                                    style="width:30px;height:30px;border-radius:6px;background:#fef2f2;border:none;display:inline-flex;align-items:center;justify-content:center;color:#ef4444;cursor:pointer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @else
                            <span title="Empresa com usuários não pode ser excluída"
                                style="width:30px;height:30px;border-radius:6px;background:#f8fafc;display:inline-flex;align-items:center;justify-content:center;color:#cbd5e1;cursor:not-allowed">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:40px;text-align:center;font-size:.85rem;color:#94a3b8">Nenhuma empresa cadastrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($empresas->hasPages())
    <div style="margin-top:16px">{{ $empresas->links() }}</div>
    @endif

</div>
@endsection
