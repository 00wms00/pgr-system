<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:.95rem;font-weight:600;color:#1e293b">Nova Avaliação de Risco</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card de contexto do risco --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold">Risco</h3>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $risco->ghe->nome }}
                    &bull; {{ $risco->riscoTipo->grupo }} / {{ $risco->riscoTipo->nome }}
                    &bull; {{ $risco->agente }}
                </p>
            </div>

            {{-- Formulário com Alpine.js para campos quantitativos --}}
            <div class="bg-white shadow sm:rounded-lg p-6"
                 x-data="avaliacaoForm({{ $agentesJson }})"
                 x-init="init()">
                <form method="POST" action="{{ route('avaliacoes.store', $risco) }}" class="space-y-6">
                    @csrf
                    @include('avaliacoes._form')
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('riscos.show', $risco) }}" class="px-4 py-2 rounded-md border">Cancelar</a>
                        <x-primary-button>Salvar avaliação</x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    function avaliacaoForm(agentes) {
        return {
            agentes: agentes,
            agenteId: '',
            valorMedido: '',
            riscoCalc: { probabilidade: '', severidade: '', classificacao: '' },

            get agenteAtual() {
                return this.agentes.find(a => a.id == this.agenteId) ?? null;
            },

            init() {
                // Se não há agentes quantitativos para este tipo de risco, não faz nada
            },

            onAgenteChange() {
                this.valorMedido = '';
                this.riscoCalc = { probabilidade: '', severidade: '', classificacao: '' };
            },

            calcular() {
                const ag = this.agenteAtual;
                if (!ag || this.valorMedido === '') return;

                const v = parseFloat(this.valorMedido);
                const faixa = ag.faixas.find(f => {
                    const acima = v >= f.valor_min;
                    const abaixo = f.valor_max === null || v <= f.valor_max;
                    return acima && abaixo;
                });

                if (faixa) {
                    this.riscoCalc = {
                        probabilidade: faixa.probabilidade,
                        severidade:    faixa.severidade,
                        classificacao: faixa.classificacao,
                    };
                } else {
                    this.riscoCalc = { probabilidade: '', severidade: '', classificacao: '' };
                }
            },
        };
    }
    </script>
    @endpush
</x-app-layout>
