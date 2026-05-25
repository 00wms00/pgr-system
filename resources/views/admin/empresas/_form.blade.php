{{-- Requer: nada. Opcional: $empresa (para editar) --}}
<div style="display:grid;gap:18px">

    {{-- Razão Social --}}
    <div>
        <label for="razao_social" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Razão Social <span style="color:#ef4444">*</span>
        </label>
        <input type="text" id="razao_social" name="razao_social" required maxlength="255"
            value="{{ old('razao_social', $empresa->razao_social ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('razao_social') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
        @error('razao_social')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Nome Fantasia --}}
    <div>
        <label for="nome_fantasia" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Nome Fantasia
        </label>
        <input type="text" id="nome_fantasia" name="nome_fantasia" maxlength="255"
            value="{{ old('nome_fantasia', $empresa->nome_fantasia ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b">
    </div>

    {{-- CNPJ --}}
    <div>
        <label for="cnpj" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            CNPJ <span style="color:#ef4444">*</span>
            <span style="font-size:.72rem;font-weight:400;color:#94a3b8">formato: 00.000.000/0000-00</span>
        </label>
        <input type="text" id="cnpj" name="cnpj" required maxlength="18" placeholder="00.000.000/0000-00"
            value="{{ old('cnpj', $empresa->cnpj ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('cnpj') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;font-family:monospace"
            oninput="mascaraCnpj(this)">
        @error('cnpj')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Endereço --}}
    <div>
        <label for="endereco" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Endereço
        </label>
        <input type="text" id="endereco" name="endereco" maxlength="500"
            value="{{ old('endereco', $empresa->endereco ?? '') }}"
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b">
    </div>

    {{-- Ativo --}}
    <div style="display:flex;align-items:center;gap:10px">
        <input type="hidden" name="ativo" value="0">
        <input type="checkbox" id="ativo" name="ativo" value="1"
            @checked(old('ativo', $empresa->ativo ?? true))
            style="width:16px;height:16px;cursor:pointer">
        <label for="ativo" style="font-size:.85rem;font-weight:500;color:#374151;cursor:pointer">Empresa ativa</label>
    </div>

</div>

@push('scripts')
<script>
function mascaraCnpj(input) {
    let v = input.value.replace(/\D/g, '').slice(0, 14);
    if (v.length > 12) v = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    else if (v.length > 8) v = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})?/, (m, a, b, c, d) => `${a}.${b}.${c}${d ? '/' + d : ''}`);
    else if (v.length > 5) v = v.replace(/(\d{2})(\d{3})(\d+)/, '$1.$2.$3');
    else if (v.length > 2) v = v.replace(/(\d{2})(\d+)/, '$1.$2');
    input.value = v;
}
</script>
@endpush
