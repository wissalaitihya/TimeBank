<x-app-layout data-page="matches">
    <style>
        /* ═══════════════════════════════════════════════════════
           Matches Index — visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .mx-page {
            --mx-bg: #070706;
            --mx-surface: #0B0A09;
            --mx-elevated: #11100F;
            --mx-input: #151311;
            --mx-text: #F5F2ED;
            --mx-muted: #918B84;
            --mx-faint: #625D58;
            --mx-border: rgba(255,255,255,0.08);
            --mx-border-warm: rgba(255,101,0,0.28);
            --mx-orange: #FF6500;
            --mx-amber: #FFAE25;
            --mx-red: #7A160D;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--mx-text);
            background: var(--mx-bg);
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .mx-page::before {
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

        /* ── Content wrapper ─────────────────────────────────── */
        .mx-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        /* ── Header row ──────────────────────────────────────── */
        .mx-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .mx-header-left {
            flex: 1;
            min-width: 0;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .mx-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--mx-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .mx-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--mx-faint);
        }

        /* ── Title ───────────────────────────────────────────── */
        .mx-title {
            margin: 0 0 8px;
            color: var(--mx-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        /* ── Subtitle ────────────────────────────────────────── */
        .mx-subtitle {
            margin: 0;
            color: var(--mx-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Separator ───────────────────────────────────────── */
        .mx-separator {
            width: 100%;
            height: 1px;
            background: var(--mx-border);
            margin-bottom: 32px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Sessions button ─────────────────────────────────── */
        .mx-btn-sessions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: 1px solid var(--mx-border-warm);
            border-radius: 4px;
            background: transparent;
            color: var(--mx-orange);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
            white-space: nowrap;
        }

        .mx-btn-sessions:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255,101,0,0.15);
            border-color: rgba(255,101,0,0.45);
        }

        /* ── Filters ─────────────────────────────────────────── */
        .mx-filters {
            display: flex;
            gap: 6px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .mx-filter {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            font-family: "Inter", sans-serif;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .mx-filter--active {
            background: rgba(255,101,0,0.12);
            border: 1px solid rgba(255,101,0,0.3);
            color: var(--mx-orange);
        }

        .mx-filter--inactive {
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
            color: var(--mx-faint);
        }

        .mx-filter--inactive:hover {
            border-color: rgba(255,255,255,0.12);
            color: var(--mx-muted);
        }

        /* ── Cards grid ──────────────────────────────────────── */
        .mx-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .mx-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
            border-radius: 6px;
            transition: border-color 200ms ease;
            text-decoration: none;
            color: inherit;
        }

        .mx-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        .mx-card-body {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }

        /* ── Avatar ──────────────────────────────────────────── */
        .mx-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,101,0,0.1);
            border: 1px solid rgba(255,101,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--mx-orange);
            flex-shrink: 0;
        }

        .mx-card-info {
            min-width: 0;
        }

        .mx-card-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--mx-text);
            margin-bottom: 2px;
        }

        .mx-card-desc {
            font-size: 12px;
            color: var(--mx-muted);
            margin-bottom: 4px;
        }

        .mx-card-skill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            background: rgba(255,101,0,0.08);
            border: 1px solid rgba(255,101,0,0.18);
            color: var(--mx-orange);
        }

        .mx-card-view {
            flex-shrink: 0;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: var(--mx-muted);
            background: var(--mx-input);
            border: 1px solid var(--mx-border);
            text-decoration: none;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .mx-card-view:hover {
            color: var(--mx-text);
            border-color: rgba(255,255,255,0.15);
        }

        /* ── Empty state ─────────────────────────────────────── */
        .mx-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 64px 24px 48px;
            opacity: 0;
            animation: mx-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .mx-empty-icon {
            margin-bottom: 28px;
            opacity: 0;
            animation: mx-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .mx-empty-title {
            margin: 0 0 8px;
            color: var(--mx-text);
            font-family: "Inter", sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .mx-empty-desc {
            margin: 0 0 28px;
            color: var(--mx-muted);
            font-size: 14px;
            line-height: 1.5;
            max-width: 380px;
        }

        /* ── Primary action button ───────────────────────────── */
        .mx-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--mx-orange), var(--mx-amber));
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .mx-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .mx-btn-primary:active {
            transform: translateY(0);
        }

        .mx-btn-primary svg {
            transition: transform 200ms ease;
        }

        .mx-btn-primary:hover svg {
            transform: translateX(3px);
        }

        /* ── Three-step ledger ───────────────────────────────── */
        .mx-ledger {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid var(--mx-border);
            opacity: 0;
            animation: mx-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.35s forwards;
        }

        .mx-ledger-step {
            text-align: center;
            position: relative;
            padding: 0 24px;
        }

        .mx-ledger-step:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 1px;
            background: var(--mx-border);
        }

        .mx-ledger-num {
            margin: 0 0 8px;
            color: var(--mx-text);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
        }

        .mx-ledger-num span {
            color: var(--mx-orange);
            font-family: "JetBrains Mono", monospace;
            font-weight: 600;
        }

        .mx-ledger-text {
            margin: 0;
            color: var(--mx-muted);
            font-size: 12.5px;
            line-height: 1.6;
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes mx-fade-up {
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
            .mx-page {
                padding: 28px 20px 40px;
            }

            .mx-header {
                flex-direction: column;
                gap: 16px;
            }

            .mx-btn-sessions {
                align-self: flex-start;
            }

            .mx-cards {
                grid-template-columns: 1fr;
            }

            .mx-ledger {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 600px) {
            .mx-page {
                padding: 20px 16px 32px;
            }

            .mx-title {
                font-size: 26px;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .mx-header,
            .mx-separator,
            .mx-filters,
            .mx-cards,
            .mx-empty,
            .mx-empty-icon,
            .mx-ledger {
                animation: none;
                opacity: 1;
            }

            .mx-btn-sessions,
            .mx-btn-primary,
            .mx-card,
            .mx-card-view,
            .mx-filter {
                transition: none;
            }
        }
    </style>

    <main class="mx-page">
        <div class="mx-inner">

            {{-- Header --}}
            <div class="mx-header">
                <div class="mx-header-left">
                    <div class="mx-eyebrow">MES MATCHES</div>
                    <h1 class="mx-title">Mes correspondances</h1>
                    <p class="mx-subtitle">Développeurs qui matchent avec tes requêtes ou tes offres actives.</p>
                </div>
                <a href="{{ route('matches.sessions') }}" class="mx-btn-sessions">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Sessions
                </a>
            </div>

            <div class="mx-separator"></div>

            {{-- Filters --}}
            <div class="mx-filters">
                @foreach([
                    ''          => 'Tous',
                    'pending'   => 'En attente',
                    'accepted'  => 'Acceptés',
                    'completed' => 'Terminés',
                    'refused'   => 'Refusés',
                    'disputed'  => 'Litiges',
                ] as $val => $label)
                    <a href="{{ route('matches.index', $val ? ['statut' => $val] : []) }}"
                       class="mx-filter {{ request('statut') === $val || (!request('statut') && $val === '') ? 'mx-filter--active' : 'mx-filter--inactive' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Cards --}}
            @forelse($matches as $match)
                @php
                    $isHelper    = $match->helper_id === auth()->id();
                    $partner     = $isHelper ? $match->requester : $match->helper;
                    $role        = $isHelper ? 'Tu aides' : 'Tu reçois de l\'aide';
                @endphp

                @if($loop->first)
                    <div class="mx-cards">
                @endif

                    <a href="{{ route('matches.show', $match) }}" class="mx-card">
                        <div class="mx-card-body">
                            <div class="mx-avatar">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>
                            <div class="mx-card-info">
                                <div class="mx-card-name">{{ $partner->name }}</div>
                                <div class="mx-card-desc">
                                    {{ $role }} · {{ $match->offer->skill->nom ?? '—' }}
                                    @if($match->scheduled_at)
                                        · {{ $match->scheduled_at->format('d/m à H:i') }}
                                    @endif
                                </div>
                                <span class="mx-card-skill">
                                    {{ match($match->statut) {
                                        'pending'   => 'En attente',
                                        'accepted'  => 'Accepté',
                                        'completed' => 'Terminé',
                                        'refused'   => 'Refusé',
                                        'disputed'  => 'Litige',
                                        default     => $match->statut,
                                    } }}
                                </span>
                            </div>
                        </div>
                        <span class="mx-card-view">Voir</span>
                    </a>

                @if($loop->last)
                    </div>
                @endif

            @empty
                <div class="mx-empty">
                    {{-- Custom icon: two circles connected (handshake / match) --}}
                    <div class="mx-empty-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            {{-- Glow --}}
                            <circle cx="40" cy="40" r="28" fill="url(#mx-glow)" opacity="0.12"/>
                            {{-- Left circle (person) --}}
                            <circle cx="30" cy="36" r="12" stroke="#FF6500" stroke-width="1.5" fill="none"/>
                            <circle cx="30" cy="32" r="4" stroke="#FF6500" stroke-width="1.3" fill="none"/>
                            <path d="M22 44c0-4.4 3.6-8 8-8" stroke="#FF6500" stroke-width="1.3" stroke-linecap="round" fill="none"/>
                            {{-- Right circle (person) --}}
                            <circle cx="50" cy="36" r="12" stroke="#FFAE25" stroke-width="1.5" fill="none"/>
                            <circle cx="50" cy="32" r="4" stroke="#FFAE25" stroke-width="1.3" fill="none"/>
                            <path d="M42 44c0 4.4 3.6 8 8 8" stroke="#FFAE25" stroke-width="1.3" stroke-linecap="round" fill="none"/>
                            {{-- Connection line --}}
                            <line x1="38" y1="36" x2="42" y2="36" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                            {{-- Sparkle --}}
                            <circle cx="40" cy="24" r="1.5" fill="#FFAE25" opacity="0.8"/>
                            <line x1="40" y1="20" x2="40" y2="22" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="36" y1="24" x2="38" y2="24" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="42" y1="24" x2="44" y2="24" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <defs>
                                <radialGradient id="mx-glow" cx="0.5" cy="0.5" r="0.5">
                                    <stop offset="0%" stop-color="#FF6500" stop-opacity="1"/>
                                    <stop offset="100%" stop-color="#FF6500" stop-opacity="0"/>
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>

                    <h2 class="mx-empty-title">Aucun match pour le moment</h2>
                    <p class="mx-empty-desc">Publie une offre ou propose ton aide sur une demande pour démarrer.</p>

                    <a href="{{ route('offers.public') }}" class="mx-btn-primary">
                        Proposer mon aide
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>
                    </a>
                </div>

                {{-- Three-step ledger --}}
                <div class="mx-ledger">
                    <div class="mx-ledger-step">
                        <p class="mx-ledger-num"><span>1.</span> Trouve un besoin</p>
                        <p class="mx-ledger-text">Explore les demandes ou les offres actives de la communauté.</p>
                    </div>
                    <div class="mx-ledger-step">
                        <p class="mx-ledger-num"><span>2.</span> Propose ton aide</p>
                        <p class="mx-ledger-text">Envoie une proposition et attends la validation de l'autre partie.</p>
                    </div>
                    <div class="mx-ledger-step">
                        <p class="mx-ledger-num"><span>3.</span> Planifie la session</p>
                        <p class="mx-ledger-text">Choisis un créneau, échange et confirme la session ensemble.</p>
                    </div>
                </div>
            @endforelse

            {{ $matches->links() }}

        </div>
    </main>

</x-app-layout>
