<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="text-gray-400 hover:text-gray-600">&larr;</a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Novo Plano de A&ccedil;&atilde;o
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Contexto --}}
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-6 text-sm">
                <p class="font-semibold text-indigo-800">{{ $avaliacao->riscoInventario->riscoTipo->nome }}</p>
                <p class="text-indigo-600 mt-0.5">
                    GHE: {{ $avaliacao->riscoInventario->ghe->nome }} &mdash;
                    Risco:
                    @php
                        $badgeColors = ['baixo'=>'#bbf7d0|#14532d','moderado'=>'#fef08a|#713f12','alto'=>'#fdba74|#7c2d12','critico'=>'#fca5a5|#7f1d1d'];
                        [$bg, $fg] = explode('|', $badgeColors[$avaliacao->classificacao] ?? '#e5e7eb|#374151');
                    @endphp
                    <span style="background:{{ $bg }};color:{{ $fg }};padding:1px 8px;border-radius:9999px;font-size:.75rem;font-weight:600">
                        {{ ucfirst($avaliacao->classificacao) }} ({{ $avaliacao->nivel_risco }})
                    </span>
                </p>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('planos.store') }}">
                    @csrf
                    <input type="hidden" name="avaliacao_risco_id" value="{{ $avaliacao->id }}">
                    @include('planos._form', ['plano' => null])
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                        <a href="{{ route('avaliacoes.show', $avaliacao) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                            Salvar Plano
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
