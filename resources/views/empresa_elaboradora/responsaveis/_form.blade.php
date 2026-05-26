@php
    $val = fn(string $field) => old($field, $responsavel->{$field} ?? '');
    $err = fn(string $field) => $errors->first($field);
    $input = '
        width:100%;padding:8px 12px;border-radius:7px;font-size:.85rem;
        border:1px solid #e2e8f0;background:#f8fafc;color:#1e293b;
        outline:none;transition:border .15s;
    ';
@endphp

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

    {{-- Nome --}}
    <div style="grid-column:1/-1">
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Nome completo <span style="color:#ef4444">*</span></label>
        <input type="text" name="nome" value="{{ $val('nome') }}"
            style="{{ $input }}" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('nome'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('nome') }}</p>@endif
    </div>

    {{-- Cargo --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Cargo / Função</label>
        <input type="text" name="cargo" value="{{ $val('cargo') }}"
            style="{{ $input }}" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('cargo'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('cargo') }}</p>@endif
    </div>

    {{-- Formação --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Formação</label>
        <input type="text" name="formacao" value="{{ $val('formacao') }}"
            style="{{ $input }}" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('formacao'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('formacao') }}</p>@endif
    </div>

    {{-- Especialização --}}
    <div style="grid-column:1/-1">
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Especialização</label>
        <input type="text" name="especializacao" value="{{ $val('especializacao') }}"
            style="{{ $input }}" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('especializacao'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('especializacao') }}</p>@endif
    </div>

    {{-- Tipo de Registro --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Tipo de Registro</label>
        <select name="tipo_registro"
            style="{{ $input }}cursor:pointer" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
            <option value="">— Selecione —</option>
            @foreach($tiposRegistro as $value => $label)
                <option value="{{ $value }}" {{ $val('tipo_registro') == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @if($err('tipo_registro'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('tipo_registro') }}</p>@endif
    </div>

    {{-- Número do Registro --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">Número do Registro</label>
        <input type="text" name="numero_registro" value="{{ $val('numero_registro') }}"
            style="{{ $input }}font-family:monospace" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('numero_registro'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('numero_registro') }}</p>@endif
    </div>

    {{-- UF do Registro --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">UF do Registro</label>
        <select name="uf_registro"
            style="{{ $input }}cursor:pointer" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
            <option value="">— Selecione —</option>
            @foreach($ufs as $uf)
                <option value="{{ $uf }}" {{ $val('uf_registro') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
            @endforeach
        </select>
        @if($err('uf_registro'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('uf_registro') }}</p>@endif
    </div>

    {{-- RNP --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">RNP</label>
        <input type="text" name="rnp" value="{{ $val('rnp') }}"
            style="{{ $input }}font-family:monospace" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('rnp'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('rnp') }}</p>@endif
    </div>

    {{-- CPF --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">CPF</label>
        <input type="text" name="cpf" value="{{ $val('cpf') }}" placeholder="000.000.000-00"
            style="{{ $input }}font-family:monospace" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('cpf'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('cpf') }}</p>@endif
    </div>

    {{-- NIT/PIS --}}
    <div>
        <label style="display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:4px">NIT / PIS</label>
        <input type="text" name="nit" value="{{ $val('nit') }}" placeholder="000.00000.00-0"
            style="{{ $input }}font-family:monospace" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
        @if($err('nit'))<p style="color:#ef4444;font-size:.75rem;margin-top:3px">{{ $err('nit') }}</p>@endif
    </div>

    {{-- Assinatura digital --}}
    <div style="grid-column:1/-1">
        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;color:#374151">
            <input type="checkbox" name="assina_digitalmente" value="1"
                {{ old('assina_digitalmente', $responsavel->assina_digitalmente ?? false) ? 'checked' : '' }}
                style="width:16px;height:16px;accent-color:#3b82f6">
            Assina digitalmente o relatório
        </label>
    </div>

</div>
