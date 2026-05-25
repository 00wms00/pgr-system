<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', config('app.name')) &mdash; PGR System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased" style="background:#f1f5f9;color:#1e293b">

<div style="display:flex;min-height:100dvh">

    <aside id="sidebar"
        style="width:240px;flex-shrink:0;background:#1e293b;display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:40;transition:transform .2s">

        <div style="padding:20px 20px 16px;border-bottom:1px solid #334155">
            <div style="display:flex;align-items:center;gap:10px">
                <div style="width:32px;height:32px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:.85rem;font-weight:700;color:#f1f5f9;line-height:1.1">PGR System</p>
                    <p style="font-size:.65rem;color:#64748b;line-height:1.1">{{ auth()->user()->empresa->nome_exibicao ?? 'Sistema' }}</p>
                </div>
            </div>
        </div>

        <nav style="flex:1;overflow-y:auto;padding:12px 8px">
            @php
                $nav = [
                    ['group' => 'Principal'],
                    ['label' => 'Dashboard',   'route' => 'dashboard',      'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['group' => 'Estrutura'],
                    ['label' => 'Unidades',    'route' => 'unidades.index', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Setores',     'route' => 'setores.index',  'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    ['label' => 'GHEs',        'route' => 'ghes.index',     'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['group' => 'PGR'],
                    ['label' => 'Inventário de Riscos', 'route' => 'riscos.index',  'icon' => 'M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z'],
                    ['label' => 'Relatório PGR',       'route' => 'relatorio.pgr', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp

            @foreach($nav as $item)
                @if(isset($item['group']))
                    <p style="font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#475569;padding:14px 10px 4px">{{ $item['group'] }}</p>
                @else
                    @php $active = request()->routeIs(rtrim($item['route'], '.index') . '*'); @endphp
                    <a href="{{ route($item['route']) }}"
                        style="display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:7px;text-decoration:none;font-size:.82rem;font-weight:{{ $active ? '600' : '500' }};color:{{ $active ? '#f1f5f9' : '#94a3b8' }};background:{{ $active ? '#3b82f620' : 'transparent' }};margin-bottom:1px;transition:background .15s,color .15s"
                        onmouseover="if(!{{ $active ? 'true' : 'false' }})this.style.background='#334155';this.style.color='#f1f5f9'"
                        onmouseout="if(!{{ $active ? 'true' : 'false' }})this.style.background='transparent';this.style.color='#94a3b8'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            @if(auth()->user()->isAdmin())
                <p style="font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#475569;padding:14px 10px 4px">Administração</p>
                @php
                    $adminNav = [
                        ['label' => 'Usuários', 'route' => 'admin.usuarios.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['label' => 'Empresas',  'route' => 'admin.empresas.index', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ];
                @endphp
                @foreach($adminNav as $item)
                    @php $active = request()->routeIs('admin.' . Str::before($item['route'], '.index') . '*') || request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                        style="display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:7px;text-decoration:none;font-size:.82rem;font-weight:{{ $active ? '600' : '500' }};color:{{ $active ? '#f1f5f9' : '#94a3b8' }};background:{{ $active ? '#3b82f620' : 'transparent' }};margin-bottom:1px;transition:background .15s,color .15s"
                        onmouseover="if(!{{ $active ? 'true' : 'false' }})this.style.background='#334155';this.style.color='#f1f5f9'"
                        onmouseout="if(!{{ $active ? 'true' : 'false' }})this.style.background='transparent';this.style.color='#94a3b8'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            @endif
        </nav>

        <div style="border-top:1px solid #334155;padding:12px 16px">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <div style="min-width:0">
                    <p style="font-size:.78rem;font-weight:600;color:#e2e8f0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->name }}</p>
                    <p style="font-size:.65rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="flex-shrink:0">
                    @csrf
                    <button type="submit" title="Sair"
                        style="width:30px;height:30px;border-radius:6px;background:transparent;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;transition:background .15s"
                        onmouseover="this.style.background='#334155';this.style.color='#f87171'"
                        onmouseout="this.style.background='transparent';this.style.color='#64748b'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div style="flex:1;margin-left:240px;min-width:0;display:flex;flex-direction:column">
        <header style="background:#fff;border-bottom:1px solid #e2e8f0;padding:0 24px;height:56px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:30">
            @if(isset($header))
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%">{{ $header }}</div>
            @else
                <h1 style="font-size:.95rem;font-weight:600;color:#1e293b">@yield('titulo', 'Dashboard')</h1>
                <div style="display:flex;align-items:center;gap:12px">
                    @yield('header_actions')
                    <span style="font-size:.75rem;color:#94a3b8">{{ now()->format('d/m/Y') }}</span>
                </div>
            @endif
        </header>

        <main style="flex:1;padding:24px">
            @if(session('success'))
                <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:10px 16px;margin-bottom:16px;font-size:.85rem;color:#14532d;display:flex;align-items:center;gap:8px">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:10px 16px;margin-bottom:16px;font-size:.85rem;color:#7f1d1d;display:flex;align-items:center;gap:8px">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @yield('conteudo')
            {{ $slot ?? '' }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
