<x-app-layout data-page="dashboard">
    <style>
        /* ═══════════════════════════════════════════════════════
           Dashboard — orange-and-black theme
           ═══════════════════════════════════════════════════════ */

        .db-page {
            --db-bg: #070706;
            --db-surface: #0B0A09;
            --db-elevated: #11100F;
            --db-input: #151311;
            --db-text: #F5F2ED;
            --db-muted: #918B84;
            --db-faint: #625D58;
            --db-border: rgba(255,255,255,0.08);
            --db-border-warm: rgba(255,101,0,0.28);
            --db-orange: #FF6500;
            --db-amber: #FFAE25;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--db-text);
            background: var(--db-bg);
        }

        .db-page::before {
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

        .db-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .db-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--db-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .db-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--db-faint);
        }

        /* ── Header ──────────────────────────────────────── */
        .db-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: db-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .db-header-left {
            flex: 1;
            min-width: 0;
        }

        .db-title {
            margin: 0 0 8px;
            color: var(--db-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .db-title em {
            color: var(--db-orange);
            font-style: italic;
        }

        .db-subtitle {
            margin: 0;
            color: var(--db-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .db-separator {
            width: 100%;
            height: 1px;
            background: var(--db-border);
            margin-bottom: 48px;
            opacity: 0;
            animation: db-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── New offer button ────────────────────────────────── */
        .db-btn-new {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border: 1px solid var(--db-border-warm);
            border-radius: 4px;
            background: transparent;
            color: var(--db-orange);
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease, border-color 200ms ease;
            white-space: nowrap;
        }

        .db-btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255,101,0,0.15);
            border-color: rgba(255,101,0,0.45);
        }

        .db-btn-new:active {
            transform: translateY(0);
        }

        .db-btn-new svg {
            flex-shrink: 0;
        }

        /* ── Card ────────────────────────────────────────────── */
        .db-card {
            background: var(--db-elevated);
            border: 1px solid var(--db-border);
            border-radius: 6px;
            padding: 20px;
            transition: border-color 200ms ease;
        }

        .db-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        .db-card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;
        }

        .db-card-title h2 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: var(--db-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .db-card-title h2 svg {
            flex-shrink: 0;
        }

        .db-card-title a {
            font-size: 11.5px;
            color: var(--db-orange);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 150ms;
        }

        .db-card-title a:hover {
            opacity: 0.8;
        }

        /* ── Balance grid ────────────────────────────────────── */
        .db-grid-balance {
            display: grid;
            grid-template-columns: minmax(0, 1.9fr) minmax(0, 1fr);
            gap: 14px;
            margin-bottom: 16px;
            opacity: 0;
            animation: db-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        .db-balance-value {
            font-family: "Playfair Display", serif;
            font-size: 40px;
            line-height: 1;
            color: var(--db-orange);
        }

        .db-balance-unit {
            font-family: "Playfair Display", serif;
            font-size: 18px;
            color: var(--db-orange);
            opacity: 0.65;
        }

        /* ── Pills ───────────────────────────────────────────── */
        .db-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        .db-pill-orange {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--db-orange);
        }

        .db-pill-amber {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.28);
            color: #fbbf24;
        }

        .db-pill-red {
            background: rgba(239,68,68,0.10);
            border: 1px solid rgba(239,68,68,0.28);
            color: #f87171;
        }

        /* ── Badges ──────────────────────────────────────────── */
        .db-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }

        .db-badge-orange {
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--db-orange);
        }

        .db-badge-amber {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.28);
            color: #fbbf24;
        }

        .db-badge-red {
            background: rgba(239,68,68,0.10);
            border: 1px solid rgba(239,68,68,0.28);
            color: #f87171;
        }

        .db-badge-muted {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--db-border);
            color: var(--db-faint);
        }

        /* ── Chips ───────────────────────────────────────────── */
        .db-chip {
            display: inline-flex;
            padding: 3px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .db-chip-orange {
            background: rgba(255,101,0,0.08);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--db-orange);
        }

        .db-chip-blue {
            background: rgba(59,130,246,0.08);
            border: 1px solid rgba(59,130,246,0.25);
            color: #60a5fa;
        }

        .db-chip-gray {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--db-border);
            color: var(--db-faint);
        }

        /* ── Ghost button ────────────────────────────────────── */
        .db-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            border-radius: 4px;
            border: 1px solid var(--db-border);
            color: var(--db-muted);
            font-size: 11.5px;
            font-weight: 600;
            text-decoration: none;
            background: transparent;
            transition: border-color 200ms, color 200ms, background 200ms, transform 200ms;
        }

        .db-btn-ghost:hover {
            border-color: var(--db-border-warm);
            color: var(--db-orange);
            background: rgba(255,101,0,0.06);
            transform: translateY(-1px);
        }

        /* ── Row ─────────────────────────────────────────────── */
        .db-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--db-border);
        }

        .db-row:last-child {
            border-bottom: 0;
        }

        .db-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255,101,0,0.10);
            border: 1px solid rgba(255,101,0,0.25);
            color: var(--db-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .db-tx-icon {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .db-tx-icon.orange {
            background: rgba(255,101,0,0.08);
            border: 1px solid rgba(255,101,0,0.22);
            color: var(--db-orange);
        }

        .db-tx-icon.red {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.22);
            color: #f87171;
        }

        /* ── Empty state ─────────────────────────────────────── */
        .db-empty {
            border: 1px dashed var(--db-border);
            border-radius: 6px;
            padding: 22px 16px;
            text-align: center;
            color: var(--db-faint);
            font-size: 12px;
        }

        /* ── Ledger warning ──────────────────────────────────── */
        .db-ledger {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: var(--db-elevated);
            border: 1px solid var(--db-border);
            border-radius: 6px;
            padding: 13px 14px;
        }

        /* ── Grids ───────────────────────────────────────────── */
        .db-grid-bottom {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
            gap: 14px;
        }

        .db-grid-ledger {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        @media (max-width: 900px) {
            .db-header { flex-direction: column; gap: 16px; }
            .db-btn-new { align-self: flex-start; }
            .db-grid-balance { grid-template-columns: minmax(0, 1fr); }
            .db-grid-bottom { grid-template-columns: minmax(0, 1fr); }
        }

        @media (max-width: 700px) {
            .db-grid-ledger { grid-template-columns: minmax(0, 1fr); }
        }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 900px) {
            .db-page { padding: 28px 20px 40px; }
        }

        @media (max-width: 600px) {
            .db-page { padding: 20px 16px 32px; }
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes db-fade-up {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .db-header, .db-separator, .db-grid-balance {
                animation: none;
                opacity: 1;
            }
            .db-btn-ghost { transition: none; }
        }
    </style>

    <main class="db-page">
        <div class="db-inner">

            {{-- Header --}}
            <div class="db-header">
                <div class="db-header-left">
                    <div class="db-eyebrow">{{ strtoupper(now()->locale('fr')->translatedFormat('l d F Y')) }}</div>
                    <h1 class="db-title">Bonjour, <em>{{ explode(' ', $user->name)[0] }}</em>.</h1>
                    <p class="db-subtitle">Voici ton tableau de bord TimeBank.</p>
                </div>
                <a href="{{ route('offers.create') }}" class="db-btn-new">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nouvelle offre
                </a>
            </div>

            <div class="db-separator"></div>

            {{-- Balance + Reputation --}}
            <div class="db-grid-balance">

                <section class="db-card" style="padding: 18px 18px 14px;">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
                        <div>
                            <div class="db-eyebrow" style="margin-bottom:9px;">Solde de temps</div>
                            <div style="display:flex;align-items:baseline;gap:7px;">
                                <span class="db-balance-value">{{ number_format($user->solde_heures, 2) }}</span>
                                <span class="db-balance-unit">h</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;margin-top:11px;flex-wrap:wrap;">
                                @if($user->isGele())
                                    <span class="db-pill db-pill-red">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        Compte gelé
                                    </span>
                                @elseif($user->isSoldeWarning())
                                    <span class="db-pill db-pill-amber">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        Solde bas
                                    </span>
                                @else
                                    <span class="db-pill db-pill-orange">
                                        <span style="width:5px;height:5px;border-radius:50%;background:#FF6500;display:inline-block;"></span>
                                        Actif
                                    </span>
                                @endif
                                @php
                                    $lastTx = $recentTransactions->first();
                                @endphp
                                <span style="display:inline-flex;align-items:center;gap:5px;font-size:10.5px;color:var(--db-faint);">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15.5 14"/></svg>
                                    {{ $lastTx ? 'Dernière activité : ' . $lastTx->created_at->format('d/m/Y') : 'Aucune activité récente' }}
                                </span>
                            </div>
                        </div>
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="var(--db-border)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:2px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    </div>
                    <div style="border-top:1px solid var(--db-border);margin-top:14px;padding-top:12px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--db-faint);font-weight:600;">30 derniers jours</span>
                            <span style="font-size:10px;color:var(--db-faint);">Aucune variation</span>
                        </div>
                        <svg viewBox="0 0 340 56" preserveAspectRatio="none" style="width:100%;height:52px;display:block;">
                            <line x1="0" y1="14" x2="340" y2="14" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                            <line x1="0" y1="28" x2="340" y2="28" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                            <line x1="0" y1="42" x2="340" y2="42" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                            <polyline points="0,51 340,51" fill="none" stroke="rgba(255,101,0,0.45)" stroke-width="1.5"/>
                            <circle cx="340" cy="51" r="2.5" fill="#FF6500"/>
                        </svg>
                    </div>
                </section>

                <section class="db-card" style="padding:18px;">
                    <div class="db-eyebrow" style="margin-bottom:9px;">Réputation</div>
                    <div style="display:flex;align-items:baseline;gap:6px;">
                        <span style="font-family:'Playfair Display',serif;font-size:34px;font-weight:700;color:#fff;line-height:1;">{{ $user->score_reputation }}</span>
                        <span style="font-size:12px;color:var(--db-faint);">/100</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:9px;">
                        @php
                            $stars = (int) round($user->score_reputation / 20);
                        @endphp
                        <div style="display:flex;gap:2px;align-items:center;">
                            @for($i = 0; $i < 5; $i++)
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="{{ $i < $stars ? '#FF6500' : 'none' }}" stroke="{{ $i < $stars ? '#FF6500' : 'var(--db-border)' }}" stroke-width="1.6" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <span style="font-size:11px;color:var(--db-muted);">{{ $stats['reviews_recues'] }} avis reçu{{ $stats['reviews_recues'] > 1 ? 's' : '' }}</span>
                    </div>
                    <div style="border-top:1px solid var(--db-border);margin-top:14px;padding-top:12px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <span style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:var(--db-faint);font-weight:600;">Compétences</span>
                            <a href="{{ route('profile.show') }}" style="font-size:10.5px;color:var(--db-faint);text-decoration:none;">Gérer →</a>
                        </div>
                        @if($user->skills->count() > 0)
                            <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                @foreach($user->skills as $skill)
                                    <span class="db-chip {{ $skill->pivot->niveau === 'expert' ? 'db-chip-orange' : ($skill->pivot->niveau === 'intermediaire' ? 'db-chip-blue' : 'db-chip-gray') }}">
                                        {{ $skill->nom }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p style="font-size:11.5px;color:var(--db-faint);margin:0;">Aucune compétence ajoutée.</p>
                        @endif
                    </div>
                </section>

            </div>

            {{-- Ledger warnings --}}
            <div style="margin-top:16px;">
                <div class="db-eyebrow" style="margin-bottom:9px;">Aperçu des états du ledger</div>
                <div class="db-grid-ledger">

                    <div class="db-ledger" style="border-color:{{ $user->isSoldeWarning() ? 'rgba(245,158,11,.45)' : 'rgba(245,158,11,.28)' }};{{ $user->isSoldeWarning() ? 'box-shadow:0 0 24px rgba(245,158,11,.08);' : '' }}">
                        <span style="width:30px;height:30px;border-radius:8px;background:rgba(245,158,11,.10);border:1px solid rgba(245,158,11,.28);color:#fbbf24;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </span>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <span style="font-size:12.5px;font-weight:600;color:#fff;">Solde bas</span>
                                <span class="db-badge {{ $user->isSoldeWarning() ? 'db-badge-amber' : 'db-badge-muted' }}">{{ $user->isSoldeWarning() ? 'Ton état actuel' : 'État possible' }}</span>
                            </div>
                            <p style="font-size:11.5px;color:var(--db-muted);margin:3px 0 0;">Moins de 0,5h disponible. Propose ton aide à la communauté pour recharger ton solde.</p>
                        </div>
                    </div>

                    <div class="db-ledger" style="border-color:{{ $user->isGele() ? 'rgba(239,68,68,.45)' : 'rgba(239,68,68,.28)' }};{{ $user->isGele() ? 'box-shadow:0 0 24px rgba(239,68,68,.08);' : '' }}">
                        <span style="width:30px;height:30px;border-radius:8px;background:rgba(239,68,68,.10);border:1px solid rgba(239,68,68,.28);color:#f87171;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <span style="font-size:12.5px;font-weight:600;color:#fff;">Compte gelé</span>
                                <span class="db-badge {{ $user->isGele() ? 'db-badge-red' : 'db-badge-muted' }}">{{ $user->isGele() ? 'Ton état actuel' : 'État possible' }}</span>
                            </div>
                            <p style="font-size:11.5px;color:var(--db-muted);margin:3px 0 0;">Solde inférieur à -2h. Aide quelqu'un pour débloquer ton compte.</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Sessions à venir --}}
            <section class="db-card" style="margin-top:16px;padding:16px 18px;">
                <div class="db-card-title">
                    <h2>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF6500" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Sessions à venir
                    </h2>
                    <a href="{{ route('matches.index') }}">Toutes les sessions →</a>
                </div>
                @forelse($upcomingSessions as $session)
                    @php
                        $participant = $session->requester_id === $user->id ? $session->helper : $session->requester;
                        $badges = [
                            'pending'   => ['En attente', 'db-badge-amber'],
                            'accepted'  => ['Acceptée',   'db-badge-orange'],
                            'refused'   => ['Refusée',    'db-badge-red'],
                            'completed' => ['Terminée',   'db-badge-muted'],
                            'disputed'  => ['Litige',     'db-badge-red'],
                        ];
                        $badge = $badges[$session->statut] ?? ['En attente', 'db-badge-muted'];
                        $duration = $session->estimated_duration ? number_format($session->estimated_duration, 2) : '—';
                    @endphp
                    <div class="db-row">
                        <span class="db-avatar">{{ strtoupper(substr($participant->name ?? '?', 0, 1)) }}</span>
                        <div style="flex:1;min-width:0;">
                            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                <span style="font-size:13px;font-weight:500;color:#fff;">{{ $session->offer->skill->nom ?? 'Session' }}</span>
                                <span class="db-badge {{ $badge[1] }}">{{ $badge[0] }}</span>
                            </div>
                            <div style="font-size:11px;color:var(--db-muted);margin-top:2px;">
                                {{ $participant->name ?? '—' }} · {{ $session->scheduled_at?->format('d/m H:i') ?? '—' }} · {{ $duration }}h
                            </div>
                        </div>
                        <a href="{{ route('matches.show', $session) }}" class="db-btn-ghost">Voir</a>
                    </div>
                @empty
                    <div class="db-empty" style="margin-top:10px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--db-faint)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div style="font-size:12.5px;color:var(--db-muted);">Aucune session planifiée</div>
                        <div style="font-size:11px;color:var(--db-faint);margin-top:2px;">Quand un match sera accepté, ta session apparaîtra ici.</div>
                    </div>
                @endforelse
            </section>

            {{-- Dernières transactions + Matchs recommandés --}}
            <div class="db-grid-bottom" style="margin-top:16px;">

                <section class="db-card" style="padding:16px 18px;">
                    <div class="db-card-title">
                        <h2>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF6500" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            Dernières transactions
                        </h2>
                        <a href="{{ route('transactions.index') }}">Tout voir →</a>
                    </div>
                    @forelse($recentTransactions as $tx)
                        @php($positive = in_array($tx->type, ['credit', 'bonus']))
                        <div class="db-row">
                            <span class="db-tx-icon {{ $positive ? 'orange' : 'red' }}">
                                @if($positive)
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                                @else
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="7" x2="7" y2="17"/><polyline points="17 17 7 17 7 7"/></svg>
                                @endif
                            </span>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:12.5px;color:var(--db-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tx->description }}</div>
                                <div style="font-size:10.5px;color:var(--db-faint);margin-top:1px;">{{ $tx->created_at->format('d/m/Y') }}</div>
                            </div>
                            <span style="font-size:13px;font-weight:600;color:{{ $positive ? '#FF6500' : '#f87171' }};white-space:nowrap;">
                                {{ $positive ? '+' : '-' }}{{ number_format($tx->heures, 2) }}h
                            </span>
                        </div>
                    @empty
                        <div class="db-empty" style="margin-top:10px;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--db-faint)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <div style="font-size:12.5px;color:var(--db-muted);">Aucune transaction</div>
                            <div style="font-size:11px;color:var(--db-faint);margin-top:2px;">Tes échanges d'heures apparaîtront ici.</div>
                        </div>
                    @endforelse
                </section>

                <section class="db-card" style="padding:16px 18px;">
                    <div class="db-card-title">
                        <h2>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF6500" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Matchs recommandés
                        </h2>
                        <a href="{{ route('matches.index') }}">Tout voir →</a>
                    </div>
                    @forelse($pendingMatches as $match)
                        <div class="db-row">
                            <span class="db-avatar">{{ strtoupper(substr($match->helper->name ?? '?', 0, 1)) }}</span>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:13px;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $match->helper->name }}</div>
                                <div style="font-size:11px;color:var(--db-muted);">{{ $match->offer->skill->nom ?? '—' }}</div>
                            </div>
                            <span class="db-badge db-badge-amber">En attente</span>
                            <a href="{{ route('matches.show', $match) }}" class="db-btn-ghost">Voir</a>
                        </div>
                    @empty
                        <div class="db-empty" style="margin-top:10px;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--db-faint)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <div style="font-size:12.5px;color:var(--db-muted);">Aucun match recommandé</div>
                            <div style="font-size:11px;color:var(--db-faint);margin-top:2px;">Les correspondances proposées apparaîtront ici.</div>
                        </div>
                    @endforelse
                </section>

            </div>

        </div>
    </main>

</x-app-layout>
