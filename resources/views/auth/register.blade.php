<x-guest-layout title="Inscription" theme="dark">
    <div class="tbk-page tbk-page--register">

        <div class="tbk-gridline" aria-hidden="true"></div>

        <div class="tbk-body tbk-body--register">

            {{-- Form on the LEFT --}}
            <main class="tbk-panel tbk-panel--register">
                <div class="tbk-panel-inner">

                    <section
                        class="tbk-card"
                        aria-labelledby="tbk-register-title"
                        x-data="{
                            submitting: false,
                            showPassword: false,
                            showConfirmation: false
                        }"
                    >
                        <h1 id="tbk-register-title" class="tbk-title">
                            Créer un compte.
                        </h1>

                        <p class="tbk-sub">
                            Commence ton échange avec 2 heures offertes.
                        </p>

                        <form
                            method="POST"
                            action="{{ route('register') }}"
                            class="tbk-form"
                            @submit="submitting = true"
                        >
                            @csrf

                            {{-- GitHub --}}
                            <a
                                href="{{ route('auth.github') }}"
                                class="tbk-btn tbk-btn--github"
                            >
                                <svg
                                    viewBox="0 0 16 16"
                                    width="18"
                                    height="18"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                </svg>

                                Continuer avec GitHub
                            </a>

                            <div class="tbk-divider" aria-hidden="true">
                                <span>OU PAR EMAIL</span>
                            </div>

                            {{-- Name --}}
                            <div class="tbk-field">
                                <label for="name" class="tbk-label">
                                    Nom complet
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="tbk-input"
                                    placeholder="Votre nom complet"
                                    required
                                    autofocus
                                    autocomplete="name"
                                >

                                @error('name')
                                    <div class="tbk-errors" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="tbk-field">
                                <label for="email" class="tbk-label">
                                    Adresse e-mail
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="tbk-input"
                                    placeholder="vous@exemple.com"
                                    required
                                    autocomplete="username"
                                >

                                @error('email')
                                    <div class="tbk-errors" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="tbk-field">
                                <label for="password" class="tbk-label">
                                    Mot de passe
                                </label>

                                <div class="tbk-input-wrap">
                                    <input
                                        id="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        class="tbk-input tbk-input--pad"
                                        placeholder="••••••••"
                                        required
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="tbk-eye"
                                        @click="showPassword = !showPassword"
                                        :aria-label="showPassword
                                            ? 'Masquer le mot de passe'
                                            : 'Afficher le mot de passe'"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path d="M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="2.8"/>
                                        </svg>
                                    </button>
                                </div>

                                @error('password')
                                    <div class="tbk-errors" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            {{-- Password confirmation --}}
                            <div class="tbk-field">
                                <label
                                    for="password_confirmation"
                                    class="tbk-label"
                                >
                                    Confirmer le mot de passe
                                </label>

                                <div class="tbk-input-wrap">
                                    <input
                                        id="password_confirmation"
                                        :type="showConfirmation ? 'text' : 'password'"
                                        name="password_confirmation"
                                        class="tbk-input tbk-input--pad"
                                        placeholder="••••••••"
                                        required
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="tbk-eye"
                                        @click="showConfirmation = !showConfirmation"
                                        :aria-label="showConfirmation
                                            ? 'Masquer la confirmation'
                                            : 'Afficher la confirmation'"
                                    >
                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path d="M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="2.8"/>
                                        </svg>
                                    </button>
                                </div>

                                @error('password_confirmation')
                                    <div class="tbk-errors" role="alert">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="tbk-actions tbk-actions--register">
                                <button
                                    type="submit"
                                    class="tbk-btn tbk-btn--submit"
                                    :disabled="submitting"
                                >
                                    <span x-show="!submitting">
                                        Créer mon compte
                                    </span>

                                    <span
                                        x-show="submitting"
                                        x-cloak
                                        class="tbk-spinner-wrap"
                                        role="status"
                                    >
                                        <svg
                                            class="tbk-spinner"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            aria-hidden="true"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                                stroke="currentColor"
                                                stroke-opacity=".35"
                                                stroke-width="2.4"
                                            />

                                            <path
                                                d="M21 12a9 9 0 0 0-9-9"
                                                stroke="currentColor"
                                                stroke-width="2.4"
                                                stroke-linecap="round"
                                            />
                                        </svg>

                                        Création&hellip;
                                    </span>

                                    <svg
                                        class="tbk-btn-arrow"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.9"
                                        aria-hidden="true"
                                    >
                                        <path d="M1.5 8h13M10 3.5 14.5 8 10 12.5"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </section>

                    <p class="tbk-switch">
                        Déjà membre de TimeBank&nbsp;?
                        <a href="{{ route('login') }}" class="tbk-link">
                            Se connecter
                        </a>
                    </p>
                </div>
            </main>

            {{-- Exact login visual, now on the RIGHT --}}
            <aside class="tbk-stage">
                <span class="tbk-time-marker tbk-time-marker--tl" aria-hidden="true">00h</span>
                <span class="tbk-time-marker tbk-time-marker--tr" aria-hidden="true">06h</span>
                <span class="tbk-time-marker tbk-time-marker--bl" aria-hidden="true">12h</span>
                <span class="tbk-time-marker tbk-time-marker--br" aria-hidden="true">18h</span>

                <header class="tbk-masthead">
                    <a href="{{ url('/') }}" class="tbk-logo" aria-label="TimeBank — accueil">
                        <svg class="tbk-logo-clock" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 3v2M12 19v2M3 12h2M19 12h2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M12 7.2V12l3.1 1.9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="1.1" fill="currentColor"/>
                        </svg>
                        <span class="tbk-logo-word">Time<span class="tbk-logo-word--accent">Bank</span></span>
                    </a>
                </header>

                <div class="tbk-visual">
                    <h1 class="tbk-headline">
                        <span>Ton savoir</span>
                        <span>fait <em>avancer</em></span>
                        <span>quelqu&rsquo;un.</span>
                    </h1>

                    <p class="tbk-copy">
                        <span>&Eacute;change tes comp&eacute;tences.</span>
                        <span>Gagne du temps pour tes propres projets.</span>
                    </p>
                </div>
            </aside>
        </div>

        {{-- Keep your existing ledger exactly unchanged --}}
        <footer class="tbk-ledger" aria-hidden="true">
            <div class="tbk-ledger-left">
                <span class="tbk-ledger-word">LEDGER</span>
                <span class="tbk-ledger-sep"></span>
                <span class="tbk-ledger-mono">TBK://LIVE</span>
                <span class="tbk-ledger-dot"></span>
                <span class="tbk-ledger-mono">
                    12 458,75h échangées
                </span>
                <span class="tbk-ledger-divider">|</span>
                <span class="tbk-ledger-mono">
                    3 126 développeur·euse·s actifs
                </span>
                <span class="tbk-ledger-divider">|</span>
                <span class="tbk-ledger-mono">24 pays</span>
                <span class="tbk-ledger-divider">|</span>
                <span class="tbk-ledger-mono">∞ potentiel</span>
            </div>

            <div class="tbk-ledger-right">
                <span class="tbk-ledger-mono">
                    &lt;time well spent/&gt;
                </span>
            </div>
        </footer>
    </div>
</x-guest-layout>