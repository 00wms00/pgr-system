<div style="display:grid;gap:20px">

    {{-- Unidade --}}
    <div>
        <label for="unidade_id" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Unidade <span style="color:#ef4444">*</span>
        </label>
        <select id="unidade_id" name="unidade_id"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('unidade_id') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;background:#fff;outline:none">
            <option value="">Selecione uma unidade...</option>
            @foreach($unidades as $unidade)
                <option value="{{ $unidade->id }}"
                    {{ old('unidade_id', $setor->unidade_id ?? '') == $unidade->id ? 'selected' : '' }}>
                    {{ $unidade->nome }}{{ $unidade->codigo ? ' (' . $unidade->codigo . ')' : '' }}
                </option>
            @endforeach
        </select>
        @error('unidade_id')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nome --}}
    <div>
        <label for="nome" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Nome do Setor <span style="color:#ef4444">*</span>
        </label>
        <input type="text" id="nome" name="nome"
            value="{{ old('nome', $setor->nome ?? '') }}"
            placeholder="Ex.: Produção, Administrativo, Manutenção"
            maxlength="150" autofocus
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('nome') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none">
        @error('nome')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

    {{-- Descrição --}}
    <div>
        <label for="descricao" style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Descrição <span style="color:#94a3b8;font-weight:400">(opcional)</span>
        </label>
        <textarea id="descricao" name="descricao" rows="3"
            placeholder="Descreva brevemente as atividades do setor..."
            maxlength="500"
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('descricao') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;outline:none;resize:vertical">{{ old('descricao', $setor->descricao ?? '') }}</textarea>
        @error('descricao')
            <p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>
        @enderror
    </div>

</div>
