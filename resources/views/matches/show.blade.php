<x-app-layout data-page="matches">
    <style>
        /* ═══════════════════════════════════════════════════════
           Matches Show — visual system
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
            --mx-green: #22c55e;

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
            max-width: 960px;
        }

        /* ── Back link ───────────────────────────────────────── */
        .mx-back {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--mx-faint);
            text-decoration: none;
            margin-bottom: 20px;
            transition: color 0.15s ease;
        }

        .mx-back:hover {
            color: var(--mx-text);
        }

        /* ── Hero ────────────────────────────────────────────── */
        .mx-hero {
            margin-bottom: 48px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .mx-hero-eyebrow {
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

        .mx-hero-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--mx-faint);
        }

        .mx-hero-title {
            margin: 0 0 8px;
            color: var(--mx-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .mx-hero-title em {
            font-style: italic;
            color: var(--mx-orange);
        }

        .mx-hero-subtitle {
            margin: 0;
            color: var(--mx-muted);
            font-size: 14px;
            line-height: 1.5;
            max-width: 540px;
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

        /* ── Two-column workspace ────────────────────────────── */
        .mx-workspace {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 24px;
            opacity: 0;
            animation: mx-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        /* ── Match card (main column) ────────────────────────── */
        .mx-match-card {
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
            border-radius: 6px;
            padding: 28px;
        }

        /* ── Status tags ─────────────────────────────────────── */
        .mx-tags {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .mx-tag {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .mx-tag--pending {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.25);
            color: #fbbf24;
        }

        .mx-tag--accepted {
            background: rgba(59,130,246,0.10);
            border: 1px solid rgba(59,130,246,0.25);
            color: #60a5fa;
        }

        .mx-tag--completed {
            background: rgba(34,197,94,0.10);
            border: 1px solid rgba(34,197,94,0.25);
            color: #22c55e;
        }

        .mx-tag--refused {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--mx-border);
            color: var(--mx-faint);
        }

        .mx-tag--disputed {
            background: rgba(239,68,68,0.10);
            border: 1px solid rgba(239,68,68,0.25);
            color: #f87171;
        }

        .mx-tag--skill {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--mx-border);
            color: var(--mx-muted);
        }

        .mx-tag--confirmed {
            background: rgba(34,197,94,0.10);
            border: 1px solid rgba(34,197,94,0.25);
            color: #22c55e;
        }

        .mx-tag--waiting {
            background: rgba(245,158,11,0.10);
            border: 1px solid rgba(245,158,11,0.25);
            color: #fbbf24;
        }

        /* ── Match title ─────────────────────────────────────── */
        .mx-match-title {
            margin: 0 0 12px;
            font-family: "Playfair Display", serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--mx-text);
            letter-spacing: -0.02em;
        }

        .mx-match-meta {
            font-size: 13px;
            color: var(--mx-muted);
            margin-bottom: 0;
            line-height: 1.6;
        }

        .mx-match-meta strong {
            color: var(--mx-text);
            font-weight: 600;
        }

        /* ── Participants ────────────────────────────────────── */
        .mx-participants {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--mx-border);
        }

        .mx-participant {
            background: var(--mx-input);
            border-radius: 6px;
            padding: 14px;
        }

        .mx-participant-label {
            font-size: 10px;
            color: var(--mx-faint);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-family: "JetBrains Mono", monospace;
        }

        .mx-participant-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mx-participant-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,101,0,0.1);
            border: 1px solid rgba(255,101,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--mx-orange);
            flex-shrink: 0;
        }

        .mx-participant-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--mx-text);
        }

        .mx-participant-status {
            font-size: 11px;
        }

        .mx-participant-status--ok {
            color: #22c55e;
        }

        .mx-participant-status--wait {
            color: var(--mx-faint);
        }

        /* ── Action panels ───────────────────────────────────── */
        .mx-panel {
            border-radius: 6px;
            padding: 24px 28px;
            margin-top: 16px;
        }

        .mx-panel--action {
            background: rgba(255,101,0,0.04);
            border: 1px solid rgba(255,101,0,0.15);
        }

        .mx-panel--schedule {
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
        }

        .mx-panel--confirm {
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
        }

        .mx-panel--warn {
            background: rgba(239,68,68,0.04);
            border: 1px solid rgba(239,68,68,0.15);
        }

        .mx-panel--success {
            background: rgba(34,197,94,0.04);
            border: 1px solid rgba(34,197,94,0.15);
        }

        .mx-panel--transaction {
            background: rgba(34,197,94,0.04);
            border: 1px solid rgba(34,197,94,0.15);
        }

        .mx-panel-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--mx-text);
            margin-bottom: 6px;
        }

        .mx-panel-desc {
            font-size: 13px;
            color: var(--mx-muted);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .mx-panel-quote {
            font-size: 13px;
            color: var(--mx-muted);
            font-style: italic;
            margin-bottom: 16px;
        }

        /* ── Buttons ─────────────────────────────────────────── */
        .mx-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 4px;
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .mx-btn:active {
            transform: translateY(0);
        }

        .mx-btn--primary {
            background: linear-gradient(135deg, var(--mx-orange), var(--mx-amber));
            color: #fff;
        }

        .mx-btn--primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .mx-btn--danger {
            background: var(--mx-input);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }

        .mx-btn--danger:hover {
            border-color: rgba(239,68,68,0.4);
        }

        .mx-btn--ghost {
            background: transparent;
            color: var(--mx-muted);
            border: 1px solid var(--mx-border);
        }

        .mx-btn--ghost:hover {
            color: var(--mx-text);
            border-color: rgba(255,255,255,0.15);
        }

        .mx-btn--link {
            background: none;
            border: none;
            font-size: 12px;
            color: var(--mx-faint);
            cursor: pointer;
            padding: 0;
            text-decoration: underline;
        }

        .mx-btn--link:hover {
            color: var(--mx-muted);
        }

        .mx-btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* ── Form elements ───────────────────────────────────── */
        .mx-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .mx-form-full {
            margin-bottom: 12px;
        }

        .mx-label {
            display: block;
            font-size: 12px;
            color: var(--mx-muted);
            margin-bottom: 6px;
        }

        .mx-input {
            width: 100%;
            background: var(--mx-input);
            border: 1px solid var(--mx-border);
            border-radius: 4px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--mx-text);
            font-family: "Inter", sans-serif;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s ease;
        }

        .mx-input:focus {
            border-color: rgba(255,101,0,0.4);
        }

        .mx-input--small {
            width: 130px;
        }

        .mx-select {
            width: 100%;
            background: var(--mx-input);
            border: 1px solid var(--mx-border);
            border-radius: 4px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--mx-text);
            font-family: "Inter", sans-serif;
            outline: none;
            cursor: pointer;
            transition: border-color 0.15s ease;
        }

        .mx-select:focus {
            border-color: rgba(255,101,0,0.4);
        }

        /* ── Sidebar card ────────────────────────────────────── */
        .mx-sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .mx-sidebar-card {
            background: var(--mx-elevated);
            border: 1px solid var(--mx-border);
            border-radius: 6px;
            padding: 24px;
        }

        .mx-sidebar-label {
            font-size: 10px;
            color: var(--mx-faint);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-family: "JetBrains Mono", monospace;
            margin-bottom: 12px;
        }

        .mx-sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .mx-sidebar-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,101,0,0.1);
            border: 1px solid rgba(255,101,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: var(--mx-orange);
            flex-shrink: 0;
        }

        .mx-sidebar-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--mx-text);
        }

        .mx-sidebar-meta {
            font-size: 12px;
            color: var(--mx-muted);
        }

        .mx-sidebar-stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--mx-faint);
            margin-top: 4px;
        }

        .mx-sidebar-stat svg {
            flex-shrink: 0;
        }

        /* ── Star rating ─────────────────────────────────────── */
        .mx-stars {
            display: flex;
            gap: 4px;
        }

        .mx-star {
            font-size: 22px;
            color: #333;
            cursor: pointer;
            transition: color 0.1s ease;
        }

        .mx-star--active {
            color: var(--mx-orange);
        }

        /* ── Tags input ──────────────────────────────────────── */
        .mx-tag-btn {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            border: 1px solid var(--mx-border);
            color: var(--mx-muted);
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .mx-tag-btn--active {
            background: rgba(255,101,0,0.12);
            border-color: rgba(255,101,0,0.3);
            color: var(--mx-orange);
        }

        /* ── Dispute toggle ──────────────────────────────────── */
        .mx-dispute-toggle {
            margin-top: 16px;
        }

        .mx-dispute-form {
            display: none;
            background: var(--mx-elevated);
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 6px;
            padding: 24px;
            margin-top: 12px;
        }

        .mx-dispute-form-title {
            font-size: 13px;
            font-weight: 600;
            color: #f87171;
            margin-bottom: 14px;
        }

        /* ── Transaction ─────────────────────────────────────── */
        .mx-tx-amount {
            font-size: 24px;
            font-weight: 700;
            color: #22c55e;
            margin-bottom: 4px;
        }

        .mx-tx-date {
            font-size: 12px;
            color: var(--mx-faint);
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

            .mx-workspace {
                grid-template-columns: 1fr;
            }

            .mx-participants {
                grid-template-columns: 1fr;
            }

            .mx-form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .mx-page {
                padding: 20px 16px 32px;
            }

            .mx-hero-title {
                font-size: 26px;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .mx-hero,
            .mx-separator,
            .mx-workspace {
                animation: none;
                opacity: 1;
            }

            .mx-btn,
            .mx-input,
            .mx-select,
            .mx-tag-btn {
                transition: none;
            }
        }
    </style>

    <main class="mx-page">
        <div class="mx-inner">

            <a href="{{ route('matches.index') }}" class="mx-back">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15,18 9,12 15,6"/></svg>
                Mes matches
            </a>

            {{-- Hero --}}
            <div class="mx-hero">
                <div class="mx-hero-eyebrow">MATCH #{{ $serviceMatch->id }}</div>
                <h1 class="mx-hero-title">Un développeur <em>correspond.</em></h1>
                <p class="mx-hero-subtitle">
                    @if($isHelper)
                        Tu as proposé ton aide pour la demande « {{ $serviceMatch->request->titre ?? $serviceMatch->offer->titre ?? '—' }} ».
                    @else
                        {{ $serviceMatch->helper->name }} a proposé son aide pour ta requête « {{ $serviceMatch->offer->titre ?? '—' }} ».
                    @endif
                </p>
            </div>

            <div class="mx-separator"></div>

            {{-- Two-column workspace --}}
            <div class="mx-workspace">

                {{-- Main column --}}
                <div>

                    {{-- Match card --}}
                    <div class="mx-match-card">
                        <div class="mx-tags">
                            <span class="mx-tag mx-tag--{{ $serviceMatch->statut }}">
                                {{ match($serviceMatch->statut) {
                                    'pending'   => 'En attente',
                                    'accepted'  => 'Accepté',
                                    'completed' => 'Terminé',
                                    'refused'   => 'Refusé',
                                    'disputed'  => 'En litige',
                                    default     => $serviceMatch->statut,
                                } }}
                            </span>
                            <span class="mx-tag mx-tag--skill">
                                {{ $serviceMatch->offer->skill->nom ?? '—' }}
                            </span>
                            @if($serviceMatch->helper_confirmed_at)
                                <span class="mx-tag mx-tag--confirmed">Confirmé côté aidant</span>
                            @endif
                            @if($serviceMatch->requester_confirmed_at)
                                <span class="mx-tag mx-tag--confirmed">Confirmé côté demandeur</span>
                            @endif
                            @if($serviceMatch->statut === 'accepted' && !$hasConfirmed)
                                <span class="mx-tag mx-tag--waiting">En attente de ta confirmation</span>
                            @endif
                        </div>

                        <h2 class="mx-match-title">
                            {{ $serviceMatch->offer->titre ?? 'Session de ' . ($serviceMatch->offer->skill->nom ?? '') }}
                        </h2>

                        <p class="mx-match-meta">
                            @if($serviceMatch->scheduled_at)
                                Créneau proposé : <strong>{{ $serviceMatch->scheduled_at->format('d/m/Y à H:i') }}</strong> ·
                            @endif
                            {{ number_format($serviceMatch->estimated_duration, 2) }}h estimée ·
                            Coût prévu : <strong>{{ number_format($serviceMatch->estimated_duration, 2) }}h</strong>
                        </p>

                        {{-- Participants --}}
                        <div class="mx-participants">
                            @foreach([
                                ['label' => 'Helper (aide)', 'user' => $serviceMatch->helper, 'confirmed' => $serviceMatch->helper_confirmed_at],
                                ['label' => 'Demandeur', 'user' => $serviceMatch->requester, 'confirmed' => $serviceMatch->requester_confirmed_at],
                            ] as $participant)
                                <div class="mx-participant">
                                    <div class="mx-participant-label">{{ $participant['label'] }}</div>
                                    <div class="mx-participant-row">
                                        <div class="mx-participant-avatar">
                                            {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="mx-participant-name">{{ $participant['user']->name }}</div>
                                            <div class="mx-participant-status {{ $participant['confirmed'] ? 'mx-participant-status--ok' : 'mx-participant-status--wait' }}">
                                                {{ $participant['confirmed'] ? 'Confirmé' : 'En attente' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- Accept / Refuse: only the participant who did not create the proposal --}}
@if(
    $serviceMatch->statut === 'pending' &&
    (int) $serviceMatch->proposed_by !== (int) auth()->id()
)
                        <div class="mx-panel mx-panel--action">
                            <div class="mx-panel-title">Répondre au match</div>
                            @if($serviceMatch->message)
                                <p class="mx-panel-quote">"{{ $serviceMatch->message }}"</p>
                            @endif
                            <div class="mx-btn-group">
                                <form method="POST" action="{{ route('matches.accept', $serviceMatch) }}">
                                    @csrf
                                    <button type="submit" class="mx-btn mx-btn--primary">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
                                        Accepter
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('matches.refuse', $serviceMatch) }}">
                                    @csrf
                                    <button type="submit" class="mx-btn mx-btn--danger">
                                        Refuser
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Schedule session (accepted, not yet scheduled) --}}
                    @if($serviceMatch->statut === 'accepted' && !$serviceMatch->scheduled_at)
                        <div class="mx-panel mx-panel--schedule">
                            <div class="mx-panel-title">Planifier la session</div>
                            <form method="POST" action="{{ route('matches.schedule', $serviceMatch) }}">
                                @csrf
                                <div class="mx-form-row">
                                    <div>
                                        <label class="mx-label">Date et heure</label>
                                        <input type="datetime-local" name="scheduled_at"
                                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                                               class="mx-input" />
                                    </div>
                                    <div>
                                        <label class="mx-label">Plateforme</label>
                                        <select name="platform" class="mx-select">
                                            <option>Discord</option>
                                            <option>Google Meet</option>
                                            <option>Zoom</option>
                                            <option>VS Code Live Share</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mx-form-full">
                                    <label class="mx-label">Lien de session (optionnel)</label>
                                    <input type="text" name="session_link" placeholder="https://discord.gg/..."
                                           class="mx-input" />
                                </div>
                                <button type="submit" class="mx-btn mx-btn--primary">
                                    Confirmer la planification
                                </button>
                            </form>
                        </div>
                    @elseif($serviceMatch->scheduled_at)
                        <div class="mx-panel mx-panel--schedule">
                            <div class="mx-panel-title">Session planifiée</div>
                            <p class="mx-match-meta" style="margin-bottom:0;">
                                {{ $serviceMatch->scheduled_at->format('d/m/Y à H:i') }}
                                · {{ $serviceMatch->platform ?? 'Discord' }}
                            </p>
                            @if($serviceMatch->session_link)
                                <div style="margin-top:12px;">
                                    <a href="{{ $serviceMatch->session_link }}" target="_blank" class="mx-btn mx-btn--primary" style="font-size:12px;padding:8px 16px;">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                        Rejoindre
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Confirm session end --}}
                    @if($serviceMatch->statut === 'accepted' && !$hasConfirmed)
                        <div class="mx-panel mx-panel--confirm">
                            <div class="mx-panel-title">Confirmer la fin de session</div>
                            <p class="mx-panel-desc">
                                Indique la durée réelle — c'est ce montant qui sera débité/crédité.
                            </p>
                            <form method="POST" action="{{ route('matches.confirm', $serviceMatch) }}">
                                @csrf
                                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                                    <div>
                                        <label class="mx-label">Durée réelle (heures)</label>
                                        <input type="number" name="declared_duration" step="0.25" min="0.25" max="8"
                                               value="{{ number_format($serviceMatch->estimated_duration, 2) }}"
                                               class="mx-input mx-input--small" />
                                    </div>
                                    <div style="margin-top:18px;">
                                        <button type="submit" class="mx-btn mx-btn--primary">
                                            Confirmer la session
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif($hasConfirmed && $serviceMatch->statut === 'accepted')
                        <div class="mx-panel mx-panel--success">
                            <p style="font-size:13px;color:#22c55e;margin:0;">Tu as confirmé. En attente de l'autre partie...</p>
                        </div>
                    @endif

                    {{-- Open dispute --}}
                    @if($serviceMatch->statut === 'accepted' && !$serviceMatch->dispute)
                        <div class="mx-dispute-toggle">
                            <button onclick="document.getElementById('mxDisputeForm').style.display='block';this.style.display='none'"
                                    class="mx-btn--link">
                                Ouvrir un litige
                            </button>
                            <div id="mxDisputeForm" class="mx-dispute-form">
                                <div class="mx-dispute-form-title">Ouvrir un litige</div>
                                <form method="POST" action="{{ route('disputes.store', $serviceMatch) }}">
                                    @csrf
                                    <div class="mx-form-full">
                                        <input type="text" name="reason" placeholder="Raison du litige"
                                               class="mx-input" />
                                    </div>
                                    <div class="mx-form-full">
                                        <textarea name="description" rows="3" placeholder="Décris le problème..."
                                                  class="mx-input" style="resize:none;"></textarea>
                                    </div>
                                    <button type="submit" class="mx-btn mx-btn--danger">
                                        Confirmer le litige
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    {{-- Transaction result --}}
                    @if($serviceMatch->transaction)
                        <div class="mx-panel mx-panel--transaction">
                            <div class="mx-panel-title" style="color:#22c55e;">Transaction exécutée</div>
                            <div class="mx-tx-amount">
                                {{ number_format($serviceMatch->actual_duration, 2) }}h
                            </div>
                            <div class="mx-tx-date">
                                {{ $serviceMatch->transaction->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    @endif

                    {{-- Reviews section --}}
                    @if($serviceMatch->statut === 'completed')
                        @php
                            $myReview = $serviceMatch->reviews->firstWhere('reviewer_id', auth()->id());
                        @endphp

                        @if(!$myReview)
                            <div class="mx-panel mx-panel--schedule">
                                <div class="mx-panel-title">Laisser un avis</div>
                                <form method="POST" action="{{ route('reviews.store') }}">
                                    @csrf
                                    <input type="hidden" name="service_match_id" value="{{ $serviceMatch->id }}" />

                                    <div style="margin-bottom:16px;">
                                        <label class="mx-label">Note</label>
                                        <div class="mx-stars" id="mxStars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="mx-star" data-value="{{ $i }}" onclick="mxSetStar({{ $i }})">★</span>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="note" id="mxStarInput" value="0" />
                                    </div>

                                    <div class="mx-form-full">
                                        <label class="mx-label">Commentaire (optionnel)</label>
                                        <textarea name="commentaire" rows="3" class="mx-input" style="resize:none;"></textarea>
                                    </div>

                                    <div style="margin-bottom:16px;">
                                        <label class="mx-label">Tags</label>
                                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                            @foreach(['pedagogue','ponctuel','patient','expert','clair','disponible'] as $tag)
                                                <label style="cursor:pointer;">
                                                    <input type="checkbox" name="tags[]" value="{{ $tag }}" style="display:none;"
                                                           onchange="this.parentElement.querySelector('.mx-tag-btn').classList.toggle('mx-tag-btn--active', this.checked)" />
                                                    <span class="mx-tag-btn">{{ ucfirst($tag) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button type="submit" class="mx-btn mx-btn--primary">
                                        Publier mon avis
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mx-panel mx-panel--success">
                                <div style="font-size:12px;color:#22c55e;margin-bottom:6px;">Avis publié</div>
                                <div class="mx-stars" style="pointer-events:none;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="mx-star {{ $i <= $myReview->note ? 'mx-star--active' : '' }}">★</span>
                                    @endfor
                                </div>
                                @if($myReview->commentaire)
                                    <p style="font-size:13px;color:var(--mx-muted);margin:8px 0 0;">"{{ $myReview->commentaire }}"</p>
                                @endif
                            </div>
                        @endif
                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="mx-sidebar">
                    <div class="mx-sidebar-card">
                        <div class="mx-sidebar-label">Aidant</div>
                        <div class="mx-sidebar-user">
                            <div class="mx-sidebar-avatar">
                                {{ strtoupper(substr($serviceMatch->helper->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="mx-sidebar-name">{{ $serviceMatch->helper->name }}</div>
                                <div class="mx-sidebar-meta">
                                    {{ $serviceMatch->offer->skill->nom ?? '—' }}
                                </div>
                            </div>
                        </div>
                        <div class="mx-sidebar-stat">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                            Répond en moyenne en 22 min
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script>
        function mxSetStar(value) {
            document.getElementById('mxStarInput').value = value;
            document.querySelectorAll('#mxStars .mx-star').forEach(function(star, idx) {
                star.classList.toggle('mx-star--active', idx < value);
            });
        }
    </script>

</x-app-layout>
