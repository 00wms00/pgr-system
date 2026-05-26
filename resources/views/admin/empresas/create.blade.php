@extends('layouts.app')
@section('titulo', 'Nova Empresa')

@section('conteudo')
<div style="max-width:860px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
        <h2 style="font-size:1.15rem;font-weight:800;color:#1e293b;margin:0">Nova Empresa</h2>
        <a href="{{ route('admin.empresas.index') }}"
           style="font-size:.82rem;color:#64748b;text-decoration:none">← Voltar</a>
    </div>

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:.82rem;color:#991b1b">
        <ul style="margin:0;padding-left:16px">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.empresas.store') }}">
        @csrf
        @include('admin.empresas._form')
        <div style="display:flex;gap:10px;margin-top:4px">
            <button type="submit"
                    style="padding:9px 22px;background:#0f766e;color:#fff;border-radius:8px;font-size:.88rem;font-weight:600;border:none;cursor:pointer">Salvar</button>
            <a href="{{ route('admin.empresas.index') }}"
               style="padding:9px 16px;background:#f1f5f9;color:#475569;border-radius:8px;font-size:.88rem;font-weight:600;text-decoration:none">Cancelar</a>
        </div>
    </form>
</div>
@endsection
