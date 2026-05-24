@php($editing = isset($risco))

<div class="space-y-6">
    <div>
        <x-input-label for="ghe_id" value="GHE" />
        <select id="ghe_id" name="ghe_id" class="mt-1 block w-full rounded-md border-gray-300" required>
            <option value="">Selecione...</option>
            @foreach($ghes as $ghe)
                <option value="{{ $ghe->id }}" @selected(old('ghe_id', $selectedGheId ?? ($risco->ghe_id ?? '')) == $ghe->id)>
                    {{ $ghe->nome }} — {{ $ghe->setor->nome }} / {{ $ghe->setor->unidade->nome }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('ghe_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="risco_tipo_id" value="Tipo de Risco (Tabela 24 eSocial)" />
        <select id="risco_tipo_id" name="risco_tipo_id" class="mt-1 block w-full rounded-md border-gray-300" required>
            <option value="">Selecione...</option>
            @foreach($tipos->groupBy('grupo') as $grupo => $itens)
                <optgroup label="{{ $grupo }}">
                    @foreach($itens as $tipo)
                        <option value="{{ $tipo->id }}" @selected(old('risco_tipo_id', $risco->risco_tipo_id ?? '') == $tipo->id)>
                            {{ $tipo->codigo_esocial }} — {{ $tipo->nome }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('risco_tipo_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="agente" value="Agente / Perigo" />
        <x-text-input id="agente" name="agente" type="text" class="mt-1 block w-full" :value="old('agente', $risco->agente ?? '')" required />
        <x-input-error :messages="$errors->get('agente')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="fonte_geradora" value="Fonte Geradora" />
        <textarea id="fonte_geradora" name="fonte_geradora" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('fonte_geradora', $risco->fonte_geradora ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('fonte_geradora')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="possiveis_lesoes" value="Possíveis Lesões" />
        <textarea id="possiveis_lesoes" name="possiveis_lesoes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('possiveis_lesoes', $risco->possiveis_lesoes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('possiveis_lesoes')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="danos_saude" value="Danos à Saúde" />
        <textarea id="danos_saude" name="danos_saude" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('danos_saude', $risco->danos_saude ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('danos_saude')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="medidas_existentes" value="Medidas Existentes" />
        <textarea id="medidas_existentes" name="medidas_existentes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('medidas_existentes', $risco->medidas_existentes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('medidas_existentes')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="observacoes" value="Observações" />
        <textarea id="observacoes" name="observacoes" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('observacoes', $risco->observacoes ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('observacoes')" class="mt-2" />
    </div>
</div>
