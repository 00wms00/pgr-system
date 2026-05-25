<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PGR — {{ $empresa->nomeExibicao }} — {{ $geradoEm->format('d/m/Y') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <style>
        /* ================================================
           RESET & BASE
        ================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 13px; }
        body {
            font-family: 'Figtree', system-ui, sans-serif;
            color: #1e293b;
            background: #f8fafc;
            line-height: 1.5;
        }

        /* ================================================
           TOOLBAR (oculta no PDF)
        ================================================ */
        .toolbar {
            background: #1e293b;
            color: #f1f5f9;
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .toolbar a {
            color: #94a3b8;
            text-decoration: none;
            font-size: .8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .toolbar a:hover { color: #f1f5f9; }
        .toolbar-actions { display: flex; gap: 12px; align-items: center; }
        .btn-pdf {
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 7px 16px;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
        }
        .btn-pdf:hover { background: #2563eb; }

        /* ================================================
           FILTRO DE UNIDADE
        ================================================ */
        .filtro-bar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .filtro-bar label { font-size: .8rem; font-weight: 600; color: #475569; }
        .filtro-bar select {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: .8rem;
            font-family: inherit;
            color: #1e293b;
            background: #fff;
            cursor: pointer;
        }
        .filtro-bar button {
            background: #f1f5f9;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: .8rem;
            font-family: inherit;
            cursor: pointer;
            color: #374151;
        }
        .filtro-bar button:hover { background: #e2e8f0; }

        /* ================================================
           DOCUMENTO
        ================================================ */
        .documento {
            max-width: 960px;
            margin: 24px auto;
            padding: 0 16px 64px;
        }

        /* Capa */
        .capa {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            margin-bottom: 32px;
        }
        .capa-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 3px 10px;
            border-radius: 999px;
            margin-bottom: 16px;
        }
        .capa h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .capa h2 {
            font-size: 1rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 24px;
        }
        .capa-meta {
            display: flex;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
            font-size: .78rem;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
        .capa-meta strong { color: #1e293b; display: block; }

        /* Sumário de riscos */
        .resumo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-bottom: 32px;
        }
        .resumo-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }
        .resumo-card .valor {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }
        .resumo-card .label {
            font-size: .7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .resumo-card.critico .valor { color: #dc2626; }
        .resumo-card.alto .valor    { color: #ea580c; }
        .resumo-card.medio .valor   { color: #d97706; }
        .resumo-card.baixo .valor   { color: #16a34a; }
        .resumo-card.total .valor   { color: #1d4ed8; }

        /* Seções */
        .secao {
            margin-bottom: 32px;
        }
        .secao-titulo {
            font-size: .95rem;
            font-weight: 700;
            color: #0f172a;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
            margin-bottom: 16px;
        }
        .setor-titulo {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #475569;
            margin: 20px 0 8px;
        }
        .ghe-titulo {
            font-size: .8rem;
            font-weight: 600;
            color: #1e293b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px 6px 0 0;
            padding: 8px 12px;
            margin-top: 12px;
        }

        /* Tabela de riscos */
        .tabela-riscos {
            width: 100%;
            border-collapse: collapse;
            font-size: .76rem;
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
        }
        .tabela-riscos th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-align: left;
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .tabela-riscos td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .tabela-riscos tr:last-child td { border-bottom: none; }
        .tabela-riscos tr:hover td { background: #f8fafc; }

        /* Badge de classificação */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: .65rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-critico  { background: #fee2e2; color: #991b1b; }
        .badge-alto     { background: #ffedd5; color: #9a3412; }
        .badge-medio    { background: #fef9c3; color: #854d0e; }
        .badge-baixo    { background: #dcfce7; color: #14532d; }
        .badge-sem-aval { background: #f1f5f9; color: #64748b; }

        /* Planos de ação inline */
        .plano-item {
            font-size: .72rem;
            color: #374151;
            padding: 3px 0;
            border-bottom: 1px dashed #f1f5f9;
            display: flex;
            gap: 6px;
            align-items: flex-start;
        }
        .plano-item:last-child { border-bottom: none; }
        .plano-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 4px;
        }
        .status-pendente   { background: #fbbf24; }
        .status-andamento  { background: #3b82f6; }
        .status-concluido  { background: #22c55e; }
        .status-cancelado  { background: #94a3b8; }

        /* Sem dados */
        .sem-dados {
            text-align: center;
            color: #94a3b8;
            font-size: .78rem;
            padding: 24px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        /* Rodapé */
        .rodape {
            margin-top: 48px;
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
            font-size: .7rem;
            color: #94a3b8;
            text-align: center;
        }

        /* ================================================
           IMPRESSÃO / PDF
        ================================================ */
        @media print {
            html { font-size: 11px; }
            body { background: #fff; }
            .toolbar, .filtro-bar { display: none !important; }
            .documento { max-width: 100%; margin: 0; padding: 0 0 32px; }
            .capa { border: none; border-radius: 0; padding: 24px 0; }
            .secao { page-break-inside: avoid; }
            .tabela-riscos { page-break-inside: auto; }
            .tabela-riscos tr { page-break-inside: avoid; }
            .ghe-titulo { page-break-after: avoid; }
        }
    </style>
</head>
<body>

{{-- ============================================================
     TOOLBAR
============================================================ --}}
<div class="toolbar" id="toolbar">
    <a href="{{ route('dashboard') }}">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Voltar ao sistema
    </a>
    <div style="font-size:.82rem;font-weight:600">📋 Relatório PGR — {{ $empresa->nomeExibicao }}</div>
    <div class="toolbar-actions">
        <span style="font-size:.72rem;color:#64748b">Gerado em {{ $geradoEm->format('d/m/Y H:i') }}</span>
        <button class="btn-pdf" onclick="imprimirPDF()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Exportar PDF
        </button>
    </div>
</div>

{{-- ============================================================
     FILTRO DE UNIDADE
============================================================ --}}
<div class="filtro-bar" id="filtro-bar">
    <label for="filtro-unidade">Filtrar por unidade:</label>
    <form method="GET" action="{{ route('relatorio.pgr') }}" style="display:flex;gap:8px;align-items:center">
        <select name="unidade_id" id="filtro-unidade" onchange="this.form.submit()">
            <option value="">Todas as unidades</option>
            @foreach($unidades as $u)
                <option value="{{ $u->id }}" @selected($unidadeFiltro == $u->id)>{{ $u->nome }}</option>
            @endforeach
        </select>
        @if($unidadeFiltro)
            <a href="{{ route('relatorio.pgr') }}" style="font-size:.78rem;color:#64748b">✕ Limpar filtro</a>
        @endif
    </form>
</div>

{{-- ============================================================
     DOCUMENTO
============================================================ --}}
<div class="documento">

    {{-- CAPA --}}
    <div class="capa">
        <div class="capa-badge">NR-1 / eSocial</div>
        <h1>Programa de Gerenciamento de Riscos</h1>
        <h2>{{ $empresa->razao_social }}</h2>
        <div class="capa-meta">
            @if($empresa->cnpj)
                <div><strong>CNPJ</strong>{{ $empresa->cnpj }}</div>
            @endif
            @if($empresa->endereco)
                <div><strong>Endereço</strong>{{ $empresa->endereco }}</div>
            @endif
            <div><strong>Data do Relatório</strong>{{ $geradoEm->format('d/m/Y') }}</div>
            <div><strong>Unidades</strong>{{ $unidadesRelatorio->count() }}</div>
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
            return $ult && strtolower($ult->classificacao) === strtolower($cls);
        })->count();

        $semAvaliacao = $todosRiscos->filter(fn ($r) => $r->avaliacoes->isEmpty())->count();
    @endphp

    <div class="resumo-grid">
        <div class="resumo-card total">
            <div class="valor">{{ $todosRiscos->count() }}</div>
            <div class="label">Total de Riscos</div>
        </div>
        <div class="resumo-card critico">
            <div class="valor">{{ $contar('Crítico') }}</div>
            <div class="label">Crítico</div>
        </div>
        <div class="resumo-card alto">
            <div class="valor">{{ $contar('Alto') }}</div>
            <div class="label">Alto</div>
        </div>
        <div class="resumo-card medio">
            <div class="valor">{{ $contar('Médio') }}</div>
            <div class="label">Médio</div>
        </div>
        <div class="resumo-card baixo">
            <div class="valor">{{ $contar('Baixo') }}</div>
            <div class="label">Baixo</div>
        </div>
        @if($semAvaliacao > 0)
        <div class="resumo-card" style="border-color:#f1f5f9">
            <div class="valor" style="color:#94a3b8">{{ $semAvaliacao }}</div>
            <div class="label">Sem Avaliação</div>
        </div>
        @endif
    </div>

    {{-- INVENTÁRIO POR UNIDADE --}}
    @forelse($unidadesRelatorio as $unidade)
        <div class="secao">
            <div class="secao-titulo">🏭 {{ $unidade->nome }}</div>

            @forelse($unidade->setores as $setor)
                <div class="setor-titulo">📂 Setor: {{ $setor->nome }}</div>

                @forelse($setor->ghes as $ghe)
                    <div class="ghe-titulo">👥 GHE: {{ $ghe->nome }}</div>

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
                                        $av = $risco->avaliacoes->first();
                                        $cls = $av ? strtolower($av->classificacao) : 'sem-aval';
                                        $badgeClass = match($cls) {
                                            'crítico', 'critico' => 'badge-critico',
                                            'alto'   => 'badge-alto',
                                            'médio', 'medio' => 'badge-medio',
                                            'baixo'  => 'badge-baixo',
                                            default  => 'badge-sem-aval',
                                        };
                                    @endphp
                                    <tr>
                                        <td>
                                            <div style="font-weight:600">{{ $risco->riscoTipo->nome }}</div>
                                            <div style="color:#64748b;font-size:.68rem">{{ $risco->riscoTipo->grupo }}</div>
                                        </td>
                                        <td>{{ $risco->agente }}</td>
                                        <td style="color:#64748b">{{ Str::limit($risco->fonte_geradora, 60) }}</td>
                                        <td style="text-align:center;font-weight:700">{{ $av?->probabilidade ?? '—' }}</td>
                                        <td style="text-align:center;font-weight:700">{{ $av?->severidade ?? '—' }}</td>
                                        <td style="text-align:center;font-weight:700">{{ $av ? $av->probabilidade * $av->severidade : '—' }}</td>
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
                                                        $stClass = match($plano->status) {
                                                            'concluido'  => 'status-concluido',
                                                            'em_andamento' => 'status-andamento',
                                                            'cancelado'  => 'status-cancelado',
                                                            default      => 'status-pendente',
                                                        };
                                                    @endphp
                                                    <div class="plano-item">
                                                        <span class="plano-status {{ $stClass }}"></span>
                                                        <span>{{ Str::limit($plano->descricao, 60) }}
                                                            @if($plano->prazo)
                                                                <span style="color:#94a3b8">({{ \Carbon\Carbon::parse($plano->prazo)->format('d/m/Y') }})</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span style="color:#94a3b8;font-size:.7rem">—</span>
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
        <div class="sem-dados" style="padding:40px">
            Nenhum dado encontrado. Cadastre unidades, setores, GHEs e riscos primeiro.
        </div>
    @endforelse

    {{-- RODAPÉ --}}
    <div class="rodape">
        Documento gerado pelo PGR System em {{ $geradoEm->format('d/m/Y \à\s H:i') }}
        &mdash; {{ $empresa->razao_social }}
        @if($empresa->cnpj) &mdash; CNPJ: {{ $empresa->cnpj }} @endif
    </div>

</div>

<script>
function imprimirPDF() {
    // Ocultar toolbar e filtro antes de imprimir
    document.getElementById('toolbar').style.display = 'none';
    document.getElementById('filtro-bar').style.display = 'none';
    window.print();
    document.getElementById('toolbar').style.display = '';
    document.getElementById('filtro-bar').style.display = '';
}
</script>

</body>
</html>
