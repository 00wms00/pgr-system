<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<style>
/* DomPDF: sem web fonts externas, usar apenas fontes do servidor */
* { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 11px; }
body {
    font-family: DejaVu Sans, sans-serif;
    color: #1e293b;
    background: #fff;
    line-height: 1.4;
}

/* CAPA */
.capa {
    text-align: center;
    padding: 40px 24px 32px;
    border-bottom: 2px solid #3b82f6;
    margin-bottom: 24px;
}
.capa-badge {
    display: inline-block;
    background: #dbeafe;
    color: #1d4ed8;
    font-size: 7px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 3px 10px;
    border-radius: 999px;
    margin-bottom: 12px;
}
.capa h1 { font-size: 18px; font-weight: bold; color: #0f172a; margin-bottom: 4px; }
.capa h2 { font-size: 12px; color: #475569; margin-bottom: 20px; }
.capa-meta { font-size: 8.5px; color: #64748b; }
.capa-meta table { width: auto; margin: 0 auto; }
.capa-meta td { padding: 2px 16px; }
.capa-meta strong { color: #1e293b; display: block; }

/* RESUMO */
.resumo-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
.resumo-table td {
    text-align: center;
    padding: 10px 6px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}
.resumo-valor { font-size: 20px; font-weight: bold; }
.resumo-label { font-size: 7px; text-transform: uppercase; letter-spacing: .05em; color: #64748b; }
.cor-total   { color: #1d4ed8; }
.cor-critico { color: #dc2626; }
.cor-alto    { color: #ea580c; }
.cor-medio   { color: #d97706; }
.cor-baixo   { color: #16a34a; }

/* SEÇÕES */
.secao { margin-bottom: 20px; }
.secao-titulo {
    font-size: 10px;
    font-weight: bold;
    color: #0f172a;
    border-left: 4px solid #3b82f6;
    padding: 3px 0 3px 8px;
    margin-bottom: 10px;
    background: #f8fafc;
}
.setor-titulo {
    font-size: 8px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #475569;
    margin: 12px 0 4px;
}
.ghe-titulo {
    font-size: 8.5px;
    font-weight: bold;
    color: #1e293b;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 5px 8px;
    margin-top: 8px;
}

/* TABELA DE RISCOS */
.tabela-riscos {
    width: 100%;
    border-collapse: collapse;
    font-size: 7.5px;
    margin-bottom: 8px;
    border: 1px solid #e2e8f0;
}
.tabela-riscos th {
    background: #f1f5f9;
    color: #475569;
    font-weight: bold;
    text-align: left;
    padding: 5px 6px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 6.5px;
    text-transform: uppercase;
    letter-spacing: .04em;
    white-space: nowrap;
}
.tabela-riscos td {
    padding: 5px 6px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
}
.tabela-riscos tr:last-child td { border-bottom: none; }

/* BADGES */
.badge {
    display: inline;
    padding: 2px 6px;
    border-radius: 999px;
    font-size: 6.5px;
    font-weight: bold;
    white-space: nowrap;
}
.badge-critico  { background: #fee2e2; color: #991b1b; }
.badge-alto     { background: #ffedd5; color: #9a3412; }
.badge-medio    { background: #fef9c3; color: #854d0e; }
.badge-baixo    { background: #dcfce7; color: #14532d; }
.badge-sem-aval { background: #f1f5f9; color: #64748b; }

/* PLANOS */
.plano-item { font-size: 7px; color: #374151; padding: 2px 0; }
.plano-dot {
    display: inline-block;
    width: 6px; height: 6px;
    border-radius: 50%;
    margin-right: 4px;
    vertical-align: middle;
}
.dot-pendente   { background: #fbbf24; }
.dot-andamento  { background: #3b82f6; }
.dot-concluido  { background: #22c55e; }
.dot-cancelado  { background: #94a3b8; }

/* SEM DADOS */
.sem-dados {
    text-align: center;
    color: #94a3b8;
    font-size: 8px;
    padding: 12px;
    border: 1px solid #e2e8f0;
}

/* RODÀPÉ */
.rodape {
    margin-top: 32px;
    border-top: 1px solid #e2e8f0;
    padding-top: 8px;
    font-size: 7px;
    color: #94a3b8;
    text-align: center;
}

/* QUEBRA DE PÁGINA */
.page-break { page-break-after: always; }
</style>
</head>
<body>

{{-- CAPA --}}
<div class="capa">
    <div class="capa-badge">NR-1 / eSocial</div>
    <h1>Programa de Gerenciamento de Riscos</h1>
    <h2>{{ $empresa->razao_social }}</h2>
    <div class="capa-meta">
        <table>
            <tr>
                @if($empresa->cnpj)
                    <td><strong>CNPJ</strong>{{ $empresa->cnpj }}</td>
                @endif
                <td><strong>Data do Relatório</strong>{{ $geradoEm->format('d/m/Y') }}</td>
                <td><strong>Unidades</strong>{{ $unidadesRelatorio->count() }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- RESUMO EXECUTIVO --}}
@php
    $todosRiscos = $unidadesRelatorio->flatMap(fn ($u) =>
        $u->setores->flatMap(fn ($s) =>
            $s->ghes->flatMap(fn ($g) => $g->riscosInventario)
        )
    );
    $contar = fn (string $cls) => $todosRiscos->filter(function ($r) use ($cls) {
        $ult = $r->avaliacoes->first();
        return $ult && mb_strtolower($ult->classificacao) === mb_strtolower($cls);
    })->count();
    $semAvaliacao = $todosRiscos->filter(fn ($r) => $r->avaliacoes->isEmpty())->count();
@endphp

<table class="resumo-table">
    <tr>
        <td>
            <div class="resumo-valor cor-total">{{ $todosRiscos->count() }}</div>
            <div class="resumo-label">Total</div>
        </td>
        <td>
            <div class="resumo-valor cor-critico">{{ $contar('Crítico') }}</div>
            <div class="resumo-label">Crítico</div>
        </td>
        <td>
            <div class="resumo-valor cor-alto">{{ $contar('Alto') }}</div>
            <div class="resumo-label">Alto</div>
        </td>
        <td>
            <div class="resumo-valor cor-medio">{{ $contar('Médio') }}</div>
            <div class="resumo-label">Médio</div>
        </td>
        <td>
            <div class="resumo-valor cor-baixo">{{ $contar('Baixo') }}</div>
            <div class="resumo-label">Baixo</div>
        </td>
        @if($semAvaliacao > 0)
        <td>
            <div class="resumo-valor" style="color:#94a3b8">{{ $semAvaliacao }}</div>
            <div class="resumo-label">Sem Avaliação</div>
        </td>
        @endif
    </tr>
</table>

{{-- INVENTÁRIO POR UNIDADE --}}
@forelse($unidadesRelatorio as $unidade)
    <div class="secao">
        <div class="secao-titulo">{{ $unidade->nome }}</div>

        @forelse($unidade->setores as $setor)
            <div class="setor-titulo">Setor: {{ $setor->nome }}</div>

            @forelse($setor->ghes as $ghe)
                <div class="ghe-titulo">GHE: {{ $ghe->nome }}</div>

                @if($ghe->riscosInventario->isEmpty())
                    <div class="sem-dados">Nenhum risco cadastrado neste GHE.</div>
                @else
                    <table class="tabela-riscos">
                        <thead>
                            <tr>
                                <th>Tipo / Grupo</th>
                                <th>Agente / Perigo</th>
                                <th>Fonte Geradora</th>
                                <th style="text-align:center">P</th>
                                <th style="text-align:center">S</th>
                                <th style="text-align:center">Nível</th>
                                <th style="text-align:center">Classificação</th>
                                <th>Planos de Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ghe->riscosInventario as $risco)
                                @php
                                    $av  = $risco->avaliacoes->first();
                                    $cls = $av ? mb_strtolower($av->classificacao) : 'sem-aval';
                                    $badgeClass = match(true) {
                                        in_array($cls, ['crítico','critico']) => 'badge-critico',
                                        $cls === 'alto'                       => 'badge-alto',
                                        in_array($cls, ['médio','medio'])     => 'badge-medio',
                                        $cls === 'baixo'                      => 'badge-baixo',
                                        default                               => 'badge-sem-aval',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $risco->riscoTipo->nome }}</strong><br>
                                        <span style="color:#64748b;font-size:6.5px">{{ $risco->riscoTipo->grupo }}</span>
                                    </td>
                                    <td>{{ $risco->agente }}</td>
                                    <td style="color:#64748b">{{ Str::limit($risco->fonte_geradora, 55) }}</td>
                                    <td style="text-align:center;font-weight:bold">{{ $av?->probabilidade ?? '—' }}</td>
                                    <td style="text-align:center;font-weight:bold">{{ $av?->severidade ?? '—' }}</td>
                                    <td style="text-align:center;font-weight:bold">{{ $av ? $av->probabilidade * $av->severidade : '—' }}</td>
                                    <td style="text-align:center">
                                        @if($av)
                                            <span class="badge {{ $badgeClass }}">{{ $av->classificacao }}</span>
                                        @else
                                            <span class="badge badge-sem-aval">Sem avaliação</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($av && $av->planosAcao->isNotEmpty())
                                            @foreach($av->planosAcao as $plano)
                                                @php
                                                    $dotClass = match($plano->status) {
                                                        'concluido'    => 'dot-concluido',
                                                        'em_andamento' => 'dot-andamento',
                                                        'cancelado'    => 'dot-cancelado',
                                                        default        => 'dot-pendente',
                                                    };
                                                @endphp
                                                <div class="plano-item">
                                                    <span class="plano-dot {{ $dotClass }}"></span>
                                                    {{ Str::limit($plano->descricao, 55) }}
                                                    @if($plano->prazo)
                                                        <span style="color:#94a3b8">({{ \Carbon\Carbon::parse($plano->prazo)->format('d/m/Y') }})</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <span style="color:#94a3b8">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @empty
                <div class="sem-dados">Nenhum GHE cadastrado neste setor.</div>
            @endforelse
        @empty
            <div class="sem-dados">Nenhum setor cadastrado nesta unidade.</div>
        @endforelse
    </div>
@empty
    <div class="sem-dados" style="padding:24px">
        Nenhum dado encontrado.
    </div>
@endforelse

{{-- RODÀPÉ --}}
<div class="rodape">
    Documento gerado pelo PGR System em {{ $geradoEm->format('d/m/Y \\\u00e0\\s H:i') }}
    &mdash; {{ $empresa->razao_social }}
    @if($empresa->cnpj) &mdash; CNPJ: {{ $empresa->cnpj }} @endif
</div>

</body>
</html>
