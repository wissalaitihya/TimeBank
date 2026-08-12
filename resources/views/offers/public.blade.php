<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TimeBank — Offres d'aide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ═══════════════════════════════════════════════════════
           Public Offers Explorer — visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .pub-page {
            --pub-bg: #070706;
            --pub-surface: #0B0A09;
            --pub-elevated: #11100F;
            --pub-input: #151311;
            --pub-text: #F5F2ED;
            --pub-muted: #918B84;
            --pub-faint: #625D58;
            --pub-border: rgba(255,255,255,0.08);
            --pub-border-warm: rgba(255,101,0,0.28);
            --pub-orange: #FF6500;
            --pub-amber: #FFAE25;

            position: relative;
            min-height: 100vh;
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--pub-text);
            background: var(--pub-bg);
            font-family: "Inter", ui-sans-serif, system-ui, sans-serif;
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .pub-page::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            opacity: 0.025;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ── Top bar ─────────────────────────────────────────── */
        .pub-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            background: rgba(7,7,6,0.92);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--pub-border);
        }

        .pub-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            color: var(--pub-text);
        }

        .pub-logo-mark {
            width: 30px;
            height: 30px;
            background: var(--pub-orange);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .pub-logo-word {
            font-size: 15px;
            font-weight: 600;
            font-family: "Playfair Display", serif;
            letter-spacing: -0.02em;
        }

        .pub-logo-word em {
            color: var(--pub-orange);
            font-style: italic;
        }

        .pub-topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pub-topbar-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pub-topbar-link--ghost {
            color: var(--pub-muted);
            border: 1px solid var(--pub-border);
            background: transparent;
        }

        .pub-topbar-link--ghost:hover {
            color: var(--pub-text);
            border-color: rgba(255,255,255,0.15);
        }

        .pub-topbar-link--primary {
            background: var(--pub-orange);
            color: #000;
            font-weight: 700;
            border: none;
        }

        .pub-topbar-link--primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(255,101,0,0.3);
        }

        /* ── Content wrapper ─────────────────────────────────── */
        .pub-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding-top: 54px;
        }

        /* ── Header row ──────────────────────────────────────── */
        .pub-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: pub-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .pub-header-left {
            flex: 1;
            min-width: 0;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .pub-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--pub-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .pub-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--pub-faint);
        }

        /* ── Title ───────────────────────────────────────────── */
        .pub-title {
            margin: 0 0 8px;
            color: var(--pub-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        /* ── Subtitle ────────────────────────────────────────── */
        .pub-subtitle {
            margin: 0;
            color: var(--pub-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Separator ───────────────────────────────────────── */
        .pub-separator {
            width: 100%;
            height: 1px;
            background: var(--pub-border);
            margin-bottom: 32px;
            opacity: 0;
            animation: pub-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Skill filter ────────────────────────────────────── */
        .pub-filters {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
            flex-wrap: wrap;
            opacity: 0;
            animation: pub-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .pub-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--pub-border);
            background: transparent;
            color: var(--pub-muted);
        }

        .pub-filter-btn:hover {
            border-color: rgba(255,255,255,0.15);
            color: var(--pub-text);
        }

        .pub-filter-btn--active {
            background: rgba(255,101,0,0.10);
            border-color: rgba(255,101,0,0.25);
            color: var(--pub-orange);
        }

        .pub-filter-btn--active:hover {
            border-color: rgba(255,101,0,0.4);
        }

        /* ── Offer cards grid ────────────────────────────────── */
        .pub-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 12px;
            opacity: 0;
            animation: pub-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .pub-card {
            display: flex;
            flex-direction: column;
            padding: 22px;
            background: var(--pub-elevated);
            border: 1px solid var(--pub-border);
            border-radius: 8px;
            transition: border-color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .pub-card:hover {
            border-color: rgba(255,101,0,0.25);
            transform: translateY(-2px);
        }

        .pub-card-tags {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .pub-tag {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .pub-tag--skill {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--pub-orange);
        }

        .pub-tag--duration {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--pub-border);
            color: var(--pub-muted);
        }

        .pub-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--pub-text);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .pub-card-desc {
            font-size: 13px;
            color: var(--pub-muted);
            line-height: 1.55;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .pub-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--pub-border);
        }

        .pub-card-user {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pub-card-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255,101,0,0.12);
            border: 1px solid rgba(255,101,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--pub-orange);
            flex-shrink: 0;
        }

        .pub-card-user-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .pub-card-user-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--pub-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pub-card-user-rep {
            font-size: 11px;
            color: var(--pub-faint);
        }

        /* ── Empty state ─────────────────────────────────────── */
        .pub-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 72px 24px 56px;
            opacity: 0;
            animation: pub-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .pub-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(255,101,0,0.08);
            border: 1px solid rgba(255,101,0,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .pub-empty-title {
            margin: 0 0 8px;
            color: var(--pub-text);
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .pub-empty-desc {
            margin: 0;
            color: var(--pub-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Pagination ──────────────────────────────────────── */
        .pub-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-top: 40px;
            opacity: 0;
            animation: pub-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.25s forwards;
        }

        .pub-pagination a,
        .pub-pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pub-pagination a {
            color: var(--pub-muted);
            border: 1px solid var(--pub-border);
            background: transparent;
        }

        .pub-pagination a:hover {
            color: var(--pub-text);
            border-color: rgba(255,255,255,0.15);
            background: var(--pub-elevated);
        }

        .pub-pagination span.pub-page-active {
            background: var(--pub-orange);
            color: #000;
            border: 1px solid var(--pub-orange);
            font-weight: 700;
        }

        .pub-pagination span.pub-page-dots {
            color: var(--pub-faint);
            border: none;
            background: transparent;
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes pub-fade-up {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 900px) {
            .pub-page {
                padding: 28px 20px 40px;
            }

            .pub-topbar {
                padding: 0 16px;
            }

            .pub-header {
                flex-direction: column;
                gap: 16px;
            }

            .pub-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .pub-page {
                padding: 20px 16px 32px;
            }

            .pub-title {
                font-size: 26px;
            }

            .pub-topbar-actions .pub-topbar-link--ghost {
                display: none;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .pub-header,
            .pub-separator,
            .pub-filters,
            .pub-grid,
            .pub-empty,
            .pub-pagination {
                animation: none;
                opacity: 1;
            }

            .pub-card,
            .pub-filter-btn,
            .pub-topbar-link,
            .pub-pagination a {
                transition: none;
            }
        }
    </style>
</head>
<body class="pub-page">

    {{-- Top bar --}}
    <header class="pub-topbar">
        <a href="{{ route('welcome') }}" class="pub-logo">
            <div class="pub-logo-mark">⏱</div>
            <span class="pub-logo-word">Time<em>Bank</em></span>
        </a>
        <div class="pub-topbar-actions">
            <a href="{{ route('welcome') }}" class="pub-topbar-link pub-topbar-link--ghost">Accueil</a>
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="pub-topbar-link pub-topbar-link--primary">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="pub-topbar-link pub-topbar-link--ghost">Se connecter</a>
                    <a href="{{ route('register') }}" class="pub-topbar-link pub-topbar-link--primary">S'inscrire</a>
                @endauth
            @endif
        </div>
    </header>

    <main class="pub-inner">

        {{-- Header --}}
        <div class="pub-header">
            <div class="pub-header-left">
                <div class="pub-eyebrow">OFFRES D'AIDE</div>
                <h1 class="pub-title">Offres disponibles</h1>
                <p class="pub-subtitle">Trouve l'aide dont tu as besoin ou propose tes compétences.</p>
            </div>
        </div>

        <div class="pub-separator"></div>

        {{-- Skill filter --}}
        @if($skills->count())
            <div class="pub-filters">
                <a href="{{ route('offers.public') }}"
                   class="pub-filter-btn {{ !request('skill_id') ? 'pub-filter-btn--active' : '' }}">
                    Toutes
                </a>
                @foreach($skills as $skill)
                    <a href="{{ route('offers.public', ['skill_id' => $skill->id]) }}"
                       class="pub-filter-btn {{ request('skill_id') == $skill->id ? 'pub-filter-btn--active' : '' }}">
                        {{ $skill->nom }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Offers grid --}}
        @forelse($offers as $offer)
            <div class="pub-grid">
                <a href="{{ route('offers.show', $offer) }}" class="pub-card">
                    <div class="pub-card-tags">
                        <span class="pub-tag pub-tag--skill">{{ $offer->skill->nom }}</span>
                        <span class="pub-tag pub-tag--duration">{{ number_format($offer->duree_estimee, 2) }}h</span>
                    </div>
                    <div class="pub-card-title">{{ $offer->titre }}</div>
                    <div class="pub-card-desc">{{ $offer->description }}</div>
                    <div class="pub-card-footer">
                        <div class="pub-card-user">
                            <div class="pub-card-avatar">{{ strtoupper(substr($offer->user->name, 0, 1)) }}</div>
                            <div class="pub-card-user-info">
                                <div class="pub-card-user-name">{{ $offer->user->name }}</div>
                                @if($offer->user->score_reputation)
                                    <div class="pub-card-user-rep">⭐ {{ number_format($offer->user->score_reputation / 20, 1) }}/5</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="pub-empty">
                <div class="pub-empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FF6500" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                </div>
                <h2 class="pub-empty-title">Aucune offre pour le moment</h2>
                <p class="pub-empty-desc">Reviens vite, la communauté partage ses compétences au quotidien.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="pub-pagination">
            {{ $offers->links() }}
        </div>

    </main>

</body>
</html>
