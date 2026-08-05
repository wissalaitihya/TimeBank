<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TimeBank — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background:#0A0A0A;color:#fff;font-family:'Inter',sans-serif;min-height:100vh;display:flex;margin:0;" {{ $attributes }}>

<!-- ── SIDEBAR ──────────────────────────────────────────── -->
<aside style="
    width:195px;min-height:100vh;
    background:#0D0D0D;
    border-right:1px solid #1F1F1F;
    display:flex;flex-direction:column;
    position:fixed;left:0;top:0;z-index:50;
">
    <!-- Logo -->
    <div style="padding:18px 16px;border-bottom:1px solid #1F1F1F;">
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
            <div style="width:30px;height:30px;background:#FF6500;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">⏱</div>
            <span style="font-size:15px;font-weight:600;color:#fff;font-family:'Playfair Display',serif;">
                Time<em style="color:#FF6500;font-style:italic;">Bank</em>
            </span>
        </a>
    </div>

    <!-- Search -->
    <div style="padding:10px 12px;">
        <div style="display:flex;align-items:center;gap:8px;background:#111;border:1px solid #1F1F1F;border-radius:8px;padding:7px 10px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" placeholder="Rechercher..." style="background:none;border:none;outline:none;color:#fff;font-size:12.5px;font-family:'Inter',sans-serif;width:100%;" />
        </div>
    </div>

    <!-- Nav label -->
    <div style="padding:12px 16px 6px;font-size:10px;letter-spacing:0.12em;text-transform:uppercase;color:#444;font-weight:600;">Menu</div>

    <!-- Nav items -->
    <nav style="flex:1;padding:4px 10px;display:flex;flex-direction:column;gap:2px;">

        @php
        $navItems = [
            ['route' => 'dashboard',         'label' => "Vue d'ensemble",  'icon' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'],
            ['route' => 'profile.show',      'label' => 'Mon profil',      'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>'],
            ['route' => 'requests.index',    'label' => 'Mes demandes',    'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/>'],
            ['route' => 'offers.index',      'label' => 'Mes offres',      'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>'],
            ['route' => 'matches.index',     'label' => 'Mes matches',     'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
            ['route' => 'transactions.index','label' => 'Transactions',    'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
            ['route' => 'reviews.index',     'label' => 'Avis',            'icon' => '<polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>'],
            ['route' => 'api-tokens.index',  'label' => 'Jetons API',      'icon' => '<path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>'],
        ];
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}" style="
                display:flex;align-items:center;gap:10px;
                padding:8px 10px;border-radius:8px;
                text-decoration:none;font-size:13px;
                color:{{ $active ? '#F5F2ED' : '#888' }};
                background:{{ $active ? 'rgba(255,101,0,0.08)' : 'transparent' }};
                font-weight:{{ $active ? '500' : '400' }};
                border-left:{{ $active ? '2px solid #FF6500' : '2px solid transparent' }};
                padding-left:{{ $active ? '8px' : '10px' }};
                margin-left:{{ $active ? '-2px' : '0' }};
                transition:all 0.15s;
            "
            onmouseover="if(!{{ $active ? 'true' : 'false' }})this.style.background='#111',this.style.color='#fff'"
            onmouseout="if(!{{ $active ? 'true' : 'false' }})this.style.background='transparent',this.style.color='#888'"
            >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $active ? '#FF6500' : '#666' }}" stroke-width="1.8"
                     style="flex-shrink:0;">
                    {!! $item['icon'] !!}
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach

    </nav>

    <!-- Bottom user card -->
    <div style="padding:10px;border-top:1px solid #1F1F1F;">
        <div style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:8px;background:#111;">
            <div style="width:32px;height:32px;border-radius:50%;background:#FF6500;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#000;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size:11px;color:#888;display:flex;align-items:center;gap:4px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:{{ auth()->user()->statut_compte === 'actif' ? '#FF6500' : '#ef4444' }};display:inline-block;"></span>
                    {{ auth()->user()->statut_compte === 'actif' ? 'Actif' : 'Gelé' }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#555;padding:4px;border-radius:4px;display:flex;transition:color 0.15s;"
                        onmouseover="this.style.color='#fff'"
                        onmouseout="this.style.color='#555'"
                        title="Déconnexion">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16,17 21,12 16,7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>

<!-- ── MAIN CONTENT ─────────────────────────────────────── -->
<div style="margin-left:195px;flex:1;min-height:100vh;display:flex;flex-direction:column;">

    <!-- Top bar -->
    <header style="height:54px;border-bottom:1px solid #1F1F1F;display:flex;align-items:center;justify-content:space-between;padding:0 28px;position:sticky;top:0;background:#0A0A0A;z-index:40;">
        <div></div>
        <div style="display:flex;align-items:center;gap:12px;">
            <!-- Balance pill -->
            <div style="display:flex;align-items:center;gap:6px;background:rgba(255,101,0,0.10);border:1px solid rgba(255,101,0,0.22);border-radius:20px;padding:5px 12px;font-size:12px;color:#FF6500;font-weight:600;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                {{ number_format(auth()->user()->solde_heures, 2) }}h
            </div>
            <a href="{{ route('requests.create') }}" style="display:inline-flex;align-items:center;gap:5px;background:#FF6500;color:#000;font-weight:700;font-size:12px;padding:7px 14px;border-radius:8px;text-decoration:none;">
                + Nouvelle demande
            </a>
        </div>
    </header>

    <!-- Flash messages -->
    @if(session('success'))
        <div style="margin:16px 28px 0;background:rgba(255,101,0,0.08);border:1px solid rgba(255,101,0,0.2);border-radius:8px;padding:10px 14px;font-size:13px;color:#FF6500;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="margin:16px 28px 0;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Page slot -->
    <main style="flex:1;padding:28px;">
        {{ $slot }}
    </main>

</div>

</body>
</html>