<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TimeBank') }}@if ($title) — {{ $title }}@endif</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /*
             * TimeBank authentication theme.
             * Scoped to guest (login / register / password) pages only —
             * nothing here is applied to authenticated pages.
             */
            .auth-root {
                --tb-bg: #0a0f0a;
                --tb-panel: #0c120c;
                --tb-card: #101710;
                --tb-card2: #141d14;
                --tb-border: #243424;
                --tb-border-soft: #1a241a;
                --tb-lime: #adff2f;
                --tb-lime-soft: rgba(173, 255, 47, 0.14);
                --tb-text: #f2f4f0;
                --tb-muted: #93a08f;
                --tb-green: #132119;
                --tb-danger: #ff8a8a;

                min-height: 100vh;
                font-family: 'Inter', 'Figtree', ui-sans-serif, system-ui, sans-serif;
                color: var(--tb-text);
                background:
                    radial-gradient(1100px 520px at 88% -12%, var(--tb-lime-soft), transparent 62%),
                    radial-gradient(1000px 560px at -12% 112%, rgba(20, 58, 30, 0.35), transparent 62%),
                    var(--tb-bg);
                -webkit-font-smoothing: antialiased;
            }

            .auth-root .auth-link:focus-visible,
            .auth-root .auth-btn:focus-visible,
            .auth-root .auth-field:focus-visible {
                outline: 2px solid var(--tb-lime);
                outline-offset: 2px;
            }

            /* ---------- Shared brand ---------- */
            .auth-brand {
                position: relative;
                display: inline-flex;
                align-items: center;
                gap: .6rem;
                color: var(--tb-text);
                text-decoration: none;
                font-weight: 700;
                letter-spacing: .02em;
                border-radius: .5rem;
            }

            .auth-brand:hover {
                color: var(--tb-lime);
            }

            .auth-brand-mark {
                display: grid;
                place-items: center;
                width: 38px;
                height: 38px;
                border-radius: 12px;
                background: var(--tb-lime);
                color: #0a0f0a;
            }

            .auth-brand-mark svg {
                width: 22px;
                height: 22px;
            }

            .auth-brand-name {
                font-size: 1.15rem;
            }

            /* ---------- Shared typography / form ---------- */
            .auth-title {
                font-family: 'Playfair Display', 'Georgia', serif;
                font-weight: 900;
                font-size: clamp(2rem, 4vw, 2.5rem);
                letter-spacing: -0.01em;
                line-height: 1.1;
                margin: 0 0 .5rem;
                color: var(--tb-text);
            }

            .auth-subtitle {
                margin: 0 0 1.75rem;
                color: var(--tb-muted);
                font-size: .98rem;
            }

            .auth-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: .65rem;
                width: 100%;
                padding: .9rem 1.3rem;
                border-radius: .9rem;
                font-weight: 600;
                font-size: .95rem;
                font-family: inherit;
                text-decoration: none;
                cursor: pointer;
                border: 1px solid transparent;
                transition: background-color .15s ease, border-color .15s ease, box-shadow .15s ease, color .15s ease;
            }

            .auth-btn-github {
                border-color: var(--tb-border);
                background: rgba(255, 255, 255, 0.02);
                color: var(--tb-text);
            }

            .auth-btn-github:hover {
                border-color: var(--tb-lime);
                background: var(--tb-lime-soft);
                color: var(--tb-lime);
            }

            .auth-btn-lime {
                margin-top: .4rem;
                background: var(--tb-lime);
                color: #0a0f0a;
            }

            .auth-btn-lime:hover {
                background: #c2ff55;
                box-shadow: 0 6px 28px rgba(173, 255, 47, 0.35);
            }

            .auth-divider {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin: 1.6rem 0;
                color: var(--tb-muted);
                font-size: .72rem;
                font-weight: 600;
                letter-spacing: .22em;
                text-transform: uppercase;
            }

            .auth-divider::before,
            .auth-divider::after {
                content: "";
                flex: 1;
                height: 1px;
                background: var(--tb-border);
            }

            .auth-field-group {
                margin-bottom: 1.15rem;
            }

            .auth-label {
                display: block;
                margin-bottom: .55rem;
                font-size: .72rem;
                font-weight: 600;
                letter-spacing: .1em;
                text-transform: uppercase;
                color: var(--tb-muted);
            }

            .auth-label-inline {
                margin-bottom: 0;
            }

            .auth-field {
                display: block;
                width: 100%;
                padding: .85rem 1rem;
                font-size: .95rem;
                color: var(--tb-text);
                background: #0d130d;
                border: 1px solid var(--tb-border);
                border-radius: .8rem;
                transition: border-color .15s ease, box-shadow .15s ease;
            }

            .auth-field::placeholder {
                color: #55624f;
            }

            .auth-field:focus {
                outline: none;
                border-color: var(--tb-lime);
                box-shadow: 0 0 0 3px var(--tb-lime-soft);
            }

            .auth-affix {
                display: flex;
                align-items: center;
                gap: .5rem;
                background: #0d130d;
                border: 1px solid var(--tb-border);
                border-radius: .8rem;
                padding: 0 1rem;
                transition: border-color .15s ease, box-shadow .15s ease;
            }

            .auth-affix:focus-within {
                border-color: var(--tb-lime);
                box-shadow: 0 0 0 3px var(--tb-lime-soft);
            }

            .auth-affix .auth-prefix {
                color: var(--tb-muted);
                font-size: .9rem;
                white-space: nowrap;
            }

            .auth-affix .auth-field {
                flex: 1;
                min-width: 0;
                border: none;
                background: transparent;
                padding-left: 0;
            }

            .auth-affix .auth-field:focus {
                box-shadow: none;
            }

            .auth-error-inline {
                margin-top: .5rem;
            }

            .auth-row-between {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin: .25rem 0 1.3rem;
            }

            .auth-link {
                color: var(--tb-text);
                font-weight: 600;
                text-decoration: none;
                border-radius: .35rem;
            }

            .auth-link:hover {
                color: var(--tb-lime);
                text-decoration: underline;
            }

            .auth-switch {
                margin: 1.6rem 0 0;
                text-align: center;
                font-size: .9rem;
                color: var(--tb-muted);
            }

            .auth-session {
                margin-bottom: 1.1rem;
                padding: .7rem .95rem;
                border-radius: .7rem;
                font-size: .88rem;
                color: var(--tb-lime);
                background: var(--tb-lime-soft);
                border: 1px solid rgba(173, 255, 47, 0.35);
            }

            /* ---------- Registration: two-column shell ---------- */
            .auth-shell {
                display: grid;
                grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
                min-height: 100vh;
            }

            .auth-promo {
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 2.25rem 2.75rem;
                background: linear-gradient(160deg, #0e1a12 0%, #0a0f0a 70%);
                border-right: 1px solid var(--tb-border-soft);
                overflow: hidden;
            }

            .auth-promo::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(700px 420px at 20% 8%, rgba(173, 255, 47, 0.08), transparent 60%);
                pointer-events: none;
            }

            .auth-promo::after {
                content: "";
                position: absolute;
                width: 420px;
                height: 420px;
                border-radius: 50%;
                right: -180px;
                bottom: -180px;
                background: radial-gradient(circle, rgba(173, 255, 47, 0.10), transparent 65%);
                pointer-events: none;
            }

            .auth-promo-body {
                position: relative;
                max-width: 480px;
                margin-top: 2.5rem;
            }

            .auth-promo-label {
                font-size: .72rem;
                font-weight: 700;
                letter-spacing: .28em;
                color: var(--tb-lime);
                text-transform: uppercase;
                margin-bottom: 1.1rem;
            }

            .auth-balance {
                position: relative;
                padding: 1.6rem 1.8rem;
                border-radius: 1.4rem;
                background: linear-gradient(150deg, var(--tb-green), #0e1a12 75%);
                border: 1px solid rgba(173, 255, 47, 0.22);
                box-shadow: 0 0 44px rgba(173, 255, 47, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.05);
                overflow: hidden;
            }

            .auth-balance::before {
                content: "";
                position: absolute;
                width: 240px;
                height: 240px;
                border-radius: 50%;
                top: -120px;
                right: -80px;
                background: radial-gradient(circle, rgba(173, 255, 47, 0.28), transparent 65%);
            }

            .auth-balance-amount {
                position: relative;
                font-family: 'Playfair Display', 'Georgia', serif;
                font-size: 3.4rem;
                font-weight: 900;
                line-height: 1.05;
                color: var(--tb-lime);
            }

            .auth-balance-caption {
                position: relative;
                margin-top: .55rem;
                font-size: .85rem;
                color: var(--tb-muted);
            }

            .auth-benefits {
                list-style: none;
                margin: 2rem 0 0;
                padding: 0;
                display: grid;
                gap: .95rem;
            }

            .auth-benefits li {
                display: flex;
                align-items: center;
                gap: .8rem;
                font-size: .95rem;
                color: #d7ddd4;
            }

            .auth-benefits svg {
                flex: none;
                width: 22px;
                height: 22px;
                color: var(--tb-lime);
                border: 1.5px solid rgba(173, 255, 47, 0.55);
                border-radius: 50%;
                padding: 3px;
                background: rgba(173, 255, 47, 0.06);
                box-sizing: border-box;
            }

            .auth-promo-foot {
                position: relative;
                font-size: .8rem;
                color: var(--tb-muted);
                margin-top: 2rem;
            }

            .auth-main {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 3rem 1.5rem;
            }

            .auth-form-wrap {
                width: 100%;
                max-width: 480px;
                margin: auto;
            }

            .auth-mobile-brand {
                display: none;
            }

            /* ---------- Login: centered card ---------- */
            .auth-login {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 2rem 1.25rem;
            }

            .auth-login-card {
                width: 100%;
                max-width: 430px;
                padding: 2.6rem 2.4rem;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01));
                border: 1px solid var(--tb-border-soft);
                border-radius: 1.6rem;
                box-shadow: 0 24px 70px rgba(0, 0, 0, 0.45);
            }

            .auth-login .auth-brand {
                justify-content: center;
                margin-bottom: 1.9rem;
                width: 100%;
            }

            /* ---------- Default Breeze components (password pages) ---------- */
            .auth-root label {
                color: var(--tb-muted) !important;
            }

            .auth-root .text-gray-600,
            .auth-root .text-gray-700 {
                color: var(--tb-muted) !important;
            }

            .auth-root .text-red-600 {
                color: var(--tb-danger) !important;
            }

            .auth-root .text-green-600 {
                color: var(--tb-lime) !important;
            }

            .auth-root input.border-gray-300 {
                border-color: var(--tb-border) !important;
                background-color: #0d130d !important;
                color: var(--tb-text) !important;
            }

            .auth-root input.border-gray-300:focus {
                border-color: var(--tb-lime) !important;
                box-shadow: 0 0 0 3px var(--tb-lime-soft) !important;
            }

            .auth-root button.bg-gray-800,
            .auth-root a.bg-gray-800 {
                background-color: var(--tb-lime) !important;
                color: #0a0f0a !important;
            }

            .auth-root button.bg-gray-800:hover,
            .auth-root a.bg-gray-800:hover {
                background-color: #c2ff55 !important;
            }

            /* ---------- Responsive ---------- */
            @media (max-width: 1023px) {
                .auth-shell {
                    display: block;
                }

                .auth-promo {
                    display: none;
                }

                .auth-mobile-brand {
                    display: flex;
                    margin-bottom: 1.8rem;
                }
            }

            @media (max-width: 480px) {
                .auth-login-card {
                    padding: 2rem 1.4rem;
                }

                .auth-main {
                    padding: 2.25rem 1.1rem;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="auth-root">
            {{ $slot }}
        </div>
    </body>
</html>
