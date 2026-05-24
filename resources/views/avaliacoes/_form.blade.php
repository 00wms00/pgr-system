@php
    $p = old('probabilidade', $avaliacao->probabilidade ?? null);
    $s = old('severidade',    $avaliacao->severidade    ?? null);
@endphp

<div class="space-y-6">

    {{-- Data --}}
    <div>
        <x-input-label for="data_avaliacao" value="Data da Avaliação" />
        <x-text-input id="data_avaliacao" name="data_avaliacao" type="date" class="mt-1 block w-48"
            :value="old('data_avaliacao', isset($avaliacao) ? $avaliacao->data_avaliacao?->format('Y-m-d') : now()->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('data_avaliacao')" class="mt-1" />
    </div>

    {{-- Matriz interativa --}}
    <div>
        <x-input-label value="Selecione a célula na Matriz P × S" />
        @if($errors->has('probabilidade') || $errors->has('severidade'))
            <p class="mt-1 text-sm text-red-600">Selecione uma célula na matriz.</p>
        @endif
        <div class="mt-2">
            @include('avaliacoes._matrix', ['selectedP' => $p, 'selectedS' => $s, 'interactive' => true])
        </div>
    </div>

    {{-- Metodologia --}}
    <div>
        <x-input-label for="metodologia" value="Metodologia" />
        <x-text-input id="metodologia" name="metodologia" type="text" class="mt-1 block w-full"
            :value="old('metodologia', $avaliacao->metodologia ?? 'Matriz 5x5 (P x S)')" />
        <x-input-error :messages="$errors->get('metodologia')" class="mt-1" />
    </div>

    {{-- Justificativa --}}
    <div>
        <x-input-label for="justificativa" value="Justificativa" />
        <textarea id="justificativa" name="justificativa" rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
        >{{ old('justificativa', $avaliacao->justificativa ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('justificativa')" class="mt-1" />
    </div>

</div>
