@php
    $tipos = \App\Models\PlanoAcao::TIPOS_CONTROLE;
    $statusList = \App\Models\PlanoAcao::STATUS;
@endphp

<div class="space-y-5">

    {{-- Tipo de Controle --}}
    <div>
        <x-input-label for="tipo_controle" value="Tipo de Controle (Hierarquia de Controles)" />
        <select id="tipo_controle" name="tipo_controle"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <option value="">Selecione...</option>
            @foreach($tipos as $key => $label)
                <option value="{{ $key }}" {{ old('tipo_controle', $plano?->tipo_controle) === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-gray-400">Siga a hierarquia: Elimina&ccedil;&atilde;o &gt; Substitui&ccedil;&atilde;o &gt; Engenharia &gt; Administrativo &gt; EPI</p>
        <x-input-error :messages="$errors->get('tipo_controle')" class="mt-1" />
    </div>

    {{-- Descricao --}}
    <div>
        <x-input-label for="descricao" value="Descri&ccedil;&atilde;o da A&ccedil;&atilde;o" />
        <textarea id="descricao" name="descricao" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
            placeholder="Descreva a a&ccedil;&atilde;o a ser executada..."
        >{{ old('descricao', $plano?->descricao) }}</textarea>
        <x-input-error :messages="$errors->get('descricao')" class="mt-1" />
    </div>

    {{-- Responsavel + Prazo --}}
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="responsavel" value="Respons&aacute;vel" />
            <x-text-input id="responsavel" name="responsavel" type="text" class="mt-1 block w-full"
                :value="old('responsavel', $plano?->responsavel)"
                placeholder="Nome do respons&aacute;vel" />
            <x-input-error :messages="$errors->get('responsavel')" class="mt-1" />
        </div>
        <div>
            <x-input-label for="prazo" value="Prazo" />
            <x-text-input id="prazo" name="prazo" type="date" class="mt-1 block w-full"
                :value="old('prazo', $plano?->prazo?->format('Y-m-d'))" />
            <x-input-error :messages="$errors->get('prazo')" class="mt-1" />
        </div>
    </div>

    {{-- Status --}}
    <div>
        <x-input-label for="status" value="Status" />
        <div class="mt-2 flex gap-4 flex-wrap">
            @foreach($statusList as $key => $label)
                @php
                    $checked = old('status', $plano?->status ?? 'pendente') === $key;
                    $colors  = ['pendente' => '#e5e7eb|#374151', 'em_andamento' => '#bfdbfe|#1e3a8a', 'concluido' => '#bbf7d0|#14532d'];
                    [$bg, $fg] = explode('|', $colors[$key]);
                @endphp
                <label style="display:inline-flex;align-items:center;gap:6px;cursor:pointer">
                    <input type="radio" name="status" value="{{ $key }}" {{ $checked ? 'checked' : '' }}
                        class="text-indigo-600 focus:ring-indigo-500">
                    <span style="background:{{ $bg }};color:{{ $fg }};padding:2px 10px;border-radius:9999px;font-size:.8rem;font-weight:600">
                        {{ $label }}
                    </span>
                </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('status')" class="mt-1" />
    </div>

    {{-- Observacao --}}
    @if(isset($plano))
    <div>
        <x-input-label for="observacao" value="Observa&ccedil;&atilde;o" />
        <textarea id="observacao" name="observacao" rows="2"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
        >{{ old('observacao', $plano?->observacao) }}</textarea>
        <x-input-error :messages="$errors->get('observacao')" class="mt-1" />
    </div>
    @endif

</div>
