<div style="display:grid;gap:20px">

    {{-- Código --}}
    <div>
        <label for="codigo" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Código <span style="color:#94a3b8;font-weight:400">(opcional)</span>
        </label>
        <input type="text" id="codigo" name="codigo"
            value="{{ old('codigo', $unidade->codigo ?? '') }}"
            placeholder="Ex.: UN-01"
            maxlength="20"
            style="width:100%;max-width:200px;padding:8px 12px;border:1px solid {{ $errors->has('codigo') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('codigo')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nome --}}
    <div>
        <label for="nome" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Nome da Unidade <span style="color:#ef4444">*</span>
        </label>
        <input type="text" id="nome" name="nome"
            value="{{ old('nome', $unidade->nome ?? '') }}"
            placeholder="Ex.: Sede Dourados"
            maxlength="150"
            autofocus
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('nome') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('nome')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Endereço --}}
    <div>
        <label for="endereco" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Endereço <span style="color:#94a3b8;font-weight:400">(opcional)</span>
        </label>
        <input type="text" id="endereco" name="endereco"
            value="{{ old('endereco', $unidade->endereco ?? '') }}"
            placeholder="Rua, número, bairro, cidade — UF"
            maxlength="255"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('endereco') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('endereco')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

</div>
