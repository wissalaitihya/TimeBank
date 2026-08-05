<x-app-layout data-page="profile">
    <style>
        /* ═══════════════════════════════════════════════════════
           Profile page — complete visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .profile-page {
            --pp-bg: #050403;
            --pp-surface: #0C0907;
            --pp-elevated: #141110;
            --pp-text: #F2EEE8;
            --pp-muted: #97908A;
            --pp-faint: #625D58;
            --pp-border: rgba(255,255,255,0.07);
            --pp-border-strong: rgba(255,255,255,0.12);
            --pp-orange: #FF6500;

            min-height: 100vh;
            padding: 76px 0 60px;
            color: var(--pp-text);
            background: var(--pp-bg);
            position: relative;
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .profile-page::before {
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

        /* ── Content column ──────────────────────────────────── */
        .profile-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .profile-eyebrow {
            color: var(--pp-orange);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 20px;
            opacity: 0;
            animation: pf-up 0.4s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        /* ── Identity card ───────────────────────────────────── */
        .profile-header {
            background: var(--pp-surface);
            border-radius: 2px;
            padding: 32px 36px 30px;
            margin-top: 16px;
            margin-bottom: 54px;
            opacity: 0;
            animation: pf-up 0.45s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        .profile-identity {
            display: flex;
            align-items: flex-start;
            gap: 32px;
        }

        .profile-avatar {
            position: relative;
            width: 108px;
            height: 108px;
            flex-shrink: 0;
        }

        .profile-avatar-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06);
        }

        .profile-avatar-ring:nth-child(2) {
            inset: 5px;
            border-color: rgba(255,255,255,0.04);
        }

        .profile-avatar-ring:nth-child(3) {
            inset: 10px;
            border-color: var(--pp-orange);
            opacity: 0.6;
        }

        .profile-avatar-inner {
            position: absolute;
            inset: 14px;
            border-radius: 50%;
            background: var(--pp-elevated);
            display: grid;
            place-items: center;
            font-family: "Playfair Display", serif;
            font-size: 40px;
            font-weight: 700;
            color: var(--pp-text);
            letter-spacing: -0.02em;
        }

        .profile-avatar-glow {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,101,0,0.05), transparent 70%);
            pointer-events: none;
            animation: pf-glow 4s ease-in-out infinite;
        }

        .profile-identity-text {
            flex: 1;
            min-width: 0;
            padding-top: 4px;
        }

        .profile-name {
            margin: 0;
            font-family: "Inter", sans-serif;
            font-size: clamp(40px, 4vw, 52px);
            font-weight: 600;
            line-height: 1;
            letter-spacing: -0.04em;
            color: var(--pp-text);
        }

        .profile-name em {
            font-family: "Playfair Display", serif;
            font-style: italic;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .profile-role {
            margin-top: 14px;
            color: var(--pp-muted);
            font-size: 15px;
            font-weight: 400;
        }

        .profile-meta {
            margin-top: 8px;
            color: var(--pp-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11.5px;
            letter-spacing: 0.03em;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
        }

        .profile-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 34px;
            padding: 0 18px;
            border-radius: 3px;
            font-family: "Inter", sans-serif;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 200ms ease, transform 180ms ease, background 200ms ease;
        }

        .profile-btn:hover {
            transform: translateY(-1px);
        }

        .profile-btn:active {
            transform: translateY(0);
        }

        .profile-btn--primary {
            border: 1px solid rgba(255,101,0,0.5);
            background: transparent;
            color: var(--pp-text);
        }

        .profile-btn--primary:hover {
            border-color: rgba(255,101,0,0.8);
            background: rgba(255,101,0,0.04);
        }

        .profile-btn--ghost {
            border: 1px solid var(--pp-border-strong);
            background: transparent;
            color: var(--pp-muted);
        }

        .profile-btn--ghost:hover {
            border-color: rgba(255,255,255,0.2);
            color: var(--pp-text);
        }

        /* ── Metrics ledger ───────────────────────────────────── */
        .profile-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid var(--pp-border);
            border-bottom: 1px solid var(--pp-border);
            margin-bottom: 0;
            opacity: 0;
            animation: pf-up 0.4s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .profile-metric {
            padding: 34px 0 30px;
        }

        .profile-metric + .profile-metric {
            border-left: 1px solid var(--pp-border);
            padding-left: 36px;
        }

        .profile-metric-value {
            font-family: "Inter", sans-serif;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: -0.02em;
            line-height: 1;
            color: var(--pp-text);
        }

        .profile-metric-label {
            margin-top: 10px;
            font-family: "JetBrains Mono", monospace;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--pp-faint);
        }

        /* ── Section (stack, bio) ─────────────────────────────── */
        .profile-section {
            padding: 42px 0;
            border-bottom: 1px solid var(--pp-border);
        }

        .profile-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .profile-section-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: var(--pp-text);
            letter-spacing: -0.01em;
        }

        .profile-link {
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--pp-faint);
            text-decoration: none;
            transition: color 200ms ease;
        }

        .profile-link:hover {
            color: var(--pp-orange);
        }

        /* ── Skills ───────────────────────────────────────────── */
        .profile-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .profile-skill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 30px;
            padding: 0 14px;
            border: 1px solid var(--pp-border-strong);
            border-radius: 3px;
            background: transparent;
            color: var(--pp-muted);
            font-size: 13px;
            font-weight: 400;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .profile-skill:hover {
            border-color: rgba(255,101,0,0.3);
            color: var(--pp-text);
        }

        .profile-skill-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--pp-orange);
            flex-shrink: 0;
        }

        .profile-empty {
            color: var(--pp-faint);
            font-size: 14px;
        }

        .profile-empty-action {
            color: var(--pp-orange);
            text-decoration: none;
            transition: opacity 180ms ease;
        }

        .profile-empty-action:hover {
            opacity: 0.7;
        }

        /* ── Bio grid ─────────────────────────────────────────── */
        .profile-bio-grid {
            display: grid;
            grid-template-columns: 1fr 1px auto;
            gap: 0 40px;
            align-items: start;
        }

        .profile-bio-divider {
            width: 1px;
            background: var(--pp-border);
            align-self: stretch;
            margin: 0 0;
        }

        .profile-bio-heading {
            margin: 0 0 14px;
            font-size: 16px;
            font-weight: 600;
            color: var(--pp-text);
            letter-spacing: -0.01em;
        }

        .profile-bio {
            margin: 0;
            color: var(--pp-muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .profile-availability-label {
            font-family: "JetBrains Mono", monospace;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--pp-faint);
            margin-bottom: 14px;
        }

        .profile-availability {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--pp-muted);
            font-size: 13px;
            white-space: nowrap;
        }

        .profile-availability-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--pp-orange);
            flex-shrink: 0;
        }

        /* ── Footer ───────────────────────────────────────────── */
        .profile-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 0 0;
            border-top: 1px solid var(--pp-border);
            font-size: 11px;
            color: var(--pp-faint);
            opacity: 0;
            animation: pf-up 0.4s cubic-bezier(0.16,1,0.3,1) 0.45s forwards;
        }

        .profile-footer-copy {
            font-family: "JetBrains Mono", monospace;
            font-size: 10.5px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ── Keyframes ────────────────────────────────────────── */
        @keyframes pf-up {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes pf-glow {
            0%, 100% { opacity: 0.5; }
            50%      { opacity: 1; }
        }

        /* ── Responsive: tablet ───────────────────────────────── */
        @media (max-width: 1080px) {
            .profile-inner {
                max-width: 680px;
            }
        }

        /* ── Responsive: mobile ───────────────────────────────── */
        @media (max-width: 720px) {
            .profile-page {
                padding: 40px 0 36px;
            }

            .profile-inner {
                padding: 0 20px;
            }

            .profile-header {
                padding: 24px 20px;
            }

            .profile-identity {
                flex-direction: column;
                gap: 20px;
            }

            .profile-avatar {
                width: 88px;
                height: 88px;
            }

            .profile-avatar-inner {
                font-size: 32px;
            }

            .profile-name {
                font-size: 34px;
            }

            .profile-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .profile-btn {
                justify-content: center;
            }

            .profile-metrics {
                grid-template-columns: 1fr;
            }

            .profile-metric + .profile-metric {
                border-left: 0;
                padding-left: 0;
                border-top: 1px solid var(--pp-border);
                padding-top: 24px;
                margin-top: 0;
            }

            .profile-bio-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .profile-bio-divider {
                width: 100%;
                height: 1px;
                margin: 0;
            }

            .profile-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }

        /* ── Reduced motion ───────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .profile-eyebrow,
            .profile-header,
            .profile-metrics,
            .profile-section,
            .profile-footer {
                animation: none;
                opacity: 1;
            }

            .profile-avatar-glow {
                animation: none;
            }

            .profile-btn,
            .profile-skill,
            .profile-link,
            .profile-empty-action {
                transition: none;
            }
        }
    </style>

    @php
        $nameParts = preg_split('/\s+/', trim($user->name), 2);
        $firstName = mb_convert_case($nameParts[0] ?? $user->name, MB_CASE_TITLE, 'UTF-8');
        $lastName  = isset($nameParts[1]) ? mb_convert_case($nameParts[1], MB_CASE_TITLE, 'UTF-8') : '';
        $initial   = mb_strtoupper(mb_substr($user->name, 0, 1));

        $levelLabels = [
            'junior'        => 'Développeuse backend junior',
            'intermediaire' => 'Développeuse backend intermédiaire',
            'senior'        => 'Développeuse backend senior',
        ];
        $role = $levelLabels[$user->niveau] ?? 'Développeuse backend';
        $hasAvailability = filled($user->disponibilites);
    @endphp

    <main class="profile-page">
        <div class="profile-inner">

            <div class="profile-eyebrow">Profil</div>

            <div class="profile-header">
                <div class="profile-identity">
                    <div class="profile-avatar" aria-hidden="true">
                        <div class="profile-avatar-ring"></div>
                        <div class="profile-avatar-ring"></div>
                        <div class="profile-avatar-ring"></div>
                        <div class="profile-avatar-inner">{{ $initial }}</div>
                        <div class="profile-avatar-glow"></div>
                    </div>

                    <div class="profile-identity-text">
                        <h1 class="profile-name">
                            {{ $firstName }}
                            @if($lastName)
                                <em>{{ $lastName }}</em>
                            @endif
                        </h1>
                        <div class="profile-role">{{ $role }}</div>
                        <div class="profile-meta">
                            Membre depuis {{ $user->created_at->translatedFormat('F Y') }}
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="profile-btn profile-btn--primary">
                        Modifier le profil
                    </a>
                    @if($user->username)
                        <a href="{{ url('/users/'.$user->username) }}" class="profile-btn profile-btn--ghost" target="_blank" rel="noopener noreferrer">
                            Voir le profil public
                        </a>
                    @endif
                </div>
            </div>

            <section class="profile-metrics" aria-label="Statistiques">
                <div class="profile-metric">
                    <div class="profile-metric-value">{{ number_format($stats['heures_donnees'], 2) }}h</div>
                    <div class="profile-metric-label">Heures données</div>
                </div>
                <div class="profile-metric">
                    <div class="profile-metric-value">{{ number_format($stats['heures_recues'], 2) }}h</div>
                    <div class="profile-metric-label">Heures reçues</div>
                </div>
                <div class="profile-metric">
                    <div class="profile-metric-value">{{ number_format($stats['reputation'] ?? 0, 1) }} / 5</div>
                    <div class="profile-metric-label">Réputation</div>
                </div>
            </section>

            <section class="profile-section">
                <div class="profile-section-head">
                    <h2 class="profile-section-title">Stack technique</h2>
                    <a href="{{ route('profile.skills') }}" class="profile-link">Gérer →</a>
                </div>
                @if($user->skills->isNotEmpty())
                    <div class="profile-skills">
                        @foreach($user->skills as $skill)
                            <span class="profile-skill">
                                <span class="profile-skill-dot"></span>
                                {{ $skill->nom }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="profile-empty">
                        Aucune compétence renseignée.
                        <a href="{{ route('profile.skills') }}" class="profile-empty-action">Ajouter mes compétences →</a>
                    </div>
                @endif
            </section>

            <section class="profile-section">
                <div class="profile-bio-grid">
                    <div>
                        <h2 class="profile-bio-heading">Bio professionnelle</h2>
                        @if($user->bio)
                            <p class="profile-bio">{{ $user->bio }}</p>
                        @else
                            <p class="profile-bio">
                                Aucune biographie renseignée pour le moment.
                                Présente ton expertise et la manière dont tu peux
                                aider les autres membres de TimeBank.
                            </p>
                        @endif
                    </div>
                    <div class="profile-bio-divider"></div>
                    <div>
                        <div class="profile-availability-label">Disponibilité</div>
                        <div class="profile-availability">
                            <span class="profile-availability-dot"></span>
                            <span>{{ $hasAvailability ? 'Disponible cette semaine' : 'Disponibilités non renseignées' }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="profile-footer">
                <span class="profile-footer-copy">© {{ now()->year }} TimeBank</span>
                <span>Le temps partagé devient du savoir.</span>
            </footer>

        </div>
    </main>
</x-app-layout>
