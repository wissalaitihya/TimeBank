<x-app-layout data-page="matches">
    <style>
        /* ═══════════════════════════════════════════════════════
           Matches Sessions — visual system
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

        /* ── Separator ───────────────────────────────────────── */
        .mx-separator {
            width: 100%;
            height: 1px;
            background: var(--mx-border);
            margin-bottom: 40px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Session cards ───────────────────────────────────── */
        .mx-sessions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .mx-session {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 24px;
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
            border-radius: 6px;
            transition: border-color 200ms ease;
        }

        .mx-session:hover {
            border-color: rgba(255,255,255,0.12);
        }

        /* ── Date block ──────────────────────────────────────── */
        .mx-date-block {
            text-align: center;
            min-width: 52px;
            flex-shrink: 0;
        }

        .mx-date-day {
            font-size: 22px;
            font-weight: 700;
            color: var(--mx-orange);
            line-height: 1;
            font-family: "JetBrains Mono", monospace;
        }

        .mx-date-month {
            font-size: 10px;
            color: var(--mx-faint);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .mx-divider {
            width: 1px;
            height: 40px;
            background: var(--mx-border);
            flex-shrink: 0;
        }

        /* ── Session info ────────────────────────────────────── */
        .mx-session-info {
            flex: 1;
            min-width: 0;
        }

        .mx-session-tags {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .mx-tag {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .mx-tag--scheduled {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--mx-orange);
        }

        .mx-tag--role {
            font-size: 11px;
            color: var(--mx-faint);
            padding: 0;
            border: none;
            background: none;
            letter-spacing: 0;
            text-transform: none;
        }

        .mx-session-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--mx-text);
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mx-session-meta {
            font-size: 12px;
            color: var(--mx-faint);
        }

        /* ── Session actions ─────────────────────────────────── */
        .mx-session-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }

        .mx-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            font-family: "Inter", sans-serif;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .mx-btn--join {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--mx-orange);
            font-weight: 600;
        }

        .mx-btn--join:hover {
            border-color: rgba(255,101,0,0.45);
        }

        .mx-btn--detail {
            background: var(--mx-input);
            border: 1px solid var(--mx-border);
            color: var(--mx-muted);
        }

        .mx-btn--detail:hover {
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

            .mx-session {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .mx-divider {
                display: none;
            }

            .mx-session-actions {
                width: 100%;
            }

            .mx-btn {
                flex: 1;
                justify-content: center;
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
            .mx-sessions,
            .mx-empty,
            .mx-empty-icon {
                animation: none;
                opacity: 1;
            }

            .mx-session,
            .mx-btn {
                transition: none;
            }
        }
    </style>

    <main class="mx-page">
        <div class="mx-inner">

            {{-- Header --}}
            <div class="mx-header">
                <div class="mx-header-left">
                    <div class="mx-eyebrow">MES SESSIONS</div>
                    <h1 class="mx-title">Sessions à venir</h1>
                </div>
            </div>

            <div class="mx-separator"></div>

            {{-- Session cards --}}
            @forelse($sessions as $session)
                @php
                    $isHelper = $session->helper_id === auth()->id();
                    $partner  = $isHelper ? $session->requester : $session->helper;
                @endphp

                @if($loop->first)
                    <div class="mx-sessions">
                @endif

                    <div class="mx-session">
                        {{-- Date block --}}
                        <div class="mx-date-block">
                            <div class="mx-date-day">
                                {{ $session->scheduled_at?->format('d') ?? '—' }}
                            </div>
                            <div class="mx-date-month">
                                {{ $session->scheduled_at?->format('M') ?? '' }}
                            </div>
                        </div>

                        <div class="mx-divider"></div>

                        {{-- Session info --}}
                        <div class="mx-session-info">
                            <div class="mx-session-tags">
                                <span class="mx-tag mx-tag--scheduled">Planifiée</span>
                                <span class="mx-tag mx-tag--role">{{ $isHelper ? 'Tu aides' : 'Tu reçois de l\'aide' }}</span>
                            </div>
                            <div class="mx-session-title">
                                {{ $session->offer->titre ?? 'Session ' . ($session->offer->skill->nom ?? '') }}
                            </div>
                            <div class="mx-session-meta">
                                Avec {{ $partner->name }} ·
                                {{ $session->scheduled_at?->format('H:i') ?? '' }} ·
                                {{ $session->platform ?? 'Discord' }} ·
                                {{ number_format($session->estimated_duration, 2) }}h
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mx-session-actions">
                            @if($session->session_link)
                                <a href="{{ $session->session_link }}" target="_blank" class="mx-btn mx-btn--join">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    Ouvrir
                                </a>
                            @endif
                            <a href="{{ route('matches.show', $session) }}" class="mx-btn mx-btn--detail">
                                Détails
                            </a>
                        </div>
                    </div>

                @if($loop->last)
                    </div>
                @endif

            @empty
                <div class="mx-empty">
                    {{-- Custom icon: calendar with clock --}}
                    <div class="mx-empty-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            {{-- Glow --}}
                            <circle cx="40" cy="40" r="28" fill="url(#mx-s-glow)" opacity="0.12"/>
                            {{-- Calendar body --}}
                            <rect x="18" y="16" width="44" height="40" rx="3" stroke="#FF6500" stroke-width="1.5" fill="none"/>
                            {{-- Calendar header bar --}}
                            <line x1="18" y1="28" x2="62" y2="28" stroke="#FF6500" stroke-width="1.5"/>
                            {{-- Calendar hooks --}}
                            <line x1="28" y1="12" x2="28" y2="20" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="52" y1="12" x2="52" y2="20" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round"/>
                            {{-- Clock overlay bottom-right --}}
                            <circle cx="52" cy="48" r="12" stroke="#FFAE25" stroke-width="1.5" fill="#070706"/>
                            {{-- Clock hands --}}
                            <line x1="52" y1="42" x2="52" y2="48" stroke="#FFAE25" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="52" y1="48" x2="56" y2="50" stroke="#FFAE25" stroke-width="1.5" stroke-linecap="round"/>
                            {{-- Clock tick marks --}}
                            <line x1="52" y1="37.5" x2="52" y2="39" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="52" y1="57" x2="52" y2="58.5" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="41.5" y1="48" x2="43" y2="48" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="61" y1="48" x2="62.5" y2="48" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <defs>
                                <radialGradient id="mx-s-glow" cx="0.5" cy="0.5" r="0.5">
                                    <stop offset="0%" stop-color="#FF6500" stop-opacity="1"/>
                                    <stop offset="100%" stop-color="#FF6500" stop-opacity="0"/>
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>

                    <h2 class="mx-empty-title">Aucune session planifiée</h2>
                    <p class="mx-empty-desc">Accepte un match et planifie ta première session.</p>
                </div>
            @endforelse

        </div>
    </main>

</x-app-layout>
