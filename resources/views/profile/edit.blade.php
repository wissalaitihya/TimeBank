<x-app-layout data-page="profile">
    <style>
        .edit-page {
            --ep-bg: #070605;
            --ep-surface: #0B0A09;
            --ep-elevated: #100E0C;
            --ep-text: #F4F0EA;
            --ep-muted: #9A938C;
            --ep-faint: #66615C;
            --ep-border: rgba(255,255,255,0.08);
            --ep-border-strong: rgba(255,255,255,0.14);
            --ep-orange: #FF6500;
            --ep-amber: #FFB33B;
            --ep-glow: rgba(255,101,0,0.10);

            position: relative;
            min-height: calc(100vh - 64px);
            padding: 48px 56px 40px;
            overflow: hidden;
            color: var(--ep-text);
            background: var(--ep-bg);
        }

        .edit-page::before {
            content: "";
            position: absolute;
            top: -180px;
            right: 4%;
            width: 600px;
            height: 400px;
            border: 1px solid rgba(255,101,0,0.12);
            border-radius: 50%;
            transform: rotate(-8deg);
            pointer-events: none;
            opacity: 0.6;
        }

        .edit-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 680px;
        }

        /* ── Eyebrow ──────────────────────────────────────── */
        .edit-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--ep-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            opacity: 0;
            animation: edit-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .edit-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--ep-faint);
        }

        /* ── Title ─────────────────────────────────────────── */
        .edit-title {
            margin: 0 0 40px;
            color: var(--ep-text);
            font-family: "Inter", sans-serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 650;
            letter-spacing: -0.04em;
            line-height: 1.1;
            opacity: 0;
            animation: edit-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Card ──────────────────────────────────────────── */
        .edit-card {
            background: var(--ep-surface);
            border: 1px solid var(--ep-border);
            border-radius: 6px;
            padding: 36px 40px;
            margin-bottom: 24px;
            opacity: 0;
            animation: edit-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.15s forwards;
        }

        .edit-card-title {
            margin: 0 0 28px;
            color: var(--ep-text);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .edit-card-title::after {
            content: "";
            display: block;
            width: 32px;
            height: 1.5px;
            margin-top: 10px;
            background: var(--ep-orange);
            opacity: 0.5;
        }

        /* ── Fields ────────────────────────────────────────── */
        .edit-field {
            margin-bottom: 24px;
        }

        .edit-field:last-child {
            margin-bottom: 0;
        }

        .edit-label {
            display: block;
            margin-bottom: 8px;
            color: var(--ep-muted);
            font-size: 13px;
            font-weight: 500;
        }

        .edit-input,
        .edit-textarea,
        .edit-select {
            width: 100%;
            background: var(--ep-elevated);
            border: 1px solid var(--ep-border-strong);
            border-radius: 4px;
            padding: 11px 16px;
            color: var(--ep-text);
            font-family: "Inter", sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 200ms ease, box-shadow 200ms ease;
        }

        .edit-input:focus,
        .edit-textarea:focus,
        .edit-select:focus {
            border-color: rgba(255,101,0,0.45);
            box-shadow: 0 0 0 3px rgba(255,101,0,0.06);
        }

        .edit-input::placeholder,
        .edit-textarea::placeholder {
            color: var(--ep-faint);
        }

        .edit-textarea {
            resize: vertical;
            min-height: 100px;
            line-height: 1.65;
        }

        .edit-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2366615C' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        .edit-select option {
            background: #100E0C;
            color: var(--ep-text);
        }

        .edit-error {
            margin-top: 6px;
            color: #f87171;
            font-size: 12px;
        }

        /* ── Actions ───────────────────────────────────────── */
        .edit-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            animation: edit-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.25s forwards;
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 0 24px;
            border-radius: 4px;
            font-family: "Inter", sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform 200ms ease, box-shadow 200ms ease;
        }

        .edit-btn:hover {
            transform: translateY(-1px);
        }

        .edit-btn:active {
            transform: translateY(0);
        }

        .edit-btn--save {
            background: var(--ep-orange);
            color: #fff;
        }

        .edit-btn--save:hover {
            box-shadow: 0 4px 20px rgba(255,101,0,0.25);
        }

        .edit-btn--cancel {
            background: transparent;
            border: 1px solid var(--ep-border-strong);
            color: var(--ep-muted);
        }

        .edit-btn--cancel:hover {
            border-color: rgba(255,255,255,0.2);
            color: var(--ep-text);
        }

        /* ── Keyframes ─────────────────────────────────────── */
        @keyframes edit-fade-up {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Responsive ────────────────────────────────────── */
        @media (max-width: 720px) {
            .edit-page {
                padding: 28px 20px 24px;
            }

            .edit-card {
                padding: 24px 20px;
            }

            .edit-actions {
                flex-direction: column;
            }

            .edit-btn {
                width: 100%;
            }
        }

        /* ── Reduced motion ────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .edit-eyebrow,
            .edit-title,
            .edit-card,
            .edit-actions {
                animation: none;
                opacity: 1;
            }

            .edit-input,
            .edit-textarea,
            .edit-select,
            .edit-btn {
                transition: none;
            }
        }
    </style>

    <main class="edit-page">
        <div class="edit-inner">

            <div class="edit-eyebrow">Profil</div>
            <h1 class="edit-title">Modifier mon profil</h1>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')

                <div class="edit-card">
                    <h2 class="edit-card-title">Informations personnelles</h2>

                    <div class="edit-field">
                        <label for="edit-name" class="edit-label">Nom complet</label>
                        <input
                            id="edit-name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="edit-input"
                            autocomplete="name"
                        >
                        @error('name')
                            <p class="edit-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="edit-field">
                        <label for="edit-email" class="edit-label">Adresse e-mail</label>
                        <input
                            id="edit-email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="edit-input"
                            autocomplete="email"
                        >
                        @error('email')
                            <p class="edit-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="edit-field">
                        <label for="edit-bio" class="edit-label">Bio professionnelle</label>
                        <textarea
                            id="edit-bio"
                            name="bio"
                            rows="4"
                            class="edit-textarea"
                            placeholder="Décris ton expertise et la manière dont tu peux aider les autres membres."
                        >{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="edit-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="edit-field">
                        <label for="edit-niveau" class="edit-label">Niveau</label>
                        <select id="edit-niveau" name="niveau" class="edit-select">
                            <option value="">Choisir un niveau</option>
                            <option value="junior" {{ $user->niveau === 'junior' ? 'selected' : '' }}>Junior</option>
                            <option value="intermediaire" {{ $user->niveau === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                            <option value="senior" {{ $user->niveau === 'senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                        @error('niveau')
                            <p class="edit-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="edit-actions">
                    <button type="submit" class="edit-btn edit-btn--save">
                        Sauvegarder
                    </button>
                    <a href="{{ route('profile.show') }}" class="edit-btn edit-btn--cancel">
                        Annuler
                    </a>
                </div>
            </form>

        </div>
    </main>
</x-app-layout>
