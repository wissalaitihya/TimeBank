<x-app-layout data-page="offers">
    <style>
        /* ═══════════════════════════════════════════════════════
           Offers Index — visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .offers-page {
            --of-bg: #070706;
            --of-surface: #0B0A09;
            --of-elevated: #11100F;
            --of-input: #151311;
            --of-text: #F5F2ED;
            --of-muted: #918B84;
            --of-faint: #625D58;
            --of-border: rgba(255,255,255,0.08);
            --of-border-warm: rgba(255,101,0,0.28);
            --of-orange: #FF6500;
            --of-amber: #FFAE25;
            --of-red: #7A160D;
            --of-violet: #25152E;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--of-text);
            background: var(--of-bg);
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .offers-page::before {
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
        .offers-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        /* ── Header row ──────────────────────────────────────── */
        .offers-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: of-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .offers-header-left {
            flex: 1;
            min-width: 0;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .offers-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--of-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .offers-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--of-faint);
        }

        /* ── Title ───────────────────────────────────────────── */
        .offers-title {
            margin: 0 0 8px;
            color: var(--of-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        /* ── Subtitle ────────────────────────────────────────── */
        .offers-subtitle {
            margin: 0;
            color: var(--of-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Separator ───────────────────────────────────────── */
        .offers-separator {
            width: 100%;
            height: 1px;
            background: var(--of-border);
            margin-bottom: 48px;
            opacity: 0;
            animation: of-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── New offer button ────────────────────────────────── */
        .offers-btn-new {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: 1px solid var(--of-border-warm);
            border-radius: 4px;
            background: transparent;
            color: var(--of-orange);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
            white-space: nowrap;
        }

        .offers-btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255,101,0,0.15);
            border-color: rgba(255,101,0,0.45);
        }

        .offers-btn-new:active {
            transform: translateY(0);
        }

        .offers-btn-new svg {
            flex-shrink: 0;
        }

        /* ── Empty state ─────────────────────────────────────── */
        .offers-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 64px 24px 48px;
            opacity: 0;
            animation: of-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .offers-empty-title {
            margin: 0 0 8px;
            color: var(--of-text);
            font-family: "Inter", sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .offers-empty-desc {
            margin: 0 0 28px;
            color: var(--of-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Primary action button ───────────────────────────── */
        .offers-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--of-orange), var(--of-amber));
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .offers-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .offers-btn-primary:active {
            transform: translateY(0);
        }

        .offers-btn-primary svg {
            transition: transform 200ms ease;
        }

        .offers-btn-primary:hover svg {
            transform: translateX(3px);
        }

        /* ── Three-step ledger ───────────────────────────────── */
        .offers-ledger {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-top: 48px;
            padding-top: 32px;
            border-top: 1px solid var(--of-border);
            opacity: 0;
            animation: of-fade-up 0.6s cubic-bezier(0.16,1,0.3,1) 0.35s forwards;
        }

        .offers-ledger-step {
            text-align: center;
            position: relative;
            padding: 0 24px;
        }

        .offers-ledger-step:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 1px;
            background: var(--of-border);
        }

        .offers-ledger-num {
            margin: 0 0 8px;
            color: var(--of-text);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
        }

        .offers-ledger-num span {
            color: var(--of-orange);
            font-family: "JetBrains Mono", monospace;
            font-weight: 600;
        }

        .offers-ledger-text {
            margin: 0;
            color: var(--of-muted);
            font-size: 12.5px;
            line-height: 1.6;
        }

        /* ── Offer cards (when offers exist) ─────────────────── */
        .offers-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            animation: of-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .offers-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            background: var(--of-elevated);
            border: 1px solid var(--of-border);
            border-radius: 6px;
            transition: border-color 200ms ease;
        }

        .offers-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        .offers-card-body {
            flex: 1;
            min-width: 0;
        }

        .offers-card-tags {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .offers-tag {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .offers-tag--active {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--of-orange);
        }

        .offers-tag--paused {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.25);
            color: #fbbf24;
        }

        .offers-tag--archived {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--of-border);
            color: var(--of-faint);
        }

        .offers-tag--skill {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--of-border);
            color: var(--of-muted);
        }

        .offers-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--of-text);
            margin-bottom: 4px;
        }

        .offers-card-meta {
            font-size: 12px;
            color: var(--of-faint);
        }

        .offers-card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            margin-left: 16px;
        }

        .offers-card-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .offers-card-btn--view {
            color: var(--of-muted);
            background: var(--of-input);
            border: 1px solid var(--of-border);
        }

        .offers-card-btn--view:hover {
            color: var(--of-text);
            border-color: rgba(255,255,255,0.15);
        }

        .offers-card-btn--edit {
            color: var(--of-muted);
            background: var(--of-input);
            border: 1px solid var(--of-border);
        }

        .offers-card-btn--edit:hover {
            color: var(--of-text);
            border-color: rgba(255,255,255,0.15);
        }

        .offers-card-btn--archive {
            color: #f87171;
            background: var(--of-input);
            border: 1px solid rgba(239,68,68,0.2);
            cursor: pointer;
        }

        .offers-card-btn--archive:hover {
            border-color: rgba(239,68,68,0.4);
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes of-fade-up {
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
            .offers-page {
                padding: 28px 20px 40px;
            }

            .offers-header {
                flex-direction: column;
                gap: 16px;
            }

            .offers-btn-new {
                align-self: flex-start;
            }

            .offers-ledger {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .offers-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .offers-card-actions {
                margin-left: 0;
                width: 100%;
            }

            .offers-card-btn {
                flex: 1;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            .offers-page {
                padding: 20px 16px 32px;
            }

            .offers-title {
                font-size: 26px;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .offers-header,
            .offers-separator,
            .offers-empty,
            .offers-ledger,
            .offers-list {
                animation: none;
                opacity: 1;
            }

            .offers-btn-new,
            .offers-btn-primary,
            .offers-card,
            .offers-card-btn {
                transition: none;
            }
        }
    </style>

    <main class="offers-page">
        <div class="offers-inner">

            {{-- Header --}}
            <div class="offers-header">
                <div class="offers-header-left">
                    <div class="offers-eyebrow">MES OFFRES</div>
                    <h1 class="offers-title">Mes offres d'aide</h1>
                    <p class="offers-subtitle">Les compétences que tu partages deviennent du temps utile.</p>
                </div>
                <a href="{{ route('offers.create') }}" class="offers-btn-new">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nouvelle offre
                </a>
            </div>

            <div class="offers-separator"></div>

            @forelse($offers as $offer)
                <div class="offers-list">
                    <div class="offers-card">
                        <div class="offers-card-body">
                            <div class="offers-card-tags">
                                <span class="offers-tag offers-tag--{{ $offer->statut === 'active' ? 'active' : ($offer->statut === 'paused' ? 'paused' : 'archived') }}">
                                    {{ $offer->statut === 'active' ? 'Active' : ($offer->statut === 'paused' ? 'En pause' : 'Archivée') }}
                                </span>
                                <span class="offers-tag offers-tag--skill">
                                    {{ $offer->skill->nom }}
                                </span>
                            </div>
                            <div class="offers-card-title">{{ $offer->titre }}</div>
                            <div class="offers-card-meta">
                                {{ number_format($offer->duree_estimee, 2) }}h estimée ·
                                Publiée {{ $offer->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="offers-card-actions">
                            <a href="{{ route('offers.show', $offer) }}" class="offers-card-btn offers-card-btn--view">Voir</a>
                            <a href="{{ route('offers.edit', $offer) }}" class="offers-card-btn offers-card-btn--edit">Modifier</a>
                            <form method="POST" action="{{ route('offers.destroy', $offer) }}"
                                  onsubmit="return confirm('Archiver cette offre ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="offers-card-btn offers-card-btn--archive">Archiver</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="offers-empty">
                    <h2 class="offers-empty-title">Aucune offre publiée</h2>
                    <p class="offers-empty-desc">Partage tes compétences avec la communauté.</p>
                    <a href="{{ route('offers.create') }}" class="offers-btn-primary">
                        Créer ma première offre
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>
                    </a>
                </div>

                {{-- Three-step ledger --}}
                <div class="offers-ledger">
                    <div class="offers-ledger-step">
                        <p class="offers-ledger-num"><span>1.</span> Décris ton aide</p>
                        <p class="offers-ledger-text">Présente clairement la compétence ou le soutien que tu proposes.</p>
                    </div>
                    <div class="offers-ledger-step">
                        <p class="offers-ledger-num"><span>2.</span> Reçois une demande</p>
                        <p class="offers-ledger-text">Quelqu'un de la communauté te contacte.</p>
                    </div>
                    <div class="offers-ledger-step">
                        <p class="offers-ledger-num"><span>3.</span> Gagne du temps</p>
                        <p class="offers-ledger-text">Ton échange est validé, tu gagnes des heures.</p>
                    </div>
                </div>
            @endforelse

            {{ $offers->links() }}

        </div>


    </main>

</x-app-layout>
