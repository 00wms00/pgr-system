@php
    $isEdit  = isset($empresa) && $empresa->exists;
    $cnaes   = old('cnaes', $isEdit ? $empresa->cnaesSecundarios->map(fn($c)=>['codigo'=>$c->codigo,'descricao'=>$c->descricao])->toArray() : []);
    $portes  = ['MEI'=>'MEI — Microempreendedor Individual','ME'=>'ME — Microempresa','EPP'=>'EPP — Empresa de Pequeno Porte','medio'=>'Médio Porte','grande'=>'Grande Porte'];
@endphp

<style>
.fs { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:22px;margin-bottom:18px; }
.fs-title { font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#94a3b8;margin-bottom:16px; }
.fg  { display:flex;flex-direction:column;gap:5px; }
.fl  { font-size:.8rem;font-weight:600;color:#374151; }
.fl sup { color:#ef4444; }
.fc  { padding:8px 11px;border:1px solid #d1d5db;border-radius:8px;font-size:.88rem;color:#1e293b;outline:none;transition:border-color .15s,box-shadow .15s;width:100%; }
.fc:focus { border-color:#0f766e;box-shadow:0 0 0 3px rgba(15,118,110,.12); }
.fh  { font-size:.72rem;color:#94a3b8;margin-top:2px; }
.fe  { font-size:.75rem;color:#dc2626;margin-top:2px; }
.grid2 { display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px; }
.grid3 { display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px; }
/* Listas dinâmicas */
.dyn-list    { display:flex;flex-direction:column;gap:8px; }
.dyn-cnae    { display:grid;grid-template-columns:130px 1fr 32px;gap:8px;align-items:flex-start; }
.btn-rm      { width:32px;height:34px;border-radius:6px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.btn-rm:hover{ background:#fee2e2; }
.btn-add     { display:inline-flex;align-items:center;gap:6px;padding:6px 13px;border-radius:7px;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;font-size:.8rem;font-weight:600;cursor:pointer;margin-top:10px; }
.btn-add:hover{ background:#dcfce7; }
/* Grau de risco badge */
.gr-opts     { display:flex;gap:8px;flex-wrap:wrap; }
.gr-label    { position:relative;cursor:pointer; }
.gr-label input{ position:absolute;opacity:0;width:0;height:0; }
.gr-box      { display:inline-flex;align-items:center;justify-content:center;width:52px;height:44px;border-radius:8px;border:2px solid #e2e8f0;font-size:1rem;font-weight:800;color:#94a3b8;transition:all .15s;user-select:none; }
.gr-label input:checked+.gr-box { border-color:currentColor; }
.gr-1 { color:#22c55e; } .gr-label:has(input[value="1"]:checked) .gr-box { background:#f0fdf4;border-color:#22c55e; }
.gr-2 { color:#eab308; } .gr-label:has(input[value="2"]:checked) .gr-box { background:#fefce8;border-color:#eab308; }
.gr-3 { color:#f97316; } .gr-label:has(input[value="3"]:checked) .gr-box { background:#fff7ed;border-color:#f97316; }
.gr-4 { color:#ef4444; } .gr-label:has(input[value="4"]:checked) .gr-box { background:#fef2f2;border-color:#ef4444; }
</style>

{{-- ── Dados Cadastrais ──────────────────────────────────────────── --}}
<div class="fs">
    <p class="fs-title">Dados Cadastrais</p>
    <div class="grid2">
        <div class="fg" style="grid-column:1/-1">
            <label class="fl">Razão Social <sup>*</sup></label>
            <input type="text" name="razao_social" class="fc"
                   value="{{ old('razao_social', $empresa->razao_social ?? '') }}" required maxlength="255">
            @error('razao_social')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Nome Fantasia</label>
            <input type="text" name="nome_fantasia" class="fc"
                   value="{{ old('nome_fantasia', $empresa->nome_fantasia ?? '') }}" maxlength="255">
        </div>
        <div class="fg">
            <label class="fl">CNPJ <sup>*</sup></label>
            <input type="text" name="cnpj" class="fc" id="cnpj"
                   value="{{ old('cnpj', $empresa->cnpj ?? '') }}" required maxlength="18" placeholder="00.000.000/0000-00">
            @error('cnpj')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Inscrição Estadual</label>
            <input type="text" name="inscricao_estadual" class="fc"
                   value="{{ old('inscricao_estadual', $empresa->inscricao_estadual ?? '') }}" maxlength="30">
        </div>
        <div class="fg">
            <label class="fl">Inscrição Municipal</label>
            <input type="text" name="inscricao_municipal" class="fc"
                   value="{{ old('inscricao_municipal', $empresa->inscricao_municipal ?? '') }}" maxlength="30">
        </div>
        <div class="fg" style="grid-column:1/-1">
            <label class="fl">Endereço</label>
            <input type="text" name="endereco" class="fc"
                   value="{{ old('endereco', $empresa->endereco ?? '') }}" maxlength="255">
        </div>
        <div class="fg">
            <label class="fl">Porte da Empresa</label>
            <select name="porte" class="fc">
                <option value="">Selecione…</option>
                @foreach($portes as $val => $label)
                <option value="{{ $val }}" {{ old('porte', $empresa->porte ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('porte')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg" style="align-self:flex-end;padding-bottom:4px">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;font-weight:500;color:#374151">
                <input type="hidden"  name="ativo" value="0">
                <input type="checkbox" name="ativo" value="1" style="width:16px;height:16px;accent-color:#0f766e"
                       {{ old('ativo', $empresa->ativo ?? true) ? 'checked' : '' }}>
                Empresa Ativa
            </label>
        </div>
    </div>
</div>

{{-- ── CNAE Principal + Grau de Risco ───────────────────────────── --}}
<div class="fs">
    <p class="fs-title">CNAE Principal e Grau de Risco (NR-4)</p>
    <div class="grid2" style="margin-bottom:18px">
        <div class="fg">
            <label class="fl">Código CNAE Principal</label>
            <input type="text" name="cnae_principal_codigo" class="fc"
                   value="{{ old('cnae_principal_codigo', $empresa->cnae_principal_codigo ?? '') }}"
                   maxlength="10" placeholder="ex: 2312-5/00">
            @error('cnae_principal_codigo')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Descrição CNAE Principal</label>
            <input type="text" name="cnae_principal_descricao" class="fc"
                   value="{{ old('cnae_principal_descricao', $empresa->cnae_principal_descricao ?? '') }}"
                   maxlength="300" placeholder="ex: Fabricação de vidro plano">
            @error('cnae_principal_descricao')<p class="fe">{{ $message }}</p>@enderror
        </div>
    </div>
    <div class="fg">
        <label class="fl">Grau de Risco (NR-4)</label>
        <p class="fh" style="margin-bottom:8px">Determinado pelo CNAE principal conforme Quadro I da NR-4.</p>
        <div class="gr-opts">
            @foreach([1,2,3,4] as $gr)
            <label class="gr-label">
                <input type="radio" name="grau_risco" value="{{ $gr }}"
                       {{ old('grau_risco', $empresa->grau_risco ?? '') == $gr ? 'checked' : '' }}>
                <span class="gr-box gr-{{ $gr }}">{{ $gr }}</span>
            </label>
            @endforeach
            <label class="gr-label">
                <input type="radio" name="grau_risco" value=""
                       {{ old('grau_risco', $empresa->grau_risco ?? '') === '' || old('grau_risco', $empresa->grau_risco ?? '') === null ? 'checked' : '' }}>
                <span class="gr-box" style="font-size:.7rem;width:auto;padding:0 10px">Não inf.</span>
            </label>
        </div>
        @error('grau_risco')<p class="fe">{{ $message }}</p>@enderror
    </div>
</div>

{{-- ── CNAEs Secundários ─────────────────────────────────────────── --}}
<div class="fs">
    <p class="fs-title">CNAEs Secundários</p>
    <div class="dyn-list" id="cnae-list">
        @foreach($cnaes as $i => $c)
        <div class="dyn-cnae">
            <input type="text" name="cnaes[{{ $i }}][codigo]"    class="fc" value="{{ $c['codigo'] }}"    placeholder="0000-0/00" maxlength="10">
            <input type="text" name="cnaes[{{ $i }}][descricao]" class="fc" value="{{ $c['descricao'] }}" placeholder="Descrição da atividade" maxlength="300">
            <button type="button" class="btn-rm" onclick="removeRow(this)">&times;</button>
        </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addCnae()">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Adicionar CNAE Secundário
    </button>
</div>

{{-- ── Trabalhadores ─────────────────────────────────────────────── --}}
<div class="fs">
    <p class="fs-title">Quadro de Trabalhadores</p>
    <div class="grid3">
        <div class="fg">
            <label class="fl">Total de Trabalhadores</label>
            <input type="number" name="total_trabalhadores" class="fc" min="0"
                   value="{{ old('total_trabalhadores', $empresa->total_trabalhadores ?? '') }}" placeholder="0">
            @error('total_trabalhadores')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Masculino</label>
            <input type="number" name="trabalhadores_masculino" class="fc" min="0"
                   value="{{ old('trabalhadores_masculino', $empresa->trabalhadores_masculino ?? '') }}" placeholder="0">
        </div>
        <div class="fg">
            <label class="fl">Feminino</label>
            <input type="number" name="trabalhadores_feminino" class="fc" min="0"
                   value="{{ old('trabalhadores_feminino', $empresa->trabalhadores_feminino ?? '') }}" placeholder="0">
        </div>
    </div>
</div>

{{-- ── Representante Legal ───────────────────────────────────────── --}}
<div class="fs">
    <p class="fs-title">Representante Legal</p>
    <div class="grid2">
        <div class="fg">
            <label class="fl">Nome do Representante</label>
            <input type="text" name="representante_nome" class="fc"
                   value="{{ old('representante_nome', $empresa->representante_nome ?? '') }}" maxlength="150">
            @error('representante_nome')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Cargo do Representante</label>
            <input type="text" name="representante_cargo" class="fc"
                   value="{{ old('representante_cargo', $empresa->representante_cargo ?? '') }}" maxlength="100"
                   placeholder="ex: Diretor Administrativo">
        </div>
    </div>
</div>

{{-- ── Contato Técnico Interno ───────────────────────────────────── --}}
<div class="fs">
    <p class="fs-title">Contato Técnico Interno</p>
    <div class="grid2">
        <div class="fg">
            <label class="fl">Nome do Contato Técnico</label>
            <input type="text" name="contato_tecnico_nome" class="fc"
                   value="{{ old('contato_tecnico_nome', $empresa->contato_tecnico_nome ?? '') }}" maxlength="150">
            @error('contato_tecnico_nome')<p class="fe">{{ $message }}</p>@enderror
        </div>
        <div class="fg">
            <label class="fl">Cargo do Contato Técnico</label>
            <input type="text" name="contato_tecnico_cargo" class="fc"
                   value="{{ old('contato_tecnico_cargo', $empresa->contato_tecnico_cargo ?? '') }}" maxlength="100"
                   placeholder="ex: SESMT / Técnico de Segurança">
        </div>
    </div>
</div>

<script>
let cnaeIdx = {{ count($cnaes) }};

function removeRow(btn) {
    btn.closest('[class^="dyn-"]').remove();
    renumber('cnae-list', 'cnaes');
}

function renumber(listId, prefix) {
    Array.from(document.getElementById(listId).children).forEach((row, idx) => {
        row.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${idx}]`);
        });
    });
}

function addCnae() {
    const list = document.getElementById('cnae-list');
    const div  = document.createElement('div');
    div.className = 'dyn-cnae';
    div.innerHTML = `
        <input type="text" name="cnaes[${cnaeIdx}][codigo]"    class="fc" placeholder="0000-0/00" maxlength="10">
        <input type="text" name="cnaes[${cnaeIdx}][descricao]" class="fc" placeholder="Descrição da atividade" maxlength="300">
        <button type="button" class="btn-rm" onclick="removeRow(this)">&times;</button>
    `;
    list.appendChild(div);
    div.querySelector('input').focus();
    cnaeIdx++;
}

// Máscara CNPJ
document.getElementById('cnpj')?.addEventListener('input', function(){
    let v = this.value.replace(/\D/g,'').slice(0,14);
    v = v.replace(/(\d{2})(\d)/,'$1.$2')
         .replace(/(\d{2}\.\d{3})(\d)/,'$1.$2')
         .replace(/(\.\d{3})(\d)/,'$1/$2')
         .replace(/(\d{4})(\d)/,'$1-$2');
    this.value = v;
});
</script>
