<x-guest-layout title="Connexion" theme="dark">
    <div class="tbk-page">

        {{-- Subtle coordinate grid backdrop --}}
        <div class="tbk-gridline" aria-hidden="true"></div>

        {{-- Two-column body --}}
        <div class="tbk-body">

            {{-- Left visual area ~55% --}}
            <aside class="tbk-stage">
                {{-- Time markers at edges --}}
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

            {{-- Right form area ~45% --}}
            <main class="tbk-panel">
                <div class="tbk-panel-inner">
                    <section class="tbk-card" aria-labelledby="tbk-login-title">
                        <h2 id="tbk-login-title" class="tbk-title">Bon retour.</h2>
                        <p class="tbk-sub">Reprends ton &eacute;change l&agrave; o&ugrave; tu l&rsquo;as laiss&eacute;.</p>

                        @if (session('status'))
                            <div class="tbk-session" role="status">
                                <span class="tbk-session-dot" aria-hidden="true"></span>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="tbk-form"
                              x-data="{ submitting: false }" @submit="submitting = true">
                            @csrf

                            <a href="{{ route('auth.github') }}" class="tbk-btn tbk-btn--github">
                                <svg viewBox="0 0 16 16" width="18" height="18" fill="currentColor" aria-hidden="true">
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                </svg>
                                Continuer avec GitHub
                            </a>

                            <div class="tbk-divider" aria-hidden="true"><span>OU PAR EMAIL</span></div>

                            {{-- Email --}}
                            <div class="tbk-field">
                                <label for="email" class="tbk-label">Adresse e-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       class="tbk-input" required autofocus autocomplete="email"
                                       placeholder="vous@exemple.com">
                                @if ($errors->get('email'))
                                    <div class="tbk-errors" role="alert">
                                        <x-input-error :messages="$errors->get('email')"/>
                                    </div>
                                @endif
                            </div>

                            {{-- Password --}}
                            <div class="tbk-field" x-data="{ show: false }">
                                <label for="password" class="tbk-label">Mot de passe</label>
                                <div class="tbk-input-wrap">
                                    <input id="password" :type="show ? 'text' : 'password'" name="password"
                                           class="tbk-input tbk-input--pad" required autocomplete="current-password"
                                           placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
                                    <button type="button" class="tbk-eye" @click="show = !show"
                                            :aria-label="show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
                                            aria-label="Afficher le mot de passe">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" x-show="!show" aria-hidden="true">
                                            <path d="M2 12s3.5-6.5 10-6.5S22 12 22 12s-3.5 6.5-10 6.5S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="2.8"/>
                                        </svg>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" x-show="show" x-cloak aria-hidden="true">
                                            <path d="M3 3l18 18"/>
                                            <path d="M10.6 5.4A9.6 9.6 0 0 1 12 5.5c6.5 0 10 6.5 10 6.5a17.4 17.4 0 0 1-3.1 3.6"/>
                                            <path d="M6.6 6.6A16.4 16.4 0 0 0 2 12s3.5 6.5 10 6.5a9.3 9.3 0 0 0 4.6-1.2"/>
                                            <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/>
                                        </svg>
                                    </button>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="tbk-forgot">Oubli&eacute; ?</a>
                                @endif
                                @if ($errors->get('password'))
                                    <div class="tbk-errors" role="alert">
                                        <x-input-error :messages="$errors->get('password')"/>
                                    </div>
                                @endif
                            </div>

                            <div class="tbk-actions">
                                <label class="tbk-check" for="remember">
                                    <input id="remember" type="checkbox" name="remember">
                                    <span class="tbk-check-mark" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                    Se souvenir de moi
                                </label>

                                <button type="submit" class="tbk-btn tbk-btn--submit" :disabled="submitting">
                                    <span x-show="!submitting">Se connecter</span>
                                    <span x-show="submitting" x-cloak class="tbk-spinner-wrap" role="status" aria-live="polite">
                                        <svg class="tbk-spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity="0.35" stroke-width="2.4"/>
                                            <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                                        </svg>
                                        Connexion&hellip;
                                    </span>
                                    <svg class="tbk-btn-arrow" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M1.5 8h13M10 3.5 14.5 8 10 12.5"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </section>

                    <p class="tbk-switch">
                        Nouveau sur TimeBank&nbsp;?
                        <a href="{{ route('register') }}" class="tbk-link">Cr&eacute;er un compte</a>
                    </p>
                </div>
            </main>
        </div>

        {{-- Bottom ledger --}}
        <footer class="tbk-ledger" aria-hidden="true">
            <div class="tbk-ledger-left">
                <span class="tbk-ledger-word">LEDGER</span>
                <span class="tbk-ledger-sep" aria-hidden="true"></span>
                <span class="tbk-ledger-mono">TBK://LIVE</span>
                <span class="tbk-ledger-dot" aria-hidden="true"></span>
                <span class="tbk-ledger-mono">12 458,75h &eacute;chang&eacute;es</span>
                <span class="tbk-ledger-divider" aria-hidden="true">|</span>
                <span class="tbk-ledger-mono">3 126 d&eacute;veloppeur&middot;euse&middot;s actifs</span>
                <span class="tbk-ledger-divider" aria-hidden="true">|</span>
                <span class="tbk-ledger-mono">24 pays</span>
                <span class="tbk-ledger-divider" aria-hidden="true">|</span>
                <span class="tbk-ledger-mono">&infin; potentiel</span>
            </div>
            <div class="tbk-ledger-right">
                <span class="tbk-ledger-mono">&lt;time well spent/&gt;</span>
            </div>
        </footer>
    </div>
</x-guest-layout>
