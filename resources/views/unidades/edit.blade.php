@extends('layouts.app')

@section('titulo', 'Editar Unidade')

@section('conteudo')
<div style="max-width:640px">
    <div style="margin-bottom:20px">
        <a href="{{ route('unidades.show', $unidade) }}"
            style="display:inline-flex;align-items:center;gap:5px;font-size:.8rem;color:#64748b;text-decoration:none">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Voltar para {{ $unidade->nome }}
        </a>
        <h2 style="font-size:1.1rem;font-weight:700;color:#1e293b;margin:8px 0 2px">Editar Unidade</h2>
        <p style="font-size:.8rem;color:#64748b;margin:0">{{ $unidade->nome }}</p>
    </div>

    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:24px">
        <form method="POST" action="{{ route('unidades.update', $unidade) }}">
            @csrf @method('PUT')
            @include('unidades._form')
            <div style="display:flex;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid #f1f5f9">
                <button type="submit"
                    style="background:#3b82f6;color:#fff;padding:9px 20px;border-radius:7px;font-size:.85rem;font-weight:600;border:none;cursor:pointer">
                    Salvar Alterações
                </button>
                <a href="{{ route('unidades.show', $unidade) }}"
                    style="padding:9px 20px;border-radius:7px;font-size:.85rem;font-weight:500;color:#475569;background:#f1f5f9;text-decoration:none">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
