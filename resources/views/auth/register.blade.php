<x-guest-layout title="Créer un compte">
    <div class="auth-shell">
        <!-- Promotional panel -->
        <aside class="auth-promo">
            <a href="{{ url('/') }}" class="auth-brand" aria-label="TimeBank — accueil">
                <span class="auth-brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9.5" />
                        <path d="M12 6.5V12l3.5 2" />
                    </svg>
                </span>
                <span class="auth-brand-name">TimeBank</span>
            </a>

            <div class="auth-promo-body">
                <p class="auth-promo-label">Ton crédit de bienvenue</p>

                <div class="auth-balance">
                    <div class="auth-balance-amount">+2.00h</div>
                    <div class="auth-balance-caption">crédit offert dès ton inscription</div>
                </div>

                <ul class="auth-benefits">
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Échange des compétences, pas de l'argent</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Construis un réseau de confiance</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Ton temps vaut de l'or</span>
                    </li>
                </ul>
            </div>

            <p class="auth-promo-foot">© {{ date('Y') }} TimeBank. Tous droits réservés.</p>
        </aside>

        <!-- Registration form -->
        <main class="auth-main">
            <div class="auth-form-wrap">
                <a href="{{ url('/') }}" class="auth-brand auth-mobile-brand" aria-label="TimeBank — accueil">
                    <span class="auth-brand-mark">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9.5" />
                            <path d="M12 6.5V12l3.5 2" />
                        </svg>
                    </span>
                    <span class="auth-brand-name">TimeBank</span>
                </a>

                <h1 class="auth-title">Rejoindre TimeBank</h1>
                <p class="auth-subtitle">+2h de bienvenue, sans carte bancaire.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <a href="{{ route('auth.github') }}" class="auth-btn auth-btn-github" aria-label="Continuer avec GitHub">
                        <svg viewBox="0 0 16 16" width="20" height="20" fill="currentColor" aria-hidden="true">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                        </svg>
                        Continuer avec GitHub
                    </a>

                    <div class="auth-divider">ou par email</div>

                    <!-- Name -->
                    <div class="auth-field-group">
                        <label for="name" class="auth-label">Nom</label>
                        <input id="name" name="name" type="text" class="auth-field"
                               value="{{ old('name') }}" required autofocus autocomplete="name"
                               placeholder="Jean Dupont">
                        <x-input-error :messages="$errors->get('name')" class="auth-error-inline" />
                    </div>

                    <!-- Username -->
                    <div class="auth-field-group">
                        <label for="username" class="auth-label">Nom d'utilisateur</label>
                        <div class="auth-affix">
                            <span class="auth-prefix" aria-hidden="true">timebank.dev/</span>
                            <input id="username" name="username" type="text" class="auth-field"
                                   value="{{ old('username') }}" required autocomplete="username"
                                   minlength="3" maxlength="30" pattern="[A-Za-z0-9_-]+"
                                   placeholder="johndoe"
                                   aria-describedby="username-error">
                        </div>
                        <x-input-error :messages="$errors->get('username')" id="username-error" class="auth-error-inline" />
                    </div>

                    <!-- Email Address -->
                    <div class="auth-field-group">
                        <label for="email" class="auth-label">Email</label>
                        <input id="email" name="email" type="email" class="auth-field"
                               value="{{ old('email') }}" required autocomplete="email"
                               placeholder="jean@exemple.fr">
                        <x-input-error :messages="$errors->get('email')" class="auth-error-inline" />
                    </div>

                    <!-- Password -->
                    <div class="auth-field-group">
                        <label for="password" class="auth-label">Mot de passe</label>
                        <input id="password" name="password" type="password" class="auth-field"
                               required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="auth-error-inline" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="auth-field-group">
                        <label for="password_confirmation" class="auth-label">Confirmer le mot de passe</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="auth-field"
                               required autocomplete="new-password"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error-inline" />
                    </div>

                    <button type="submit" class="auth-btn auth-btn-lime">
                        Créer mon compte
                    </button>

                    <p class="auth-switch">
                        Déjà membre ?
                        <a href="{{ route('login') }}" class="auth-link">Se connecter</a>
                    </p>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>
