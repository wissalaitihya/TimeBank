<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TimeBank — {{ $title ?? 'Tableau de bord' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .dash-body{ background:#0A0A0A; color:#fff; font-family:'Inter',sans-serif; margin:0; min-height:100vh; }
        .dash-serif{ font-family:'Playfair Display',serif; }
        .dash-body a:focus-visible,.dash-body button:focus-visible,.dash-body input:focus-visible{ outline:2px solid rgba(173,255,47,.5); outline-offset:2px; border-radius:4px; }

        .dash-sidebar{ position:fixed; left:0; top:0; bottom:0; width:224px; background:#0D0D0D; border-right:1px solid #1E2417; display:flex; flex-direction:column; z-index:60; transition:transform .25s ease; }
        .dash-navlink{ display:flex; align-items:center; gap:10px; padding:7px 10px; border-radius:7px; text-decoration:none; font-size:13px; color:#8A8E84; border:1px solid transparent; transition:background .15s,color .15s; }
        .dash-navlink svg{ stroke:#5A5F55; flex-shrink:0; }
        .dash-navlink:hover{ background:#141414; color:#fff; }
        .dash-navlink:hover svg{ stroke:#C9CEBF; }
        .dash-navlink.active{ background:rgba(173,255,47,.10); border-color:rgba(173,255,47,.28); color:#ADFF2F; }
        .dash-navlink.active svg{ stroke:#ADFF2F; }
        .dash-icon-btn{ background:none; border:none; cursor:pointer; color:#565B51; padding:5px; border-radius:5px; display:flex; transition:color .15s,background .15s; }
        .dash-icon-btn:hover{ color:#fff; background:#161616; }
        @media (max-width:1023px){
            .dash-sidebar{ transform:translateX(-100%); }
            .dash-sidebar.is-open{ transform:translateX(0); box-shadow:24px 0 60px rgba(0,0,0,.55); }
            .dash-overlay.is-open{ display:block; }
        }
        .dash-overlay{ position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:55; display:none; }

        .dash-main{ margin-left:224px; min-height:100vh; display:flex; flex-direction:column; }
        @media (max-width:1023px){ .dash-main{ margin-left:0; } }

        .dash-topbar{ position:sticky; top:0; z-index:40; height:50px; display:flex; align-items:center; justify-content:space-between; gap:12px; padding:0 20px; background:rgba(10,10,10,.92); backdrop-filter:blur(6px); border-bottom:1px solid #1E2417; }
        .dash-search{ display:flex; align-items:center; gap:8px; width:min(300px,40vw); background:#0F0F0F; border:1px solid #1E2417; border-radius:7px; padding:7px 11px; transition:border-color .15s; }
        .dash-search:focus-within{ border-color:rgba(173,255,47,.35); }
        .dash-search input{ background:none; border:none; outline:none; color:#fff; font-size:12.5px; width:100%; font-family:'Inter',sans-serif; }
        .dash-search input::placeholder{ color:#565B51; }
        .dash-burger{ display:none; background:none; border:1px solid #1E2417; color:#C9CEBF; border-radius:7px; width:34px; height:34px; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; }
        @media (max-width:1023px){ .dash-burger{ display:flex; } }

        .dash-content{ flex:1; width:100%; max-width:1100px; padding:26px 28px 48px; }
        @media (max-width:1023px){ .dash-content{ padding:20px 16px 40px; } }

        .dash-card{ background:#0F0F0F; border:1px solid #1E2417; border-radius:10px; }
        .dash-eyebrow{ font-size:10px; letter-spacing:.14em; text-transform:uppercase; color:#6B6F64; font-weight:600; }
        .dash-h1{ font-family:'Playfair Display',serif; font-weight:700; color:#fff; letter-spacing:-.5px; }
        .dash-h1 em{ font-style:italic; color:#ADFF2F; text-shadow:0 0 26px rgba(173,255,47,.35); }
        .dash-value{ font-family:'Playfair Display',serif; color:#ADFF2F; text-shadow:0 0 30px rgba(173,255,47,.22); }

        .dash-pill{ display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:999px; font-size:10px; font-weight:600; letter-spacing:.03em; }
        .dash-pill-lime{ background:rgba(173,255,47,.10); border:1px solid rgba(173,255,47,.25); color:#ADFF2F; }
        .dash-pill-amber{ background:rgba(245,158,11,.10); border:1px solid rgba(245,158,11,.28); color:#fbbf24; }
        .dash-pill-red{ background:rgba(239,68,68,.10); border:1px solid rgba(239,68,68,.28); color:#f87171; }

        .dash-badge{ display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:999px; font-size:10px; font-weight:600; }
        .dash-badge-lime{ background:rgba(173,255,47,.10); border:1px solid rgba(173,255,47,.25); color:#ADFF2F; }
        .dash-badge-amber{ background:rgba(245,158,11,.10); border:1px solid rgba(245,158,11,.28); color:#fbbf24; }
        .dash-badge-red{ background:rgba(239,68,68,.10); border:1px solid rgba(239,68,68,.28); color:#f87171; }
        .dash-badge-muted{ background:rgba(255,255,255,.03); border:1px solid #23281C; color:#6B6F64; }

        .dash-chip{ display:inline-flex; padding:3px 9px; border-radius:999px; font-size:10px; font-weight:600; letter-spacing:.04em; text-transform:uppercase; }
        .dash-chip-lime{ background:rgba(173,255,47,.08); border:1px solid rgba(173,255,47,.25); color:#ADFF2F; }
        .dash-chip-blue{ background:rgba(59,130,246,.08); border:1px solid rgba(59,130,246,.25); color:#60a5fa; }
        .dash-chip-gray{ background:rgba(255,255,255,.03); border:1px solid #23281C; color:#6B6F64; }

        .dash-btn-ghost{ display:inline-flex; align-items:center; gap:6px; padding:5px 11px; border-radius:6px; border:1px solid #2A2F24; color:#C9CEBF; font-size:11.5px; font-weight:600; text-decoration:none; background:transparent; transition:border-color .15s,color .15s,background .15s; }
        .dash-btn-ghost:hover{ border-color:rgba(173,255,47,.4); color:#ADFF2F; background:rgba(173,255,47,.06); }

        .dash-row{ display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid #171A15; }
        .dash-row:last-child{ border-bottom:0; }
        .dash-avatar{ width:30px; height:30px; border-radius:50%; background:rgba(173,255,47,.10); border:1px solid rgba(173,255,47,.25); color:#ADFF2F; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; }
        .dash-tx-icon{ width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .dash-tx-icon.lime{ background:rgba(173,255,47,.08); border:1px solid rgba(173,255,47,.22); color:#ADFF2F; }
        .dash-tx-icon.red{ background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.22); color:#f87171; }

        .dash-empty{ border:1px dashed #262B1F; border-radius:8px; padding:22px 16px; text-align:center; color:#6B6F64; font-size:12px; }

        .dash-ledger{ display:flex; align-items:flex-start; gap:12px; background:#0F0F0F; border:1px solid #1E2417; border-radius:10px; padding:13px 14px; }

        .dash-grid-balance{ display:grid; grid-template-columns:minmax(0,1.9fr) minmax(0,1fr); gap:14px; }
        .dash-grid-bottom{ display:grid; grid-template-columns:minmax(0,1.6fr) minmax(0,1fr); gap:14px; }
        .dash-grid-ledger{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
        @media (max-width:900px){
            .dash-grid-balance{ grid-template-columns:minmax(0,1fr); }
            .dash-grid-bottom{ grid-template-columns:minmax(0,1fr); }
        }
        @media (max-width:700px){
            .dash-grid-ledger{ grid-template-columns:minmax(0,1fr); }
        }
    </style>
</head>
<body class="dash-body" x-data="{ sidebarOpen: false }">

<aside class="dash-sidebar" :class="sidebarOpen ? 'is-open' : ''">
    <div style="padding:16px 16px 14px;border-bottom:1px solid #1E2417;">
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:9px;text-decoration:none;">
            <span style="width:28px;height:28px;border-radius:7px;background:#ADFF2F;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15.5 14"/></svg>
            </span>
            <span class="dash-serif" style="font-size:15px;font-weight:700;color:#fff;letter-spacing:-.2px;">Time<em style="color:#ADFF2F;font-style:italic;">Bank</em></span>
        </a>
    </div>

    <div style="padding:14px 16px 6px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:#565B51;font-weight:600;">Menu</div>

    <nav style="flex:1;padding:2px 10px;display:flex;flex-direction:column;gap:2px;overflow-y:auto;">
        @php
        $navItems = [
            ['route' => 'dashboard',         'label' => "Vue d'ensemble",  'icon' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
            ['route' => 'profile.show',      'label' => 'Mon profil',      'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>'],
            ['route' => 'requests.index',    'label' => 'Mes demandes',    'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/>'],
            ['route' => 'offers.index',      'label' => 'Mes offres',      'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>'],
            ['route' => 'offers.public',     'label' => 'Explorer les offres','icon' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>'],
            ['route' => 'matches.index',     'label' => 'Mes matches',     'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
            ['route' => 'transactions.index','label' => 'Transactions',    'icon' => '<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>'],
            ['route' => 'reviews.index',     'label' => 'Avis',            'icon' => '<polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>'],
            ['route' => 'api-tokens.index',  'label' => 'Jetons API',      'icon' => '<path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>'],
        ];
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}" class="dash-navlink {{ $active ? 'active' : '' }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    {!! $item['icon'] !!}
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div style="padding:10px;border-top:1px solid #1E2417;">
        <div style="display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:8px;background:#0F0F0F;border:1px solid #1E2417;">
            <span style="width:30px;height:30px;border-radius:50%;background:#ADFF2F;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#000;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>
            <div style="flex:1;min-width:0;">
                <div style="font-size:12.5px;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size:10.5px;color:#6B6F64;display:flex;align-items:center;gap:5px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:{{ auth()->user()->statut_compte === 'actif' ? '#ADFF2F' : '#ef4444' }};display:inline-block;"></span>
                    {{ auth()->user()->statut_compte === 'actif' ? 'Actif' : 'Gelé' }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dash-icon-btn" title="Déconnexion">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16,17 21,12 16,7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<div class="dash-overlay" :class="sidebarOpen ? 'is-open' : ''" @click="sidebarOpen = false"></div>

<div class="dash-main">

    <header class="dash-topbar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button type="button" class="dash-burger" @click="sidebarOpen = !sidebarOpen" title="Menu" aria-label="Ouvrir le menu">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="dash-search">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#565B51" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" placeholder="Rechercher..." aria-label="Rechercher"/>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('offers.create') }}" class="dash-btn-ghost">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Proposer mon aide
            </a>
            @if(!auth()->user()->isGele())
                <a href="{{ route('requests.create') }}" class="dash-btn-ghost">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Demander de l'aide
                </a>
            @endif
            <button type="button" class="dash-icon-btn" title="Notifications" aria-label="Notifications" style="position:relative;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span style="position:absolute;top:6px;right:6px;width:5px;height:5px;border-radius:50%;background:#ADFF2F;"></span>
            </button>
            <span style="width:1px;height:18px;background:#1E2417;margin:0 2px;display:inline-block;"></span>
            <a href="{{ route('profile.show') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;border-radius:7px;padding:4px 6px;">
                <span style="width:26px;height:26px;border-radius:50%;background:rgba(173,255,47,.12);border:1px solid rgba(173,255,47,.25);color:#ADFF2F;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <span style="font-size:12.5px;font-weight:500;color:#E5E7E1;white-space:nowrap;display:none;" class="dash-topbar-name">{{ auth()->user()->name }}</span>
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#6B6F64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;" class="dash-topbar-name"><polyline points="6 9 12 15 18 9"/></svg>
            </a>
        </div>
    </header>

    @if(session('success'))
        <div style="max-width:1100px;width:100%;margin:14px auto 0;padding:0 28px;box-sizing:border-box;">
            <div style="background:rgba(173,255,47,.08);border:1px solid rgba(173,255,47,.2);border-radius:8px;padding:10px 14px;font-size:13px;color:#ADFF2F;">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div style="max-width:1100px;width:100%;margin:14px auto 0;padding:0 28px;box-sizing:border-box;">
            <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;">{{ session('error') }}</div>
        </div>
    @endif

    <main class="dash-content">
        {{ $slot }}
    </main>

</div>

</body>
</html>
