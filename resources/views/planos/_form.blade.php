{{-- Requer: $avaliacao (AvaliacaoRisco). Opcional: $plano (para editar). --}}

<div style="display:grid;gap:20px">

    {{-- Hierarquia de controle (NR-1 Hierarquia) --}}
    <div>
        <label for="tipo_controle"
            style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Tipo de Controle <span style="color:#ef4444">*</span>
            <span style="font-size:.72rem;font-weight:400;color:#94a3b8">(Hierarquia NR-1)</span>
        </label>

        {{-- Cards visuais para hierarquia --}}
        <div style="display:grid;gap:6px">
            @foreach(App\Models\PlanoAcao::TIPOS_CONTROLE as $valor => $label)
            @php
                $selecionado = old('tipo_controle', $plano->tipo_controle ?? '') === $valor;
                $cores = [
                    'eliminacao'     => ['bg'=>'#f0fdf4','border'=>'#86efac','text'=>'#14532d','dot'=>'#22c55e'],
                    'substituicao'   => ['bg'=>'#f0f9ff','border'=>'#7dd3fc','text'=>'#0c4a6e','dot'=>'#3b82f6'],
                    'engenharia'     => ['bg'=>'#fffbeb','border'=>'#fcd34d','text'=>'#78350f','dot'=>'#f59e0b'],
                    'administrativo' => ['bg'=>'#fff7ed','border'=>'#fdba74','text'=>'#7c2d12','dot'=>'#f97316'],
                    'epi'            => ['bg'=>'#fef2f2','border'=>'#fca5a5','text'=>'#7f1d1d','dot'=>'#ef4444'],
                ][$valor];
            @endphp
            <label style="display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:8px;border:2px solid {{ $selecionado ? $cores['border'] : '#e2e8f0' }};background:{{ $selecionado ? $cores['bg'] : '#fff' }};cursor:pointer;transition:border .15s"
                onclick="selecionarTipo(this, '{{ $valor }}')">
                <input type="radio" name="tipo_controle" value="{{ $valor }}" @checked($selecionado)
                    style="display:none">
                <span style="width:10px;height:10px;border-radius:50%;background:{{ $cores['dot'] }};flex-shrink:0"></span>
                <span style="font-size:.85rem;font-weight:{{ $selecionado ? '700' : '500' }};color:{{ $selecionado ? $cores['text'] : '#374151' }}">{{ $label }}</span>
            </label>
            @endforeach
        </div>
        @error('tipo_controle')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Descrição --}}
    <div>
        <label for="descricao"
            style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Descrição da Ação <span style="color:#ef4444">*</span>
        </label>
        <textarea id="descricao" name="descricao" rows="3" maxlength="1000" required
            placeholder="Descreva a ação a ser implementada para eliminar ou reduzir o risco..."
            style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('descricao') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('descricao', $plano->descricao ?? '') }}</textarea>
        @error('descricao')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Responsável + Prazo --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div>
            <label for="responsavel"
                style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
                Responsável <span style="color:#ef4444">*</span>
            </label>
            <input type="text" id="responsavel" name="responsavel" maxlength="255" required
                value="{{ old('responsavel', $plano->responsavel ?? '') }}"
                placeholder="Nome ou cargo do responsável"
                style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('responsavel') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
            @error('responsavel')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="prazo"
                style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
                Prazo <span style="color:#ef4444">*</span>
            </label>
            <input type="date" id="prazo" name="prazo" required
                value="{{ old('prazo', isset($plano) ? $plano->prazo->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}"
                style="width:100%;padding:8px 12px;border:1px solid {{ $errors->has('prazo') ? '#fca5a5' : '#d1d5db' }};border-radius:7px;font-size:.85rem;color:#1e293b">
            @error('prazo')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Status --}}
    <div>
        <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:8px">
            Status <span style="color:#ef4444">*</span>
        </label>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            @foreach(App\Models\PlanoAcao::STATUS as $val => $label)
            @php
                $selecionado = old('status', $plano->status ?? 'pendente') === $val;
                $c = App\Models\PlanoAcao::STATUS_CORES[$val];
            @endphp
            <label style="display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:20px;border:2px solid {{ $selecionado ? $c['text'] : '#e2e8f0' }};background:{{ $selecionado ? $c['bg'] : '#fff' }};cursor:pointer;font-size:.82rem;font-weight:{{ $selecionado ? '700' : '500' }};color:{{ $selecionado ? $c['text'] : '#475569' }}">
                <input type="radio" name="status" value="{{ $val }}" @checked($selecionado) style="display:none">
                {{ $label }}
            </label>
            @endforeach
        </div>
        @error('status')<p style="font-size:.75rem;color:#ef4444;margin:4px 0 0">{{ $message }}</p>@enderror
    </div>

    {{-- Observação --}}
    <div>
        <label for="observacao"
            style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:5px">
            Observação
        </label>
        <textarea id="observacao" name="observacao" rows="2" maxlength="1000"
            placeholder="Informações adicionais, dependências, recursos necessários..."
            style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:7px;font-size:.85rem;color:#1e293b;resize:vertical">{{ old('observacao', $plano->observacao ?? '') }}</textarea>
    </div>

</div>

@push('scripts')
<script>
function selecionarTipo(label, valor) {
    // Desmarca todos
    document.querySelectorAll('[name="tipo_controle"]').forEach(r => r.checked = false);
    // Marca o clicado
    label.querySelector('input[type=radio]').checked = true;
    // Recarrega o visual via reload leve não é necessário: Alpine faria isso,
    // mas como usamos inline styles estáticos, basta um submit com old() para persistir.
    // Para feedback imediato sem Alpine, atualizamos via JS:
    document.querySelectorAll('[onclick^="selecionarTipo"]').forEach(el => {
        const inp = el.querySelector('input[type=radio]');
        const checked = inp.checked;
        el.style.borderColor = checked ? el.dataset.border || '#86efac' : '#e2e8f0';
    });
}
</script>
@endpush
