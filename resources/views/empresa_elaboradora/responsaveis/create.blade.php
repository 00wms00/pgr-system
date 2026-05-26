@extends('layouts.app')

@section('titulo', 'Novo Responsável Técnico')

@section('conteudo')
<div style="max-width:720px">

    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:.82rem;color:#64748b">
        <a href="{{ route('empresas-elaboradoras.index') }}" style="color:#64748b;text-decoration:none" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">Empresas Elaboradoras</a>
        <span>/</span>
        <a href="{{ route('empresas-elaboradoras.show', $empresaElaboradora) }}" style="color:#64748b;text-decoration:none" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">{{ $empresaElaboradora->razao_social }}</a>
        <span>/</span>
        <span style="color:#1e293b">Novo Responsável</span>
    </div>

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:28px">
        <h2 style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:6px">Novo Responsável Técnico</h2>
        <p style="font-size:.82rem;color:#64748b;margin-bottom:24px">{{ $empresaElaboradora->razao_social }}</p>

        <form method="POST" action="{{ route('empresas-elaboradoras.responsaveis.store', $empresaElaboradora) }}">
            @csrf
            @include('empresa_elaboradora.responsaveis._form')

            <div style="display:flex;gap:10px;margin-top:24px">
                <button type="submit"
                    style="background:#3b82f6;color:#fff;padding:8px 20px;border-radius:7px;font-size:.85rem;font-weight:600;border:none;cursor:pointer"
                    onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                    Salvar
                </button>
                <a href="{{ route('empresas-elaboradoras.show', $empresaElaboradora) }}"
                    style="background:#f1f5f9;color:#475569;padding:8px 20px;border-radius:7px;font-size:.85rem;font-weight:600;text-decoration:none"
                    onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
