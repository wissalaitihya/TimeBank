<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TimeBank') }}@if ($title) - {{ $title }}@endif</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /*
             * TIMEBANK — premium authentication theme (login / register).
             * Every rule is scoped under .timebank-premium-auth so that no
             * other page (homepage, dashboard, profile) is affected.
             *
             * Palette (matched to the premium reference screens):
             *   Outer background #E7EAEF   Canvas #F9F9FD
             *   Primary ink     #0E1C31    Secondary text #5F667B
             *   Cobalt          #474CF6    Periwinkle #C8D5F8
             *   Coral (brand)   #FA664A    Coral soft    #FF9E8C
             *   Mint            #78CDB1    Amber #F4B35E
             *   Form card       #F6F6FD    Fine border rgba(15,28,49,.10)
             *   Soft shadow     rgba(15,28,49,.14)
             *
             * Shape rule: inputs / buttons / icon chips = 12px;
             * the single header pill is full-radius. No other radii.
             *
             * Motion: entrance 400-600ms, stagger 45-70ms, hover 160-220ms.
             * All motion is gated behind prefers-reduced-motion: no-preference.
             */

            .timebank-premium-auth {
                --tpa-bg:           #E7EAEF;
                --tpa-canvas:       #F9F9FD;
                --tpa-ink:          #0E1C31;
                --tpa-text:         #5F667B;
                --tpa-cobalt:       #474CF6;
                --tpa-cobalt-deep:  #3B41E3;
                --tpa-peri:         #C8D5F8;
                --tpa-icy:          #B7CFFF;
                --tpa-coral:        #FA664A;
                --tpa-coral-deep:   #C44A2F;
                --tpa-mint:         #78CDB1;
                --tpa-amber:        #F4B35E;
                --tpa-line:         rgba(15, 28, 49, 0.10);
                --tpa-line-soft:    rgba(15, 28, 49, 0.06);
                --tpa-line-strong:  rgba(15, 28, 49, 0.22);
                --tpa-shadow:       rgba(15, 28, 49, 0.14);
                --tpa-shadow-soft:  rgba(15, 28, 49, 0.07);
                --tpa-ease:         cubic-bezier(0.16, 1, 0.3, 1);
                --tpa-sans:         'Instrument Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
                --tpa-mono:         ui-monospace, 'SF Mono', 'Cascadia Mono', Consolas, 'Liberation Mono', monospace;

                position: relative;
                min-height: 100vh;
                min-height: 100dvh;
                padding: 24px;
                background: var(--tpa-bg);
                color: var(--tpa-ink);
                font-family: var(--tpa-sans);
                overflow-x: hidden;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }

            /* Soft cool-gray ambience behind the canvas (restrained, flat per reference) */
            .timebank-premium-auth::before {
                content: "";
                position: fixed;
                inset: 0;
                z-index: 0;
                pointer-events: none;
                background:
                    radial-gradient(52% 42% at 8% 0%, rgba(183, 207, 255, 0.10), transparent 70%),
                    radial-gradient(46% 40% at 96% 100%, rgba(132, 122, 255, 0.06), transparent 72%);
            }

            .timebank-premium-auth ::selection {
                background: rgba(71, 76, 246, 0.22);
                color: var(--tpa-ink);
            }

            .timebank-premium-auth [x-cloak] { display: none !important; }

            .timebank-premium-auth a:focus-visible,
            .timebank-premium-auth button:focus-visible,
            .timebank-premium-auth input:focus-visible {
                outline: 2px solid var(--tpa-cobalt);
                outline-offset: 3px;
                border-radius: 4px;
            }

            /* ============================================================
               Keyframes (all gated behind no-preference below)
               ============================================================ */
            @keyframes tpa-canvas-in { from { opacity: 0; transform: translateY(10px); } }
            @keyframes tpa-rise      { from { opacity: 0; transform: translateY(14px); } }
            @keyframes tpa-pop       { from { opacity: 0; transform: scale(0.82); } }
            @keyframes tpa-fade      { from { opacity: 0; } }
            @keyframes tpa-mask-up   { from { transform: translateY(112%); } }
            @keyframes tpa-draw      { to   { stroke-dashoffset: 0; } }
            @keyframes tpa-pulse     {
                0%, 58% { transform: scale(1);    opacity: 0.65; }
                82%     { transform: scale(2.05); opacity: 0; }
                100%    { transform: scale(2.05); opacity: 0; }
            }
            @keyframes tpa-float     { 0%, 100% { transform: translateY(0);    } 50% { transform: translateY(-3px); } }
            @keyframes tpa-tilt      { 0%, 100% { transform: rotate(-0.55deg); } 50% { transform: rotate(0.55deg);  } }
            @keyframes tpa-star-tw   { 0%, 100% { opacity: 0.18; } 50% { opacity: 0.8; } }
            @keyframes tpa-error-in  { from { opacity: 0; transform: translateX(-6px); } }

            .timebank-premium-auth .tpa-line-mask {
                display: block;
                overflow: hidden;
                padding-bottom: 0.12em;
                margin-bottom: -0.12em;
            }
            .timebank-premium-auth .tpa-line-mask > span {
                display: block;
                transform: none;
            }

            /* Paths are fully visible by default (reduced-motion friendly) */
            .timebank-premium-auth .tpa-path-draw {
                stroke-dasharray: 1;
                stroke-dashoffset: 0;
            }

            @media (prefers-reduced-motion: no-preference) {
                .timebank-premium-auth .tpa-canvas {
                    animation: tpa-canvas-in 0.45s var(--tpa-ease) both;
                }
                .timebank-premium-auth .tpa-header,
                .timebank-premium-auth .tpa-brand {
                    animation: tpa-rise 0.45s var(--tpa-ease) both;
                    animation-delay: 0.12s;
                }
                .timebank-premium-auth .tpa-line-mask > span {
                    animation: tpa-mask-up 0.55s var(--tpa-ease) both;
                    animation-delay: var(--d, 0ms);
                }
                .timebank-premium-auth .tpa-rise {
                    animation: tpa-rise 0.5s var(--tpa-ease) both;
                    animation-delay: var(--d, 0ms);
                }
                .timebank-premium-auth .tpa-pop {
                    animation: tpa-pop 0.55s var(--tpa-ease) both;
                    animation-delay: var(--d, 0ms);
                }
                .timebank-premium-auth .tpa-path-draw {
                    stroke-dashoffset: 1;
                    animation: tpa-draw 1.05s var(--tpa-ease) 0.62s both;
                }
                .timebank-premium-auth .tpa-medallion-float,
                .timebank-premium-auth .tpa-timepiece {
                    animation: tpa-float 7s ease-in-out infinite;
                    animation-delay: var(--d, 0s);
                }
                .timebank-premium-auth .tpa-timepiece-svg {
                    animation: tpa-tilt 9s ease-in-out infinite;
                }
                .timebank-premium-auth .tpa-pulse {
                    animation: tpa-pulse 3.4s ease-out infinite;
                    animation-delay: var(--d, 2.5s);
                }
                .timebank-premium-auth .tpa-star {
                    animation: tpa-star-tw 6s ease-in-out infinite;
                    animation-delay: var(--d, 0s);
                }
            }

            /* ============================================================
               Canvas shell
               ============================================================ */
            .timebank-premium-auth .tpa-canvas {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                width: 100%;
                max-width: 1440px;
                margin: 0 auto;
                min-height: calc(100vh - 48px);
                min-height: calc(100svh - 48px);
                min-height: max(760px, calc(100svh - 48px));
                background: var(--tpa-canvas);
                border: 1px solid var(--tpa-line);
                border-radius: clamp(30px, 2.6vw, 36px);
                box-shadow:
                    0 1px 2px rgba(15, 28, 49, 0.05),
                    0 16px 32px -16px rgba(15, 28, 49, 0.14),
                    0 40px 80px -32px var(--tpa-shadow),
                    inset 0 1px 0 rgba(255, 255, 255, 0.85);
                overflow: hidden;
            }

            /* ---------- Compact top header ---------- */
            .timebank-premium-auth .tpa-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                min-height: 72px;
                padding: 14px clamp(22px, 3vw, 40px);
                border-bottom: 1px solid var(--tpa-line-soft);
            }
            .timebank-premium-auth .tpa-brand {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                text-decoration: none;
                color: var(--tpa-ink);
            }
            .timebank-premium-auth .tpa-brand-mark {
                width: 34px;
                height: 34px;
                border-radius: 10px;
                box-shadow: 0 6px 14px -6px rgba(71, 76, 246, 0.5);
            }
            .timebank-premium-auth .tpa-brand-word {
                font-size: 1.06rem;
                font-weight: 650;
                letter-spacing: -0.015em;
            }
            .timebank-premium-auth .tpa-header-link {
                display: inline-flex;
                align-items: center;
                padding: 8px 2px;
                color: var(--tpa-ink);
                font-size: 0.9rem;
                font-weight: 600;
                text-decoration: none;
                border-bottom: 1px solid transparent;
                transition:
                    color 0.18s var(--tpa-ease),
                    border-color 0.18s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-header-link:hover {
                color: var(--tpa-cobalt);
                border-color: var(--tpa-cobalt);
            }
            .timebank-premium-auth .tpa-header-link--cobalt {
                color: var(--tpa-cobalt);
            }
            .timebank-premium-auth .tpa-header-link--cobalt:hover {
                color: var(--tpa-cobalt-deep);
                border-color: var(--tpa-cobalt);
            }

            /* ============================================================
               Shared: headings, lede
               ============================================================ */
            .timebank-premium-auth .tpa-h {
                margin: 0;
                font-size: clamp(2.45rem, 4.1vw, 3.7rem);
                font-weight: 700;
                line-height: 1.04;
                letter-spacing: -0.03em;
                color: var(--tpa-ink);
            }
            .timebank-premium-auth .tpa-h2 {
                margin: 0;
                font-size: clamp(1.65rem, 2.3vw, 2.15rem);
                font-weight: 700;
                line-height: 1.12;
                letter-spacing: -0.022em;
                color: var(--tpa-ink);
            }
            .timebank-premium-auth .tpa-period { color: var(--tpa-coral); }
            .timebank-premium-auth .tpa-lede {
                margin: 18px 0 0;
                max-width: 44ch;
                font-size: 1rem;
                line-height: 1.72;
                color: var(--tpa-text);
            }
            .timebank-premium-auth .tpa-sub {
                margin: 8px 0 0;
                font-size: 0.94rem;
                line-height: 1.6;
                color: var(--tpa-text);
            }

            /* ============================================================
               Shared: buttons
               ============================================================ */
            .timebank-premium-auth .tpa-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                height: 52px;
                border-radius: 12px;
                border: 1px solid transparent;
                font: inherit;
                font-size: 0.97rem;
                font-weight: 600;
                letter-spacing: 0.005em;
                text-decoration: none;
                cursor: pointer;
                transition:
                    transform 0.16s var(--tpa-ease),
                    box-shadow 0.2s var(--tpa-ease),
                    background-color 0.2s var(--tpa-ease),
                    border-color 0.2s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-btn:active {
                transform: scale(0.985);
            }
            .timebank-premium-auth .tpa-btn-arrow {
                width: 16px;
                height: 16px;
                transition: transform 0.18s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-btn:hover .tpa-btn-arrow {
                transform: translateX(3px);
            }
            .timebank-premium-auth .tpa-btn--primary {
                background: var(--tpa-cobalt);
                color: #fff;
                box-shadow:
                    0 10px 22px -10px rgba(71, 76, 246, 0.55),
                    inset 0 1px 0 rgba(255, 255, 255, 0.22);
            }
            .timebank-premium-auth .tpa-btn--primary:hover {
                background: var(--tpa-cobalt-deep);
                transform: translateY(-2px);
                box-shadow:
                    0 18px 30px -12px rgba(71, 76, 246, 0.6),
                    inset 0 1px 0 rgba(255, 255, 255, 0.18);
            }
            .timebank-premium-auth .tpa-btn--primary:active {
                transform: scale(0.985);
            }
            .timebank-premium-auth .tpa-btn--ghost {
                border-color: #C8D5F8;
                background: #fff;
                color: var(--tpa-ink);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }
            .timebank-premium-auth .tpa-btn--ghost:hover {
                background: #FAFBFF;
                border-color: var(--tpa-cobalt);
            }
            .timebank-premium-auth .tpa-btn--ghost svg {
                transition: transform 0.2s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-btn--ghost:hover svg {
                transform: translateX(2px);
            }

            /* ---------- Divider ---------- */
            .timebank-premium-auth .tpa-divider {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 0.66rem;
                font-weight: 600;
                letter-spacing: 0.26em;
                color: #7C8499;
            }
            .timebank-premium-auth .tpa-divider::before,
            .timebank-premium-auth .tpa-divider::after {
                content: "";
                flex: 1;
                height: 1px;
                background: var(--tpa-line-soft);
            }

            /* ============================================================
               Shared: form fields, errors, links, checkbox, notice
               ============================================================ */
            .timebank-premium-auth .tpa-form {
                display: grid;
                gap: 12px;
                margin-top: 18px;
            }
            .timebank-premium-auth .tpa-field {
                display: grid;
                gap: 6px;
            }
            .timebank-premium-auth .tpa-label-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }
            .timebank-premium-auth .tpa-label {
                display: block;
                font-size: 0.84rem;
                font-weight: 600;
                color: var(--tpa-ink);
                transition: color 0.18s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-field:focus-within .tpa-label {
                color: var(--tpa-cobalt);
            }
            .timebank-premium-auth .tpa-input-shell {
                position: relative;
            }
            .timebank-premium-auth .tpa-input {
                display: block;
                width: 100%;
                height: 48px;
                padding: 0 16px;
                border: 1px solid rgba(15, 28, 49, 0.15);
                border-radius: 12px;
                background: #fff;
                color: var(--tpa-ink);
                font: inherit;
                font-size: 0.95rem;
                caret-color: var(--tpa-cobalt);
                transition:
                    border-color 0.18s var(--tpa-ease),
                    box-shadow 0.18s var(--tpa-ease),
                    background-color 0.18s linear;
            }
            .timebank-premium-auth .tpa-input::placeholder {
                color: #8A93A6;
            }
            .timebank-premium-auth .tpa-input:hover {
                border-color: rgba(15, 28, 49, 0.28);
            }
            .timebank-premium-auth .tpa-input:focus {
                outline: none;
                border-color: var(--tpa-cobalt);
                box-shadow: 0 0 0 3px rgba(71, 76, 246, 0.16);
            }
            .timebank-premium-auth .tpa-input:-webkit-autofill,
            .timebank-premium-auth .tpa-input:-webkit-autofill:hover,
            .timebank-premium-auth .tpa-input:-webkit-autofill:focus {
                -webkit-box-shadow: 0 0 0 1000px #fff inset;
                -webkit-text-fill-color: var(--tpa-ink);
                transition: background-color 9999s ease-out 0s;
            }
            .timebank-premium-auth .tpa-input--toggle {
                padding-right: 58px;
            }
            .timebank-premium-auth .tpa-toggle {
                position: absolute;
                top: 50%;
                right: 4px;
                transform: translateY(-50%);
                display: grid;
                place-items: center;
                width: 44px;
                height: 44px;
                border: none;
                border-radius: 10px;
                background: transparent;
                color: var(--tpa-text);
                cursor: pointer;
                transition:
                    background-color 0.16s var(--tpa-ease),
                    color 0.16s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-toggle:hover {
                background: rgba(15, 28, 49, 0.06);
                color: var(--tpa-ink);
            }
            .timebank-premium-auth .tpa-toggle svg {
                width: 20px;
                height: 20px;
            }

            .timebank-premium-auth .tpa-error {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                font-size: 0.83rem;
                line-height: 1.45;
                color: var(--tpa-coral-deep);
                animation: tpa-error-in 0.3s var(--tpa-ease) both;
            }
            .timebank-premium-auth .tpa-error svg {
                flex: none;
                width: 15px;
                height: 15px;
                margin-top: 1px;
            }
            .timebank-premium-auth .tpa-error ul {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 2px;
            }
            .timebank-premium-auth .text-red-600 { color: var(--tpa-coral-deep); }

            .timebank-premium-auth .tpa-link {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--tpa-cobalt);
                text-decoration: none;
                padding-bottom: 2px;
                background-image: linear-gradient(currentColor, currentColor);
                background-repeat: no-repeat;
                background-position: 0 100%;
                background-size: 0 1.5px;
                transition:
                    background-size 0.2s var(--tpa-ease),
                    color 0.2s var(--tpa-ease);
            }
            .timebank-premium-auth .tpa-link:hover {
                background-size: 100% 1.5px;
                color: var(--tpa-cobalt-deep);
            }
            .timebank-premium-auth .tpa-link--sm {
                font-size: 0.83rem;
                font-weight: 500;
            }
            .timebank-premium-auth .tpa-switch {
                margin: 4px 0 0;
                text-align: center;
                font-size: 0.9rem;
                color: var(--tpa-text);
            }

            .timebank-premium-auth .tpa-check {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-size: 0.88rem;
                color: var(--tpa-text);
                cursor: pointer;
                user-select: none;
            }
            .timebank-premium-auth .tpa-check input {
                position: absolute;
                width: 1px;
                height: 1px;
                opacity: 0;
            }
            .timebank-premium-auth .tpa-check-box {
                display: grid;
                place-items: center;
                width: 20px;
                height: 20px;
                border: 1px solid rgba(15, 28, 49, 0.24);
                border-radius: 6px;
                background: #fff;
                transition:
                    background-color 0.15s linear,
                    border-color 0.15s linear;
            }
            .timebank-premium-auth .tpa-check-box svg {
                width: 12px;
                height: 12px;
                color: #fff;
                opacity: 0;
                transform: scale(0.4);
                transition:
                    opacity 0.15s linear,
                    transform 0.15s linear;
            }
            .timebank-premium-auth .tpa-check input:checked + .tpa-check-box {
                background: var(--tpa-cobalt);
                border-color: var(--tpa-cobalt);
            }
            .timebank-premium-auth .tpa-check input:checked + .tpa-check-box svg {
                opacity: 1;
                transform: scale(1);
            }
            .timebank-premium-auth .tpa-check input:focus-visible + .tpa-check-box {
                box-shadow: 0 0 0 3px rgba(71, 76, 246, 0.2);
            }

            .timebank-premium-auth .tpa-session {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin: 18px 0 0;
                padding: 12px 14px;
                border: 1px solid rgba(120, 205, 177, 0.5);
                border-radius: 12px;
                background: rgba(120, 205, 177, 0.13);
                color: #2E6B58;
                font-size: 0.88rem;
                line-height: 1.5;
            }
            .timebank-premium-auth .tpa-session svg {
                flex: none;
                width: 17px;
                height: 17px;
                margin-top: 1px;
            }

            /* ============================================================
               Illustration primitives (scoped, aria-hidden only)
               ============================================================ */
            .timebank-premium-auth .tpa-medallion {
                transform-box: fill-box;
                transform-origin: center;
                filter: drop-shadow(0 8px 16px rgba(15, 28, 49, 0.22));
            }
            .timebank-premium-auth .tpa-medallion-float {
                transform-box: fill-box;
                transform-origin: center;
            }
            .timebank-premium-auth .tpa-pulse {
                transform-box: fill-box;
                transform-origin: center;
            }
            .timebank-premium-auth .tpa-star {
                opacity: 0.35;
            }

            /* ============================================================
               LOGIN — asymmetric two-column composition
               ============================================================ */
            .timebank-premium-auth .tpa-login-grid {
                display: grid;
                grid-template-columns: minmax(0, 56fr) minmax(0, 44fr);
                flex: 1;
                min-height: 0;
            }
            .timebank-premium-auth .tpa-visual--login {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: clamp(34px, 4.6vh, 60px) clamp(28px, 3.2vw, 56px);
            }
            .timebank-premium-auth .tpa-visual--login .tpa-lede {
                margin: 24px 0 0;
                max-width: 46ch;
            }
            .timebank-premium-auth .tpa-timepiece {
                width: min(100%, 560px);
                margin-top: 0;
            }
            .timebank-premium-auth .tpa-timepiece svg {
                display: block;
                width: 100%;
                height: auto;
            }

            .timebank-premium-auth .tpa-login-form {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: clamp(34px, 5vh, 64px) clamp(26px, 3.6vw, 68px) clamp(34px, 5vh, 64px) clamp(8px, 1.6vw, 26px);
            }
            .timebank-premium-auth .tpa-login-form-inner {
                width: 100%;
                max-width: 500px;
                margin: 0 auto;
            }
            .timebank-premium-auth .tpa-login-actions {
                display: grid;
                gap: 17px;
            }

            /* ============================================================
               REGISTER — editorial left area + periwinkle form card
               ============================================================ */
            .timebank-premium-auth .tpa-reg-grid {
                display: grid;
                grid-template-columns: minmax(0, 55fr) minmax(0, 45fr);
                gap: clamp(24px, 2.8vw, 44px);
                flex: 1;
                min-height: 0;
                align-items: stretch;
                padding: clamp(18px, 2.4vh, 30px) clamp(28px, 3.2vw, 56px);
            }
            .timebank-premium-auth .tpa-visual--register {
                display: flex;
                flex-direction: column;
            }
            .timebank-premium-auth .tpa-visual--register .tpa-h {
                font-size: clamp(2.2rem, 3.5vw, 3.2rem);
            }
            .timebank-premium-auth .tpa-orbit {
                width: min(100%, 520px);
                margin-top: clamp(18px, 2.6vh, 28px);
            }
            .timebank-premium-auth .tpa-orbit svg {
                display: block;
                width: 100%;
                height: auto;
            }

            .timebank-premium-auth .tpa-features {
                list-style: none;
                margin: clamp(16px, 2.4vh, 26px) 0 0;
                padding: 0;
                max-width: 560px;
            }
            .timebank-premium-auth .tpa-feature {
                display: grid;
                grid-template-columns: 44px minmax(0, 1fr);
                gap: 14px;
                align-items: center;
                padding: 12px 0;
            }
            .timebank-premium-auth .tpa-feature-icon {
                display: grid;
                place-items: center;
                width: 44px;
                height: 44px;
                border-radius: 14px;
                color: var(--tpa-ink);
                box-shadow: inset 0 0 0 1px rgba(15, 28, 49, 0.05);
            }
            .timebank-premium-auth .tpa-feature-icon svg {
                width: 20px;
                height: 20px;
            }
            .timebank-premium-auth .tpa-feature-icon--peri   { background: #F3F5FE; color: #4F63C8; }
            .timebank-premium-auth .tpa-feature-icon--frost  { background: #F4F3FD; color: #5B56C9; }
            .timebank-premium-auth .tpa-feature-icon--mint   { background: #E0F5F2; color: #1E7A6C; }
            .timebank-premium-auth .tpa-feature-icon--coral  { background: #FAF3F0; color: #E06A4E; }
            .timebank-premium-auth .tpa-feature h3 {
                margin: 0;
                font-size: 0.93rem;
                font-weight: 650;
                color: var(--tpa-ink);
                letter-spacing: -0.01em;
            }
            .timebank-premium-auth .tpa-feature p {
                margin: 3px 0 0;
                font-size: 0.84rem;
                line-height: 1.5;
                color: var(--tpa-text);
            }

            .timebank-premium-auth .tpa-form-card {
                width: 100%;
                justify-self: stretch;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: clamp(34px, 2.4vw, 40px);
                background: linear-gradient(180deg, #F9FAFE 0%, #F6F6FD 100%);
                border-left: 1px solid rgba(15, 28, 49, 0.06);
                box-shadow:
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }
            .timebank-premium-auth .tpa-form-card-inner {
                width: 100%;
                max-width: 520px;
                margin: 0 auto;
            }

            /* ============================================================
               Breeze companion pages (forgot / reset / confirm / verify)
               Minimal compatibility so they stay clean and usable.
               ============================================================ */
            .timebank-premium-auth .bg-gray-100 { background: transparent; }
            .timebank-premium-auth .bg-white {
                background: var(--tpa-canvas);
                border: 1px solid var(--tpa-line);
                border-radius: 24px;
                box-shadow: 0 24px 48px -24px var(--tpa-shadow);
            }
            .timebank-premium-auth .text-gray-600,
            .timebank-premium-auth .text-gray-700 { color: var(--tpa-text); }
            .timebank-premium-auth .text-green-600 { color: #2E6B58; }
            .timebank-premium-auth input.border-gray-300 {
                background: #fff;
                border: 1px solid rgba(15, 28, 49, 0.15);
                border-radius: 12px;
                color: var(--tpa-ink);
                caret-color: var(--tpa-cobalt);
            }
            .timebank-premium-auth input.border-gray-300:focus {
                border-color: var(--tpa-cobalt);
                box-shadow: 0 0 0 3px rgba(71, 76, 246, 0.16);
            }
            .timebank-premium-auth button.bg-gray-800,
            .timebank-premium-auth a.bg-gray-800 {
                background-color: var(--tpa-cobalt);
                color: #fff;
                border-radius: 12px;
            }
            .timebank-premium-auth button.bg-gray-800:hover,
            .timebank-premium-auth a.bg-gray-800:hover {
                background-color: var(--tpa-cobalt-deep);
            }

            /* ============================================================
               Responsive
               ============================================================ */
            @media (max-width: 1100px) {
                .timebank-premium-auth .tpa-login-grid,
                .timebank-premium-auth .tpa-reg-grid {
                    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                    gap: 28px;
                }
                .timebank-premium-auth .tpa-timepiece {
                    width: min(100%, 460px);
                }
                .timebank-premium-auth .tpa-orbit {
                    width: min(100%, 420px);
                }
                .timebank-premium-auth .tpa-h {
                    font-size: clamp(2.2rem, 4vw, 2.9rem);
                }
                .timebank-premium-auth .tpa-form-card {
                    padding: 28px;
                }
                .timebank-premium-auth .tpa-login-form {
                    padding-right: clamp(26px, 3vw, 44px);
                    padding-left: 8px;
                }
            }

            @media (max-width: 820px) {
                .timebank-premium-auth {
                    padding: 14px;
                }
                .timebank-premium-auth .tpa-canvas {
                    min-height: calc(100dvh - 28px);
                    border-radius: 26px;
                }
                .timebank-premium-auth .tpa-header {
                    padding: 14px 18px;
                    min-height: 60px;
                }
                .timebank-premium-auth .tpa-brand-mark {
                    width: 30px;
                    height: 30px;
                }
                .timebank-premium-auth .tpa-brand-word {
                    font-size: 0.98rem;
                }

                .timebank-premium-auth .tpa-login-grid,
                .timebank-premium-auth .tpa-reg-grid {
                    grid-template-columns: minmax(0, 1fr);
                    gap: 22px;
                    padding: 24px 18px 32px;
                    align-items: stretch;
                }

                /* Login: compact visual on top, form is the priority */
                .timebank-premium-auth .tpa-visual--login {
                    padding: 6px 0 0;
                    justify-content: flex-start;
                }
                .timebank-premium-auth .tpa-timepiece {
                    width: min(100%, 300px);
                    margin: 18px auto 0;
                }
                .timebank-premium-auth .tpa-login-form {
                    padding: 8px 0 0;
                }

                /* Register: compact headline + orbit below, form is the priority */
                .timebank-premium-auth .tpa-visual--register .tpa-h {
                    font-size: clamp(2rem, 8.5vw, 2.5rem);
                }
                .timebank-premium-auth .tpa-orbit {
                    width: min(100%, 320px);
                    margin: 16px auto 0;
                }
                .timebank-premium-auth .tpa-form-card {
                    max-width: none;
                    justify-self: stretch;
                    padding: 26px 22px;
                    order: -1;
                }
                .timebank-premium-auth .tpa-visual--register {
                    order: 0;
                }
                .timebank-premium-auth .tpa-features {
                    max-width: none;
                    margin-top: 20px;
                }
                .timebank-premium-auth .tpa-star {
                    display: none;
                }
                .timebank-premium-auth .tpa-h2 {
                    font-size: 1.55rem;
                }
            }

            /* ============================================================
               Reduced motion
               ============================================================ */
            @media (prefers-reduced-motion: reduce) {
                .timebank-premium-auth *,
                .timebank-premium-auth *::before,
                .timebank-premium-auth *::after {
                    animation: none !important;
                    transition: none !important;
                }
                .timebank-premium-auth .tpa-path-draw {
                    stroke-dashoffset: 0;
                }
            }

            /* ============================================================
               DARK LOGIN — "TBK" theme (login reference, near-black canvas)
               Activated by the "dark" theme flag on the guest layout for
               the login page. Everything is scoped under
               .timebank-premium-auth--dark so register / forgot / reset /
               verify pages stay untouched.
               ============================================================ */

            .timebank-premium-auth--dark {
                --tb-bg:        #050403;
                --tb-card:      #0B0908;
                --tb-ctrl:      #151210;
                --tb-text:      #F5F2EE;
                --tb-muted:     #77716D;
                --tb-border:    #29201B;
                --tb-red-deep:  #5A0710;
                --tb-vermilion: #FF3B0A;
                --tb-orange:    #FF6A00;
                --tb-amber:     #FF8A00;
                --tb-gold:      #FFC247;
                --tb-sans:      'Instrument Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
                --tb-serif:     'Playfair Display', Georgia, 'Times New Roman', serif;
                --tb-mono:      ui-monospace, 'SF Mono', 'Cascadia Mono', Consolas, 'Liberation Mono', monospace;
                --tb-ease:      cubic-bezier(0.2, 0.65, 0.25, 1);

                padding: 0;
                background: var(--tb-bg);
                color: var(--tb-text);
                font-family: var(--tb-sans);
            }

            .timebank-premium-auth--dark::before { display: none; }

            .timebank-premium-auth--dark ::selection {
                background: rgba(255, 106, 0, 0.28);
                color: var(--tb-text);
            }

            .timebank-premium-auth--dark a:focus-visible,
            .timebank-premium-auth--dark button:focus-visible,
            .timebank-premium-auth--dark input:focus-visible {
                outline: 2px solid var(--tb-orange);
                outline-offset: 3px;
                border-radius: 4px;
            }

            .timebank-premium-auth--dark .tbk-page {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                width: 100%;
                min-height: 100vh;
                min-height: 100dvh;
                overflow-x: hidden;
            }

            /* ---------- Subtle coordinate / grid backdrop ---------- */
            .timebank-premium-auth--dark .tbk-gridline {
                position: absolute;
                inset: 0;
                z-index: 0;
                pointer-events: none;
                background:
                    linear-gradient(rgba(245, 242, 238, 0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(245, 242, 238, 0.025) 1px, transparent 1px);
                background-size: 72px 72px;
            }
            .timebank-premium-auth--dark .tbk-gridline::before {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                left: 55%;
                width: 1px;
                background: rgba(245, 242, 238, 0.03);
            }
            .timebank-premium-auth--dark .tbk-gridline::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                bottom: clamp(34px, 4.6vh, 48px);
                height: 1px;
                background: rgba(245, 242, 238, 0.045);
            }

            /* ---------- Two-column body ---------- */
            .timebank-premium-auth--dark .tbk-body {
                position: relative;
                z-index: 1;
                flex: 1 1 auto;
                min-height: 0;
                display: grid;
                grid-template-columns: minmax(0, 55fr) minmax(0, 45fr);
            }

            /* ---------- Left visual ---------- */
            .timebank-premium-auth--dark .tbk-stage {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                padding: clamp(26px, 3.6vh, 44px) clamp(26px, 3.4vw, 58px);
                background: url('/assets/light-background-with-sunset-projector-lamp.jpg') center/cover no-repeat;
                overflow: hidden;
            }
            .timebank-premium-auth--dark .tbk-stage::before {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(5, 4, 3, 0.3) 0%, rgba(5, 4, 3, 0.55) 50%, rgba(5, 4, 3, 0.8) 100%);
                z-index: 1;
                pointer-events: none;
            }
            .timebank-premium-auth--dark .tbk-masthead {
                position: relative;
                z-index: 4;
                display: flex;
                justify-content: flex-start;
            }
            .timebank-premium-auth--dark .tbk-logo {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                color: var(--tb-text);
            }
            .timebank-premium-auth--dark .tbk-logo-clock {
                width: 30px;
                height: 30px;
                color: var(--tb-orange);
            }
            .timebank-premium-auth--dark .tbk-logo-word {
                font-size: 1.18rem;
                font-weight: 700;
                letter-spacing: -0.02em;
                line-height: 1;
            }
            .timebank-premium-auth--dark .tbk-logo-word--accent {
                color: var(--tb-orange);
            }

            .timebank-premium-auth--dark .tbk-visual {
                position: relative;
                flex: 1 1 auto;
                min-height: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding-top: clamp(40px, 6vh, 72px);
                padding-bottom: clamp(28px, 4.5vh, 56px);
            }

            /* ---------- Time markers at edges ---------- */
            .timebank-premium-auth--dark .tbk-time-marker {
                position: absolute;
                z-index: 2;
                font-family: var(--tb-mono);
                font-size: 0.6rem;
                letter-spacing: 0.12em;
                color: rgba(245, 242, 238, 0.12);
                pointer-events: none;
                user-select: none;
            }
            .timebank-premium-auth--dark .tbk-time-marker--tl { top: clamp(14px, 2vh, 22px); left: clamp(14px, 2vw, 22px); }
            .timebank-premium-auth--dark .tbk-time-marker--tr { top: clamp(14px, 2vh, 22px); right: clamp(14px, 2vw, 22px); }
            .timebank-premium-auth--dark .tbk-time-marker--bl { bottom: clamp(14px, 2vh, 22px); left: clamp(14px, 2vw, 22px); }
            .timebank-premium-auth--dark .tbk-time-marker--br { bottom: clamp(14px, 2vh, 22px); right: clamp(14px, 2vw, 22px); }

            /* ---------- Headline ---------- */
            .timebank-premium-auth--dark .tbk-headline {
                position: relative;
                z-index: 3;
                margin: 0;
                max-width: 15ch;
                font-size: clamp(2.8rem, 5.5vw, 5.5rem);
                font-weight: 800;
                line-height: 1.02;
                letter-spacing: -0.035em;
                color: var(--tb-text);
                text-shadow: 0 2px 30px rgba(5, 4, 3, 0.9);
            }
            .timebank-premium-auth--dark .tbk-headline span {
                display: block;
            }
            .timebank-premium-auth--dark .tbk-headline em {
                font-family: var(--tb-serif);
                font-weight: 700;
                font-style: italic;
                color: var(--tb-orange);
                letter-spacing: -0.01em;
            }
            .timebank-premium-auth--dark .tbk-copy {
                position: relative;
                z-index: 3;
                margin: clamp(18px, 3vh, 30px) 0 0;
                font-size: clamp(0.92rem, 1.05vw, 1.02rem);
                line-height: 1.65;
                color: var(--tb-muted);
                letter-spacing: 0.005em;
                text-shadow: 0 1px 14px rgba(5, 4, 3, 0.85);
            }
            .timebank-premium-auth--dark .tbk-copy span {
                display: block;
            }

            /* ---------- Right form column ---------- */
            .timebank-premium-auth--dark .tbk-panel {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 0;
                padding: clamp(26px, 3.6vh, 44px) clamp(22px, 3.2vw, 52px);
            }
            .timebank-premium-auth--dark .tbk-panel-inner {
                width: 100%;
                max-width: 480px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .timebank-premium-auth--dark .tbk-card {
                width: 100%;
                padding: clamp(30px, 3.4vh, 46px) clamp(26px, 2.4vw, 40px);
                background: rgba(11, 9, 8, 0.65);
                border: 1px solid rgba(245, 242, 238, 0.06);
                border-radius: 20px;
                box-shadow: 0 20px 50px -30px rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(8px);
            }
            .timebank-premium-auth--dark .tbk-title {
                margin: 0;
                font-size: clamp(1.6rem, 2vw, 2rem);
                font-weight: 700;
                letter-spacing: -0.03em;
                color: var(--tb-text);
            }
            .timebank-premium-auth--dark .tbk-sub {
                margin: 10px 0 0;
                font-size: 0.96rem;
                line-height: 1.55;
                color: var(--tb-muted);
            }
            .timebank-premium-auth--dark .tbk-session {
                display: flex;
                align-items: center;
                gap: 9px;
                margin: 18px 0 0;
                padding: 10px 13px;
                border: 1px solid rgba(255, 138, 0, 0.35);
                border-radius: 10px;
                background: rgba(255, 106, 0, 0.08);
                color: var(--tb-amber);
                font-size: 0.85rem;
                line-height: 1.45;
            }
            .timebank-premium-auth--dark .tbk-session-dot {
                flex: none;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: var(--tb-amber);
            }

            /* ---------- Form ---------- */
            .timebank-premium-auth--dark .tbk-form {
                display: grid;
                gap: 20px;
                margin-top: 26px;
            }
            .timebank-premium-auth--dark .tbk-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                height: 50px;
                border-radius: 12px;
                border: 1px solid transparent;
                font: inherit;
                font-size: 0.95rem;
                font-weight: 600;
                letter-spacing: 0.005em;
                text-decoration: none;
                cursor: pointer;
                -webkit-tap-highlight-color: transparent;
            }
            .timebank-premium-auth--dark .tbk-btn--github {
                position: relative;
                overflow: hidden;
                background: var(--tb-ctrl);
                border-color: var(--tb-border);
                color: var(--tb-text);
                transition:
                    border-color 0.2s var(--tb-ease),
                    background-color 0.2s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-btn--github::after {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                left: -60%;
                width: 40%;
                transform: skewX(-20deg);
                background: linear-gradient(90deg, transparent, rgba(255, 194, 71, 0.14), transparent);
                transition: left 0.55s var(--tb-ease);
                pointer-events: none;
            }
            @media (hover: hover) {
                .timebank-premium-auth--dark .tbk-btn--github:hover {
                    background: #1A1613;
                    border-color: #3A2E24;
                }
                .timebank-premium-auth--dark .tbk-btn--github:hover::after {
                    left: 130%;
                }
            }

            .timebank-premium-auth--dark .tbk-divider {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 0.64rem;
                font-weight: 600;
                letter-spacing: 0.28em;
                color: var(--tb-muted);
            }
            .timebank-premium-auth--dark .tbk-divider::before,
            .timebank-premium-auth--dark .tbk-divider::after {
                content: "";
                flex: 1;
                height: 1px;
                background: var(--tb-border);
            }

            .timebank-premium-auth--dark .tbk-field {
                display: grid;
                gap: 8px;
            }
            .timebank-premium-auth--dark .tbk-label {
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.01em;
                color: var(--tb-muted);
            }
            .timebank-premium-auth--dark .tbk-input-wrap {
                position: relative;
            }
            .timebank-premium-auth--dark .tbk-input {
                display: block;
                width: 100%;
                height: 50px;
                padding: 0 2px;
                background: transparent;
                border: none;
                border-bottom: 1px solid var(--tb-border);
                border-radius: 0;
                color: var(--tb-text);
                font: inherit;
                font-size: 0.98rem;
                caret-color: var(--tb-orange);
                transition:
                    border-color 0.2s var(--tb-ease),
                    box-shadow 0.2s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-input::placeholder {
                color: #4A443F;
            }
            .timebank-premium-auth--dark .tbk-input:hover {
                border-bottom-color: #3A3028;
            }
            .timebank-premium-auth--dark .tbk-input:focus {
                outline: none;
                border-bottom-color: var(--tb-orange);
                box-shadow: 0 1px 0 var(--tb-orange);
            }
            .timebank-premium-auth--dark .tbk-input:-webkit-autofill,
            .timebank-premium-auth--dark .tbk-input:-webkit-autofill:hover,
            .timebank-premium-auth--dark .tbk-input:-webkit-autofill:focus {
                -webkit-box-shadow: 0 0 0 1000px var(--tb-card) inset;
                -webkit-text-fill-color: var(--tb-text);
                border-bottom: 1px solid var(--tb-border);
                transition: background-color 9999s ease-out 0s;
            }
            .timebank-premium-auth--dark .tbk-input--pad {
                padding-right: 52px;
            }
            .timebank-premium-auth--dark .tbk-eye {
                position: absolute;
                top: 50%;
                right: 2px;
                transform: translateY(-50%);
                display: grid;
                place-items: center;
                width: 44px;
                height: 44px;
                border: none;
                border-radius: 10px;
                background: transparent;
                color: var(--tb-muted);
                cursor: pointer;
                transition:
                    color 0.16s var(--tb-ease),
                    background-color 0.16s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-eye:hover {
                color: var(--tb-text);
                background: rgba(245, 242, 238, 0.05);
            }
            .timebank-premium-auth--dark .tbk-eye svg {
                width: 20px;
                height: 20px;
            }

            .timebank-premium-auth--dark .tbk-forgot {
                display: block;
                margin-top: 4px;
                font-size: 0.83rem;
                font-weight: 500;
                color: var(--tb-orange);
                text-decoration: none;
                text-align: right;
                transition: color 0.16s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-forgot:hover {
                color: var(--tb-amber);
            }

            .timebank-premium-auth--dark .tbk-errors ul {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 2px;
            }
            .timebank-premium-auth--dark .tbk-errors .text-red-600 {
                color: var(--tb-vermilion);
            }
            .timebank-premium-auth--dark .tbk-errors li {
                font-size: 0.82rem;
            }

            .timebank-premium-auth--dark .tbk-actions {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 18px;
                flex-wrap: wrap;
                margin-top: 4px;
            }
            .timebank-premium-auth--dark .tbk-check {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                min-height: 44px;
                font-size: 0.88rem;
                color: var(--tb-muted);
                cursor: pointer;
                user-select: none;
            }
            .timebank-premium-auth--dark .tbk-check input {
                position: absolute;
                width: 1px;
                height: 1px;
                opacity: 0;
            }
            .timebank-premium-auth--dark .tbk-check-mark {
                display: grid;
                place-items: center;
                width: 21px;
                height: 21px;
                border: 1.5px solid var(--tb-orange);
                border-radius: 6px;
                color: #14100C;
                transition:
                    background-color 0.15s linear,
                    box-shadow 0.15s linear;
            }
            .timebank-premium-auth--dark .tbk-check-mark svg {
                width: 13px;
                height: 13px;
                opacity: 0;
                transform: scale(0.4);
                transition:
                    opacity 0.15s linear,
                    transform 0.15s linear;
            }
            .timebank-premium-auth--dark .tbk-check input:checked + .tbk-check-mark {
                background: var(--tb-orange);
            }
            .timebank-premium-auth--dark .tbk-check input:checked + .tbk-check-mark svg {
                opacity: 1;
                transform: scale(1);
            }
            .timebank-premium-auth--dark .tbk-check input:focus-visible + .tbk-check-mark {
                box-shadow: 0 0 0 3px rgba(255, 106, 0, 0.3);
            }

            .timebank-premium-auth--dark .tbk-btn--submit {
                background: linear-gradient(90deg, var(--tb-orange) 0%, var(--tb-amber) 55%, var(--tb-gold) 100%);
                color: var(--tb-text);
                border: none;
                box-shadow:
                    0 14px 30px -14px rgba(255, 106, 0, 0.45),
                    inset 0 1px 0 rgba(255, 255, 255, 0.25);
                transition:
                    transform 0.16s var(--tb-ease),
                    box-shadow 0.2s var(--tb-ease),
                    filter 0.2s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-btn--submit:hover {
                filter: brightness(1.06);
                box-shadow:
                    0 18px 38px -14px rgba(255, 106, 0, 0.6),
                    inset 0 1px 0 rgba(255, 255, 255, 0.25);
            }
            .timebank-premium-auth--dark .tbk-btn--submit:active {
                transform: scale(0.985);
            }
            .timebank-premium-auth--dark .tbk-btn--submit:disabled {
                opacity: 0.85;
                cursor: default;
            }
            .timebank-premium-auth--dark .tbk-btn-arrow {
                flex: none;
                width: 17px;
                height: 17px;
                margin-left: 2px;
                color: #0D0906;
                transition: transform 0.18s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-btn--submit:hover .tbk-btn-arrow {
                transform: translateX(4px);
            }
            .timebank-premium-auth--dark .tbk-spinner-wrap {
                display: inline-flex;
                align-items: center;
                gap: 10px;
            }
            .timebank-premium-auth--dark .tbk-spinner {
                width: 17px;
                height: 17px;
                color: var(--tb-text);
                animation: tbk-spin 0.9s linear infinite;
            }

            .timebank-premium-auth--dark .tbk-switch {
                margin-top: 20px;
                text-align: center;
                font-size: 0.9rem;
                color: var(--tb-muted);
            }
            .timebank-premium-auth--dark .tbk-link {
                color: var(--tb-orange);
                font-weight: 600;
                text-decoration: none;
                padding-bottom: 2px;
                background-image: linear-gradient(currentColor, currentColor);
                background-repeat: no-repeat;
                background-position: 0 100%;
                background-size: 0 1.5px;
                transition:
                    background-size 0.2s var(--tb-ease),
                    color 0.2s var(--tb-ease);
            }
            .timebank-premium-auth--dark .tbk-link:hover {
                background-size: 100% 1.5px;
                color: var(--tb-amber);
            }

            /* ---------- Bottom ledger ---------- */
            .timebank-premium-auth--dark .tbk-ledger {
                position: relative;
                z-index: 1;
                flex: none;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 18px;
                height: clamp(34px, 4.6vh, 48px);
                padding: 0 clamp(20px, 2.6vw, 44px);
                border-top: 1px solid rgba(245, 242, 238, 0.05);
                font-family: var(--tb-mono);
                font-size: 0.64rem;
                letter-spacing: 0.14em;
                color: var(--tb-muted);
            }
            .timebank-premium-auth--dark .tbk-ledger-left,
            .timebank-premium-auth--dark .tbk-ledger-right {
                display: inline-flex;
                align-items: center;
                gap: 18px;
                white-space: nowrap;
            }
            .timebank-premium-auth--dark .tbk-ledger-word {
                font-weight: 700;
                color: #9A9088;
                letter-spacing: 0.32em;
            }
            .timebank-premium-auth--dark .tbk-ledger-mono {
                color: #5F5852;
                letter-spacing: 0.12em;
            }
            .timebank-premium-auth--dark .tbk-ledger-dot {
                flex: none;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--tb-orange);
                opacity: 0.85;
                box-shadow: 0 0 8px rgba(255, 106, 0, 0.55);
            }
            .timebank-premium-auth--dark .tbk-ledger-sep {
                flex: none;
                width: 1px;
                height: 12px;
                background: rgba(245, 242, 238, 0.1);
            }
            .timebank-premium-auth--dark .tbk-ledger-divider {
                color: rgba(245, 242, 238, 0.1);
                font-weight: 300;
            }
            .timebank-premium-auth--dark .tbk-ledger-right {
                margin-left: auto;
            }

            /* ---------- Motion (restrained, gated) ---------- */
            @keyframes tbk-rise {
                from { opacity: 0; transform: translateY(16px); }
            }
            @keyframes tbk-fade-in {
                from { opacity: 0; }
            }
            @keyframes tbk-breathe {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-9px) scale(1.012); }
            }
            @keyframes tbk-spin {
                to { transform: rotate(360deg); }
            }

            @media (prefers-reduced-motion: no-preference) {
                .timebank-premium-auth--dark .tbk-card {
                    animation: tbk-rise 0.55s var(--tb-ease) both;
                    animation-delay: 0.08s;
                }
                .timebank-premium-auth--dark .tbk-logo {
                    animation: tbk-fade-in 0.6s var(--tb-ease) both;
                    animation-delay: 0.05s;
                }
                .timebank-premium-auth--dark .tbk-headline span {
                    animation: tbk-rise 0.6s var(--tb-ease) both;
                }
                .timebank-premium-auth--dark .tbk-headline span:nth-child(1) { animation-delay: 0.12s; }
                .timebank-premium-auth--dark .tbk-headline span:nth-child(2) { animation-delay: 0.2s; }
                .timebank-premium-auth--dark .tbk-headline span:nth-child(3) { animation-delay: 0.28s; }
                .timebank-premium-auth--dark .tbk-copy {
                    animation: tbk-rise 0.6s var(--tb-ease) both;
                    animation-delay: 0.38s;
                }
            }

            /* ---------- Tablet: keep two columns, scale down ---------- */
            @media (max-width: 1180px) and (min-width: 741px) {
                .timebank-premium-auth--dark .tbk-headline {
                    font-size: clamp(2rem, 3.9vw, 3.2rem);
                }
                .timebank-premium-auth--dark .tbk-panel-inner {
                    max-width: 420px;
                }
                .timebank-premium-auth--dark .tbk-ribbon {
                    height: 96%;
                    top: 2%;
                }
            }

            /* ---------- Mobile: hide decorative visual, keep logo ---------- */
            @media (max-width: 740px) {
                .timebank-premium-auth--dark .tbk-body {
                    grid-template-columns: minmax(0, 1fr);
                }
                .timebank-premium-auth--dark .tbk-stage {
                    padding: 18px 20px 4px;
                    min-height: auto;
                }
                .timebank-premium-auth--dark .tbk-visual {
                    display: none;
                }
                .timebank-premium-auth--dark .tbk-panel {
                    padding: 24px 20px 30px;
                }
                .timebank-premium-auth--dark .tbk-panel-inner {
                    max-width: none;
                }
                .timebank-premium-auth--dark .tbk-ledger {
                    padding: 0 20px;
                }
                .timebank-premium-auth--dark .tbk-ledger-mono {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="timebank-premium-auth{{ $attributes->get('theme') === 'dark' ? ' timebank-premium-auth--dark' : '' }}">
            {{ $slot }}
        </div>
    </body>
</html>
