<x-app-layout data-page="offers">
    <style>
        /* ═══════════════════════════════════════════════════════
           Offers Create — visual system
           ═══════════════════════════════════════════════════════ */

        /* ── Palette ─────────────────────────────────────────── */
        .offer-create-page {
            --oc-bg: #070706;
            --oc-surface: #0B0A09;
            --oc-elevated: #11100F;
            --oc-input: #151311;
            --oc-text: #F5F2ED;
            --oc-muted: #918B84;
            --oc-faint: #625D58;
            --oc-border: rgba(255,255,255,0.08);
            --oc-border-warm: rgba(255,101,0,0.28);
            --oc-orange: #FF6500;
            --oc-amber: #FFAE25;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--oc-text);
            background: var(--oc-bg);
        }

        /* ── Grid texture overlay ────────────────────────────── */
        .offer-create-page::before {
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
        .offer-create-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
        }

        /* ── Header ──────────────────────────────────────────── */
        .offer-create-header {
            margin-bottom: 40px;
            opacity: 0;
            animation: oc-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .offer-create-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--oc-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .offer-create-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--oc-faint);
        }

        /* ── Title ───────────────────────────────────────────── */
        .offer-create-title {
            margin: 0 0 8px;
            color: var(--oc-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .offer-create-title em {
            color: var(--oc-orange);
            font-style: italic;
            font-family: "Playfair Display", serif;
        }

        /* ── Subtitle ────────────────────────────────────────── */
        .offer-create-subtitle {
            margin: 0;
            color: var(--oc-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Two-column layout ───────────────────────────────── */
        .offer-create-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 0;
            align-items: start;
            opacity: 0;
            animation: oc-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Form column ─────────────────────────────────────── */
        .offer-create-form {
            padding-right: 48px;
        }

        /* ── Vertical separator ──────────────────────────────── */
        .offer-create-separator {
            width: 1px;
            background: var(--oc-border);
            align-self: stretch;
            margin: 0 40px;
        }

        /* ── Ledger column ───────────────────────────────────── */
        .offer-create-ledger {
            padding-left: 8px;
        }

        .offer-create-ledger-title {
            margin: 0 0 28px;
            color: var(--oc-text);
            font-family: "Inter", sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .offer-create-ledger-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .offer-create-ledger-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--oc-border);
        }

        .offer-create-ledger-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .offer-create-ledger-num {
            flex-shrink: 0;
            color: var(--oc-orange);
            font-family: "JetBrains Mono", monospace;
            font-size: 13px;
            font-weight: 600;
            min-width: 24px;
        }

        .offer-create-ledger-text {
            margin: 0;
            color: var(--oc-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        /* ── Form fields ─────────────────────────────────────── */
        .offer-field {
            margin-bottom: 24px;
        }

        .offer-field:last-child {
            margin-bottom: 0;
        }

        .offer-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .offer-label {
            display: block;
            margin-bottom: 8px;
            color: var(--oc-muted);
            font-size: 13px;
            font-weight: 500;
        }

        .offer-input,
        .offer-textarea,
        .offer-select {
            width: 100%;
            background: var(--oc-input);
            border: 1px solid var(--oc-border);
            border-radius: 4px;
            padding: 11px 16px;
            color: var(--oc-text);
            font-family: "Inter", sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 200ms ease, box-shadow 200ms ease;
        }

        .offer-input:focus,
        .offer-textarea:focus,
        .offer-select:focus {
            border-color: var(--oc-border-warm);
            box-shadow: 0 0 0 3px rgba(255,101,0,0.06);
        }

        .offer-input::placeholder,
        .offer-textarea::placeholder {
            color: var(--oc-faint);
        }

        .offer-textarea {
            resize: vertical;
            min-height: 120px;
            line-height: 1.65;
        }

        .offer-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23625D58' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        .offer-select option {
            background: var(--oc-input);
            color: var(--oc-text);
        }

        .offer-error {
            margin-top: 6px;
            color: #f87171;
            font-size: 12px;
        }

        /* ── Duration segmented control ──────────────────────── */
        .offer-duration-group {
            display: flex;
            gap: 0;
        }

        .offer-duration-item {
            position: relative;
        }

        .offer-duration-item input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .offer-duration-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 18px;
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--oc-muted);
            background: var(--oc-input);
            border: 1px solid var(--oc-border);
            cursor: pointer;
            transition: all 200ms ease;
            min-width: 56px;
            text-align: center;
        }

        .offer-duration-item:first-child .offer-duration-label {
            border-radius: 4px 0 0 4px;
        }

        .offer-duration-item:last-child .offer-duration-label {
            border-radius: 0 4px 4px 0;
        }

        .offer-duration-item:not(:first-child) .offer-duration-label {
            border-left: none;
        }

        .offer-duration-item input[type="radio"]:checked + .offer-duration-label {
            color: var(--oc-orange);
            background: rgba(255,101,0,0.08);
            border-color: var(--oc-border-warm);
            font-weight: 600;
        }

        .offer-duration-item input[type="radio"]:focus-visible + .offer-duration-label {
            outline: 2px solid var(--oc-orange);
            outline-offset: -2px;
        }

        .offer-duration-item input[type="radio"]:not(:checked) + .offer-duration-label:hover {
            color: var(--oc-text);
            border-color: rgba(255,255,255,0.12);
        }

        /* ── Action buttons ──────────────────────────────────── */
        .offer-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            animation: oc-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.2s forwards;
        }

        .offer-btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 36px;
            border: none;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--oc-orange), var(--oc-amber));
            color: #fff;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .offer-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .offer-btn-submit:active {
            transform: translateY(0);
        }

        .offer-btn-submit svg {
            transition: transform 200ms ease;
        }

        .offer-btn-submit:hover svg {
            transform: translateX(3px);
        }

        .offer-btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 36px;
            border: 1px solid var(--oc-border-warm);
            border-radius: 4px;
            background: transparent;
            color: var(--oc-muted);
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: border-color 200ms ease, color 200ms ease;
        }

        .offer-btn-cancel:hover {
            border-color: rgba(255,101,0,0.45);
            color: var(--oc-text);
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes oc-fade-up {
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
            .offer-create-page {
                padding: 28px 20px 40px;
            }

            .offer-create-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .offer-create-form {
                padding-right: 0;
            }

            .offer-create-separator {
                display: none;
            }

            .offer-create-ledger {
                padding-left: 0;
                padding-top: 0;
                border-top: 1px solid var(--oc-border);
                padding-top: 28px;
            }

            .offer-field-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .offer-create-page {
                padding: 20px 16px 32px;
            }

            .offer-create-title {
                font-size: 26px;
            }

            .offer-actions {
                flex-direction: column;
            }

            .offer-btn-submit,
            .offer-btn-cancel {
                width: 100%;
                justify-content: center;
            }

            .offer-duration-group {
                flex-wrap: wrap;
            }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .offer-create-header,
            .offer-create-grid,
            .offer-actions {
                animation: none;
                opacity: 1;
            }

            .offer-input,
            .offer-textarea,
            .offer-select,
            .offer-duration-label,
            .offer-btn-submit,
            .offer-btn-cancel {
                transition: none;
            }
        }
    </style>

    <main class="offer-create-page">
        <div class="offer-create-inner">

            {{-- Header --}}
            <div class="offer-create-header">
                <div class="offer-create-eyebrow">NOUVELLE OFFRE</div>
                <h1 class="offer-create-title">Propose ton <em>aide.</em></h1>
                <p class="offer-create-subtitle">Décris ce que tu peux apporter — le bon développeur te trouvera.</p>
            </div>

            <div class="offer-create-grid">

                {{-- Form column --}}
                <div class="offer-create-form">
                    <form method="POST" action="{{ route('offers.store') }}">
                        @csrf

                        {{-- Titre --}}
                        <div class="offer-field">
                            <label for="offer-titre" class="offer-label">Titre de l'offre</label>
                            <input
                                id="offer-titre"
                                type="text"
                                name="titre"
                                value="{{ old('titre') }}"
                                placeholder="Je t'aide à configurer ton environnement Docker"
                                maxlength="255"
                                class="offer-input"
                            >
                            @error('titre')
                                <p class="offer-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="offer-field">
                            <label for="offer-description" class="offer-label">Description</label>
                            <textarea
                                id="offer-description"
                                name="description"
                                rows="5"
                                placeholder="Décris précisément ce que tu peux faire, ton niveau, et ce dont tu as besoin de la part du demandeur..."
                                class="offer-textarea"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="offer-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Skill + Duration row --}}
                        <div class="offer-field-row">
                            {{-- Compétence --}}
                            <div class="offer-field">
                                <label for="offer-skill" class="offer-label">Compétence principale</label>
                                <select id="offer-skill" name="skill_id" class="offer-select">
                                    <option value="">Choisir...</option>
                                    @foreach($skills->groupBy('categorie') as $cat => $catSkills)
                                        <optgroup label="{{ $cat }}">
                                            @foreach($catSkills as $skill)
                                                <option value="{{ $skill->id }}" {{ old('skill_id') == $skill->id ? 'selected' : '' }}>
                                                    {{ $skill->nom }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('skill_id')
                                    <p class="offer-error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Durée --}}
                            <div class="offer-field">
                                <label class="offer-label">Durée estimée (heures)</label>
                                <div class="offer-duration-group" role="radiogroup" aria-label="Durée estimée">
                                    @foreach([0.75 => '45min', 1.5 => '1h30', 2 => '2h'] as $val => $label)
                                        <div class="offer-duration-item">
                                            <input
                                                type="radio"
                                                name="duree_estimee"
                                                id="duration-{{ $val }}"
                                                value="{{ $val }}"
                                                {{ old('duree_estimee') == $val ? 'checked' : '' }}
                                            >
                                            <label for="duration-{{ $val }}" class="offer-duration-label">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('duree_estimee')
                                    <p class="offer-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="offer-actions" style="margin-top: 32px;">
                            <button type="submit" class="offer-btn-submit">
                                Publier mon offre
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>
                            </button>
                            <a href="{{ route('offers.index') }}" class="offer-btn-cancel">Annuler</a>
                        </div>
                    </form>
                </div>

                {{-- Vertical separator --}}
                <div class="offer-create-separator"></div>

                {{-- Ledger column --}}
                <div class="offer-create-ledger">
                    <h2 class="offer-create-ledger-title">Après publication</h2>
                    <div class="offer-create-ledger-items">
                        <div class="offer-create-ledger-item">
                            <span class="offer-create-ledger-num">01</span>
                            <p class="offer-create-ledger-text">Les développeurs qui cherchent cette compétence sont notifiés</p>
                        </div>
                        <div class="offer-create-ledger-item">
                            <span class="offer-create-ledger-num">02</span>
                            <p class="offer-create-ledger-text">Tu choisis les demandes qui t'intéressent</p>
                        </div>
                        <div class="offer-create-ledger-item">
                            <span class="offer-create-ledger-num">03</span>
                            <p class="offer-create-ledger-text">Confirmation mutuelle après la session</p>
                        </div>
                        <div class="offer-create-ledger-item">
                            <span class="offer-create-ledger-num">04</span>
                            <p class="offer-create-ledger-text">Ton crédit est versé après confirmation</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

</x-app-layout>
