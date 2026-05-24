@php($editing = isset($avaliacao))
@php($riskValue = old('probabilidade', $avaliacao->probabilidade ?? 1) * old('severidade', $avaliacao->severidade ?? 1))

<div x-data="riskMatrix()" x-init="probabilidade={{ (int) old('probabilidade', $avaliacao->probabilidade ?? 1) }}; severidade={{ (int) old('severidade', $avaliacao->severidade ?? 1) }}" class="space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="data_avaliacao" value="Data da Avaliação" />
            <x-text-input id="data_avaliacao" name="data_avaliacao" type="date" class="mt-1 block w-full" :value="old('data_avaliacao', isset($avaliacao) && $avaliacao->data_avaliacao ? $avaliacao->data_avaliacao->format('Y-m-d') : now()->format('Y-m-d'))" required />
            <x-input-error :messages="$errors->get('data_avaliacao')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="metodologia" value="Metodologia" />
            <x-text-input id="metodologia" name="metodologia" type="text" class="mt-1 block w-full" :value="old('metodologia', $avaliacao->metodologia ?? 'Matriz 5x5 (P x S)')" />
            <x-input-error :messages="$errors->get('metodologia')" class="mt-2" />
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="probabilidade" value="Probabilidade (1 a 5)" />
            <select id="probabilidade" name="probabilidade" x-model.number="probabilidade" class="mt-1 block w-full rounded-md border-gray-300" required>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <x-input-error :messages="$errors->get('probabilidade')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="severidade" value="Severidade (1 a 5)" />
            <select id="severidade" name="severidade" x-model.number="severidade" class="mt-1 block w-full rounded-md border-gray-300" required>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <x-input-error :messages="$errors->get('severidade')" class="mt-2" />
        </div>
    </div>

    <div class="rounded-lg border p-4 bg-gray-50">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm text-gray-500">Resultado automático</p>
                <p class="text-lg font-semibold">Nível: <span x-text="nivel()"></span> — <span class="uppercase" x-text="classificacao()"></span></p>
            </div>
            <div class="text-sm text-gray-500">P × S</div>
        </div>

        <div class="grid grid-cols-5 gap-2">
            <template x-for="sev in [1,2,3,4,5]" :key="'row-'+sev">
                <template x-for="prob in [1,2,3,4,5]" :key="prob+'-'+sev">
                    <div
                        class="rounded-md border p-3 text-center text-sm font-semibold"
                        :class="cellClass(prob, sev)"
                    >
                        <div x-text="prob * sev"></div>
                        <div class="text-[10px] text-gray-600" x-show="probabilidade === prob && severidade === sev">Atual</div>
                    </div>
                </template>
            </template>
        </div>
    </div>

    <div>
        <x-input-label for="justificativa" value="Justificativa" />
        <textarea id="justificativa" name="justificativa" class="mt-1 block w-full rounded-md border-gray-300">{{ old('justificativa', $avaliacao->justificativa ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('justificativa')" class="mt-2" />
    </div>
</div>

<script>
function riskMatrix() {
    return {
        probabilidade: 1,
        severidade: 1,
        nivel() {
            return this.probabilidade * this.severidade;
        },
        classificacao() {
            const nivel = this.nivel();
            if (nivel <= 4) return 'baixo';
            if (nivel <= 12) return 'moderado';
            return 'alto';
        },
        cellClass(prob, sev) {
            const value = prob * sev;
            const active = this.probabilidade === prob && this.severidade === sev;
            let color = 'bg-green-100';
            if (value > 12) color = 'bg-red-100';
            else if (value > 4) color = 'bg-yellow-100';
            return active ? color + ' ring-2 ring-indigo-600' : color;
        }
    }
}
</script>
