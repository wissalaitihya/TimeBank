<x-guest-layout title="Connexion">
    <div class="auth-login">
        <div class="auth-login-card">
            <a href="{{ url('/') }}" class="auth-brand" aria-label="TimeBank — accueil">
                <span class="auth-brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9.5" />
                        <path d="M12 6.5V12l3.5 2" />
                    </svg>
                </span>
                <span class="auth-brand-name">TimeBank</span>
            </a>

            <h1 class="auth-title">Bon retour.</h1>
            <p class="auth-subtitle">Reprends là où tu en étais.</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="auth-session" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <a href="{{ route('auth.github') }}" class="auth-btn auth-btn-github" aria-label="Continuer avec GitHub">
                    <svg viewBox="0 0 16 16" width="20" height="20" fill="currentColor" aria-hidden="true">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                    </svg>
                    Continuer avec GitHub
                </a>

                <div class="auth-divider">ou</div>

                <!-- Email Address -->
                <div class="auth-field-group">
                    <label for="email" class="auth-label">Email</label>
                    <input id="email" name="email" type="email" class="auth-field"
                           value="{{ old('email') }}" required autofocus autocomplete="email"
                           placeholder="jean@exemple.fr">
                    <x-input-error :messages="$errors->get('email')" class="auth-error-inline" />
                </div>

                <!-- Password -->
                <div class="auth-field-group">
                    <div class="auth-row-between">
                        <label for="password" class="auth-label auth-label-inline">Mot de passe</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link auth-forgot">Oublié ?</a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password" class="auth-field"
                           required autocomplete="current-password"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="auth-error-inline" />
                </div>

                <button type="submit" class="auth-btn auth-btn-lime">
                    Se connecter
                </button>

                <p class="auth-switch">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="auth-link">Créer un compte</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
