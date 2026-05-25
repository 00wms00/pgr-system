@extends('layouts.app')
@section('titulo', 'Usuários')

@section('conteudo')
<div style="max-width:960px">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap">
        <div>
            <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 2px">Usuários</h2>
            <p style="font-size:.8rem;color:#64748b;margin:0">{{ $usuarios->total() }} usuário(s) cadastrado(s)</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}"
            style="display:inline-flex;align-items:center;gap:6px;background:#3b82f6;color:#fff;padding:8px 16px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Novo Usuário
        </a>
    </div>

    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0">
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Nome</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">E-mail</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Perfil</th>
                    <th style="padding:10px 16px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Empresa</th>
                    <th style="padding:10px 16px;text-align:right;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.04em">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                @php
                    $roleLabel = $usuario->role?->label() ?? '-';
                    $roleCores = match($usuario->role?->value) {
                        'admin'   => ['bg'=>'#eff6ff','text'=>'#1d4ed8'],
                        'gestor'  => ['bg'=>'#f0fdf4','text'=>'#15803d'],
                        default   => ['bg'=>'#f8fafc','text'=>'#475569'],
                    };
                    $isMe = $usuario->id === auth()->id();
                @endphp
                <tr style="border-bottom:1px solid #f1f5f9">
                    <td style="padding:12px 16px;font-size:.85rem;font-weight:600;color:#1e293b">
                        {{ $usuario->name }}
                        @if($isMe)
                        <span style="font-size:.68rem;background:#f1f5f9;color:#64748b;padding:1px 6px;border-radius:4px;margin-left:4px">você</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;font-size:.82rem;color:#475569">{{ $usuario->email }}</td>
                    <td style="padding:12px 16px">
                        <span style="font-size:.73rem;font-weight:600;background:{{ $roleCores['bg'] }};color:{{ $roleCores['text'] }};padding:2px 8px;border-radius:20px">
                            {{ $roleLabel }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;font-size:.82rem;color:#475569">
                        {{ $usuario->empresa?->nome_exibicao ?? '—' }}
                    </td>
                    <td style="padding:12px 16px;text-align:right">
                        <div style="display:inline-flex;gap:6px;align-items:center">
                            <a href="{{ route('admin.usuarios.edit', $usuario) }}" title="Editar"
                                style="width:30px;height:30px;border-radius:6px;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#475569;text-decoration:none">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if(!$isMe)
                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                onsubmit="return confirm('Excluir usuário {{ addslashes($usuario->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Excluir"
                                    style="width:30px;height:30px;border-radius:6px;background:#fef2f2;border:none;display:inline-flex;align-items:center;justify-content:center;color:#ef4444;cursor:pointer">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:40px;text-align:center;font-size:.85rem;color:#94a3b8">Nenhum usuário cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($usuarios->hasPages())
    <div style="margin-top:16px">{{ $usuarios->links() }}</div>
    @endif

</div>
@endsection
