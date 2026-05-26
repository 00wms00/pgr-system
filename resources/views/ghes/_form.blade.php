@php
    $isEdit = isset($ghe) && $ghe->exists;
    $cbos   = old('cbos',   $isEdit ? $ghe->cbos->map(fn($c)=>['codigo'=>$c->codigo,'descricao'=>$c->descricao])->toArray() : []);
    $cargos = old('cargos', $isEdit ? $ghe->cargos->pluck('cargo')->toArray() : []);
@endphp

<style>
.form-section      { background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:24px;margin-bottom:20px; }
.form-section-title{ font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:18px; }
.form-grid         { display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px; }
.form-group        { display:flex;flex-direction:column;gap:5px; }
.form-label        { font-size:.8rem;font-weight:600;color:#374151; }
.form-label sup    { color:#ef4444; }
.form-control      { padding:8px 11px;border:1px solid #d1d5db;border-radius:8px;font-size:.88rem;color:#1e293b;outline:none;transition:border-color .15s,box-shadow .15s; }
.form-control:focus{ border-color:#0f766e;box-shadow:0 0 0 3px rgba(15,118,110,.12); }
textarea.form-control{resize:vertical;min-height:90px;}
.form-hint         { font-size:.73rem;color:#94a3b8; }
.form-error        { font-size:.75rem;color:#dc2626;margin-top:2px; }

/* Listas dinâmicas */
.dyn-list          { display:flex;flex-direction:column;gap:8px; }
.dyn-row           { display:flex;gap:8px;align-items:flex-start; }
.dyn-row .form-control{ flex:1; }
.dyn-cbo-row       { display:grid;grid-template-columns:130px 1fr 32px;gap:8px;align-items:flex-start; }
.btn-remove        { width:32px;height:34px;border-radius:6px;background:#fef2f2;border:1px solid #fecaca;color:#dc2626;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .15s; }
.btn-remove:hover  { background:#fee2e2; }
.btn-add           { display:inline-flex;align-items:center;gap:6px;padding:6px 13px;border-radius:7px;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;font-size:.8rem;font-weight:600;cursor:pointer;transition:background .15s; }
.btn-add:hover     { background:#dcfce7; }
</style>

{{-- ── Identificação ────────────────────────────────────────── --}}
<div class="form-section">
    <p class="form-section-title">Identificação</p>
    <div class="form-grid">

        <div class="form-group">
            <label class="form-label">Setor <sup>*</sup></label>
            <select name="setor_id" class="form-control" required>
                <option value="">Selecione…</option>
                @foreach($setores as $s)
                <option value="{{ $s->id }}" {{ old('setor_id', $ghe->setor_id ?? '') == $s->id ? 'selected' : '' }}>
                    {{ $s->unidade->nome ?? '' }} / {{ $s->nome }}
                </option>
                @endforeach
            </select>
            @error('setor_id')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Código <sup>*</sup></label>
            <input type="text" name="codigo" class="form-control" maxlength="20"
                   value="{{ old('codigo', $ghe->codigo ?? '') }}" required placeholder="ex: GHE-001">
            @error('codigo')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nome / Denominação <sup>*</sup></label>
            <input type="text" name="nome" class="form-control"
                   value="{{ old('nome', $ghe->nome ?? '') }}" required placeholder="ex: Operadores de Máquinas">
            @error('nome')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Qtd. de Funcionários</label>
            <input type="number" name="qtd_funcionarios" class="form-control" min="0" max="99999"
                   value="{{ old('qtd_funcionarios', $ghe->qtd_funcionarios ?? '') }}" placeholder="0">
            <span class="form-hint">Total de trabalhadores expostos neste GHE</span>
            @error('qtd_funcionarios')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group" style="align-items:flex-start;justify-content:flex-end;padding-top:22px">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;font-weight:500;color:#374151">
                <input type="hidden"  name="ativo" value="0">
                <input type="checkbox" name="ativo" value="1" style="width:16px;height:16px;accent-color:#0f766e"
                       {{ old('ativo', $ghe->ativo ?? true) ? 'checked' : '' }}>
                GHE Ativo
            </label>
        </div>

    </div>
</div>

{{-- ── CBOs ──────────────────────────────────────────────────── --}}
<div class="form-section">
    <p class="form-section-title">CBOs — Códigos Brasileiros de Ocupações</p>
    <p style="font-size:.8rem;color:#64748b;margin-bottom:14px">Informe os CBOs que compõem este GHE.</p>

    <div class="dyn-list" id="cbo-list">
        @foreach($cbos as $i => $cbo)
        <div class="dyn-cbo-row">
            <input type="text" name="cbos[{{ $i }}][codigo]" class="form-control"
                   value="{{ $cbo['codigo'] }}" placeholder="0000-00" maxlength="10">
            <input type="text" name="cbos[{{ $i }}][descricao]" class="form-control"
                   value="{{ $cbo['descricao'] }}" placeholder="Descrição da ocupação" maxlength="200">
            <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remover">&times;</button>
        </div>
        @endforeach
    </div>
    @error('cbos')<p class="form-error mt-1">{{ $message }}</p>@enderror

    <button type="button" class="btn-add" style="margin-top:10px" onclick="addCbo()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Adicionar CBO
    </button>
</div>

{{-- ── Cargos / Funções ─────────────────────────────────────── --}}
<div class="form-section">
    <p class="form-section-title">Cargos / Funções</p>
    <p style="font-size:.8rem;color:#64748b;margin-bottom:14px">Liste os cargos ou funções que pertencem a este GHE.</p>

    <div class="dyn-list" id="cargo-list">
        @foreach($cargos as $i => $cargo)
        <div class="dyn-row">
            <input type="text" name="cargos[{{ $i }}]" class="form-control"
                   value="{{ $cargo }}" placeholder="ex: Soldador" maxlength="150">
            <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remover">&times;</button>
        </div>
        @endforeach
    </div>
    @error('cargos')<p class="form-error mt-1">{{ $message }}</p>@enderror

    <button type="button" class="btn-add" style="margin-top:10px" onclick="addCargo()">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Adicionar Cargo
    </button>
</div>

{{-- ── Descrições ────────────────────────────────────────────── --}}
<div class="form-section">
    <p class="form-section-title">Descrições</p>
    <div style="display:flex;flex-direction:column;gap:14px">

        <div class="form-group">
            <label class="form-label">Descrição das Atividades Realizadas</label>
            <textarea name="descricao_atividades" class="form-control" rows="4"
                      placeholder="Descreva as atividades realizadas pelos trabalhadores deste GHE…">{{ old('descricao_atividades', $ghe->descricao_atividades ?? '') }}</textarea>
            @error('descricao_atividades')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Descrição do Ambiente de Trabalho</label>
            <textarea name="descricao_ambiente" class="form-control" rows="4"
                      placeholder="Descreva o ambiente físico, instalações, layout, condições gerais…">{{ old('descricao_ambiente', $ghe->descricao_ambiente ?? '') }}</textarea>
            @error('descricao_ambiente')<p class="form-error">{{ $message }}</p>@enderror
        </div>

    </div>
</div>

<script>
let cboIdx   = {{ count($cbos) }};
let cargoIdx = {{ count($cargos) }};

function removeRow(btn) {
    btn.closest('[class^="dyn-"]').remove();
    renumberList('cbo-list',   'cbos');
    renumberList('cargo-list', 'cargos');
}

function renumberList(listId, prefix) {
    const rows = document.getElementById(listId).children;
    Array.from(rows).forEach((row, idx) => {
        row.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${idx}]`);
        });
    });
}

function addCbo() {
    const list = document.getElementById('cbo-list');
    const div  = document.createElement('div');
    div.className = 'dyn-cbo-row';
    div.innerHTML = `
        <input type="text" name="cbos[${cboIdx}][codigo]"    class="form-control" placeholder="0000-00"    maxlength="10">
        <input type="text" name="cbos[${cboIdx}][descricao]" class="form-control" placeholder="Descrição da ocupação" maxlength="200">
        <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remover">&times;</button>
    `;
    list.appendChild(div);
    div.querySelector('input').focus();
    cboIdx++;
}

function addCargo() {
    const list = document.getElementById('cargo-list');
    const div  = document.createElement('div');
    div.className = 'dyn-row';
    div.innerHTML = `
        <input type="text" name="cargos[${cargoIdx}]" class="form-control" placeholder="ex: Soldador" maxlength="150">
        <button type="button" class="btn-remove" onclick="removeRow(this)" title="Remover">&times;</button>
    `;
    list.appendChild(div);
    div.querySelector('input').focus();
    cargoIdx++;
}
</script>
