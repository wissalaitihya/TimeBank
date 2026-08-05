<x-app-layout data-page="requests">
    <style>
        /* ═══════════════════════════════════════════════════════
           Requests Index — visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .rq-page {
            --rq-bg: #070706;
            --rq-surface: #0B0A09;
            --rq-elevated: #11100F;
            --rq-input: #151311;
            --rq-text: #F5F2ED;
            --rq-muted: #918B84;
            --rq-faint: #625D58;
            --rq-border: rgba(255,255,255,0.08);
            --rq-border-warm: rgba(255,101,0,0.28);
            --rq-orange: #FF6500;
            --rq-amber: #FFAE25;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--rq-text);
            background: var(--rq-bg);
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .rq-page::before {
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
        .rq-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        /* ── Header row ──────────────────────────────────────── */
        .rq-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: rq-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .rq-header-left {
            flex: 1;
            min-width: 0;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .rq-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--rq-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .rq-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--rq-faint);
        }

        /* ── Title ───────────────────────────────────────────── */
        .rq-title {
            margin: 0 0 8px;
            color: var(--rq-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        /* ── Subtitle ────────────────────────────────────────── */
        .rq-subtitle {
            margin: 0;
            color: var(--rq-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Separator ───────────────────────────────────────── */
        .rq-separator {
            width: 100%;
            height: 1px;
            background: var(--rq-border);
            margin-bottom: 48px;
            opacity: 0;
            animation: rq-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── New request button ──────────────────────────────── */
        .rq-btn-new {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: 1px solid var(--rq-border-warm);
            border-radius: 4px;
            background: transparent;
            color: var(--rq-orange);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
            white-space: nowrap;
        }

        .rq-btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255,101,0,0.15);
            border-color: rgba(255,101,0,0.45);
        }

        .rq-btn-new:active {
            transform: translateY(0);
        }

        .rq-btn-new svg {
            flex-shrink: 0;
        }

        /* ── Empty state ─────────────────────────────────────── */
        .rq-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 64px 24px 48px;
            opacity: 0;
            animation: rq-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .rq-empty-icon {
            margin-bottom: 28px;
            opacity: 0;
            animation: rq-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .rq-empty-title {
            margin: 0 0 8px;
            color: var(--rq-text);
            font-family: "Inter", sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .rq-empty-desc {
            margin: 0 0 28px;
            color: var(--rq-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Primary action button ───────────────────────────── */
        .rq-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--rq-orange), var(--rq-amber));
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .rq-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .rq-btn-primary:active {
            transform: translateY(0);
        }

        .rq-btn-primary svg {
            transition: transform 200ms ease;
        }

        .rq-btn-primary:hover svg {
            transform: translateX(3px);
        }

        /* ── Three-step ledger ───────────────────────────────── */
        .rq-ledger {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid var(--rq-border);
            opacity: 0;
            animation: rq-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.35s forwards;
        }

        .rq-ledger-step {
            text-align: center;
            position: relative;
            padding: 0 24px;
        }

        .rq-ledger-step:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 1px;
            background: var(--rq-border);
        }

        .rq-ledger-num {
            margin: 0 0 8px;
            color: var(--rq-text);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
        }

        .rq-ledger-num span {
            color: var(--rq-orange);
            font-family: "JetBrains Mono", monospace;
            font-weight: 600;
        }

        .rq-ledger-text {
            margin: 0;
            color: var(--rq-muted);
            font-size: 12.5px;
            line-height: 1.6;
        }

        /* ── Request cards (when requests exist) ─────────────── */
        .rq-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            animation: rq-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .rq-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            background: var(--rq-elevated);
            border: 1px solid var(--rq-border);
            border-radius: 6px;
            transition: border-color 200ms ease;
        }

        .rq-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        .rq-card-body {
            flex: 1;
            min-width: 0;
        }

        .rq-card-tags {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .rq-tag {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .rq-tag--open {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--rq-orange);
        }

        .rq-tag--matched {
            background: rgba(59,130,246,0.10);
            border: 1px solid rgba(59,130,246,0.25);
            color: #60a5fa;
        }

        .rq-tag--closed {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--rq-border);
            color: var(--rq-faint);
        }

        .rq-tag--high {
            background: rgba(239,68,68,0.10);
            border: 1px solid rgba(239,68,68,0.25);
            color: #f87171;
        }

        .rq-tag--normal {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.25);
            color: #fbbf24;
        }

        .rq-tag--low {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--rq-border);
            color: var(--rq-faint);
        }

        .rq-tag--skill {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--rq-border);
            color: var(--rq-muted);
        }

        .rq-tag--ai {
            background: rgba(255,101,0,0.06);
            border: 1px solid rgba(255,101,0,0.15);
            color: var(--rq-orange);
        }

        .rq-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--rq-text);
            margin-bottom: 4px;
        }

        .rq-card-meta {
            font-size: 12px;
            color: var(--rq-faint);
        }

        .rq-card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            margin-left: 16px;
        }

        .rq-card-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .rq-card-btn--view {
            color: var(--rq-muted);
            background: var(--rq-input);
            border: 1px solid var(--rq-border);
        }

        .rq-card-btn--view:hover {
            color: var(--rq-text);
            border-color: rgba(255,255,255,0.15);
        }

        .rq-card-btn--edit {
            color: var(--rq-muted);
            background: var(--rq-input);
            border: 1px solid var(--rq-border);
        }

        .rq-card-btn--edit:hover {
            color: var(--rq-text);
            border-color: rgba(255,255,255,0.15);
        }

        .rq-card-btn--archive {
            color: #f87171;
            background: var(--rq-input);
            border: 1px solid rgba(239,68,68,0.2);
            cursor: pointer;
        }

        .rq-card-btn--archive:hover {
            border-color: rgba(239,68,68,0.4);
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes rq-fade-up {
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
            .rq-page {
                padding: 28px 20px 40px;
            }

            .rq-header {
                flex-direction: column;
                gap: 16px;
            }

            .rq-btn-new {
                align-self: flex-start;
            }

            .rq-ledger {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .rq-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .rq-card-actions {
                margin-left: 0;
                width: 100%;
            }

            .rq-card-btn {
                flex: 1;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            .rq-page {
                padding: 20px 16px 32px;
            }

            .rq-title {
                font-size: 26px;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .rq-header,
            .rq-separator,
            .rq-empty,
            .rq-empty-icon,
            .rq-ledger,
            .rq-list {
                animation: none;
                opacity: 1;
            }

            .rq-btn-new,
            .rq-btn-primary,
            .rq-card,
            .rq-card-btn {
                transition: none;
            }
        }
    </style>

    <main class="rq-page">
        <div class="rq-inner">

            {{-- Header --}}
            <div class="rq-header">
                <div class="rq-header-left">
                    <div class="rq-eyebrow">MES DEMANDES</div>
                    <h1 class="rq-title">Mes demandes d'aide</h1>
                    <p class="rq-subtitle">Décris ton besoin. La bonne personne saura t'aider.</p>
                </div>
                @if(!auth()->user()->isGele())
                    <a href="{{ route('requests.create') }}" class="rq-btn-new">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Nouvelle demande
                    </a>
                @endif
            </div>

            <div class="rq-separator"></div>

            @forelse($requests as $request)
                <div class="rq-list">
                    <div class="rq-card">
                        <div class="rq-card-body">
                            <div class="rq-card-tags">
                                {{-- Urgency badge --}}
                                <span class="rq-tag rq-tag--{{ $request->urgence }}">
                                    {{ $request->urgence === 'high' ? 'Élevée' : ($request->urgence === 'normal' ? 'Normale' : 'Faible') }}
                                </span>

                                {{-- Status badge --}}
                                <span class="rq-tag rq-tag--{{ $request->statut === 'open' ? 'open' : ($request->statut === 'matched' ? 'matched' : 'closed') }}">
                                    {{ $request->statut === 'open' ? 'Ouverte' : ($request->statut === 'matched' ? 'En cours' : 'Fermée') }}
                                </span>

                                <span class="rq-tag rq-tag--skill">
                                    {{ $request->skill->nom }}
                                </span>

                                {{-- AI status --}}
                                @if($request->ai_status === 'done')
                                    <span class="rq-tag rq-tag--ai">
                                        Améliorée par l'IA
                                    </span>
                                @endif
                            </div>

                            <div class="rq-card-title">{{ $request->titre }}</div>
                            <div class="rq-card-meta">
                                {{ number_format($request->duree_estimee, 2) }}h estimée ·
                                Publiée {{ $request->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="rq-card-actions">
                            <a href="{{ route('requests.show', $request) }}" class="rq-card-btn rq-card-btn--view">Voir</a>
                            @if($request->statut === 'open')
                                <a href="{{ route('requests.edit', $request) }}" class="rq-card-btn rq-card-btn--edit">Modifier</a>
                                <form method="POST" action="{{ route('requests.destroy', $request) }}"
                                      onsubmit="return confirm('Archiver cette demande ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rq-card-btn rq-card-btn--archive">Archiver</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rq-empty">
                    {{-- Custom icon: document with code brackets and clock --}}
                    <div class="rq-empty-icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            {{-- Glow --}}
                            <circle cx="40" cy="38" r="28" fill="url(#rq-glow)" opacity="0.12"/>
                            {{-- Document body --}}
                            <rect x="22" y="10" width="32" height="42" rx="3" stroke="#FF6500" stroke-width="1.5" fill="none"/>
                            {{-- Document fold --}}
                            <path d="M42 10V18H54" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            {{-- Code brackets < > --}}
                            <path d="M32 30L26 38L32 46" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            <path d="M44 30L50 38L44 46" stroke="#FF6500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            {{-- Slash between brackets --}}
                            <line x1="40" y1="28" x2="36" y2="48" stroke="#FFAE25" stroke-width="1.3" stroke-linecap="round" opacity="0.7"/>
                            {{-- Clock circle overlapping bottom-right --}}
                            <circle cx="50" cy="50" r="11" stroke="#FFAE25" stroke-width="1.5" fill="#070706"/>
                            {{-- Clock hands --}}
                            <line x1="50" y1="44" x2="50" y2="50" stroke="#FFAE25" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="50" y1="50" x2="54" y2="52" stroke="#FFAE25" stroke-width="1.5" stroke-linecap="round"/>
                            {{-- Clock tick marks --}}
                            <line x1="50" y1="40.5" x2="50" y2="42" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="50" y1="58" x2="50" y2="59.5" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="39.5" y1="50" x2="41" y2="50" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <line x1="59" y1="50" x2="60.5" y2="50" stroke="#FFAE25" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                            <defs>
                                <radialGradient id="rq-glow" cx="0.5" cy="0.5" r="0.5">
                                    <stop offset="0%" stop-color="#FF6500" stop-opacity="1"/>
                                    <stop offset="100%" stop-color="#FF6500" stop-opacity="0"/>
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>

                    <h2 class="rq-empty-title">Aucune demande publiée</h2>
                    <p class="rq-empty-desc">Explique ce qui te bloque et trouve le bon développeur.</p>

                    @if(!auth()->user()->isGele())
                        <a href="{{ route('requests.create') }}" class="rq-btn-primary">
                            Créer ma première demande
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>
                        </a>
                    @endif
                </div>

                {{-- Three-step ledger --}}
                <div class="rq-ledger">
                    <div class="rq-ledger-step">
                        <p class="rq-ledger-num"><span>1.</span> Décris ton besoin</p>
                        <p class="rq-ledger-text">Présente clairement ton blocage et le résultat attendu.</p>
                    </div>
                    <div class="rq-ledger-step">
                        <p class="rq-ledger-num"><span>2.</span> Reçois des propositions</p>
                        <p class="rq-ledger-text">Les membres disponibles peuvent te proposer leur aide.</p>
                    </div>
                    <div class="rq-ledger-step">
                        <p class="rq-ledger-num"><span>3.</span> Choisis ton match</p>
                        <p class="rq-ledger-text">Planifie la session qui te convient.</p>
                    </div>
                </div>
            @endforelse

            {{ $requests->links() }}

        </div>
    </main>

</x-app-layout>
