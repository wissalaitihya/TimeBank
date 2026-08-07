<x-app-layout>
    <style>
        /* ═══════════════════════════════════════════════════════
           API Tokens — orange TimeBank design system
           ═══════════════════════════════════════════════════════ */

        .tk-page {
            --tk-bg: #070706;
            --tk-surface: #0B0A09;
            --tk-elevated: #11100F;
            --tk-input: #151311;
            --tk-text: #F5F2ED;
            --tk-muted: #918B84;
            --tk-faint: #625D58;
            --tk-border: rgba(255,255,255,0.08);
            --tk-border-warm: rgba(255,101,0,0.28);
            --tk-orange: #FF6500;
            --tk-amber: #FFAE25;

            position: relative;
            min-height: calc(100vh - 54px);
            padding: 48px 56px 60px;
            overflow: hidden;
            color: var(--tk-text);
            background: var(--tk-bg);
        }

        .tk-page::before {
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

        .tk-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 780px;
        }

        /* ── Eyebrow ─────────────────────────────────────────── */
        .tk-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--tk-faint);
            font-family: "JetBrains Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .tk-eyebrow::before {
            content: "";
            width: 14px;
            height: 1px;
            background: var(--tk-faint);
        }

        /* ── Header ──────────────────────────────────────── */
        .tk-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            opacity: 0;
            animation: tk-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .tk-title {
            margin: 0 0 8px;
            color: var(--tk-text);
            font-family: "Playfair Display", serif;
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .tk-subtitle {
            margin: 0;
            color: var(--tk-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .tk-separator {
            width: 100%;
            height: 1px;
            background: var(--tk-border);
            margin-bottom: 40px;
            opacity: 0;
            animation: tk-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.1s forwards;
        }

        /* ── Card ────────────────────────────────────────────── */
        .tk-card {
            background: var(--tk-elevated);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 16px;
            transition: border-color 200ms ease;
        }

        .tk-card:hover {
            border-color: rgba(255,255,255,0.12);
        }

        .tk-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .tk-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--tk-text);
        }

        .tk-card-title svg {
            flex-shrink: 0;
        }

        .tk-card-desc {
            margin: 0 0 16px;
            font-size: 12.5px;
            color: var(--tk-muted);
            line-height: 1.6;
        }

        /* ── New token alert ─────────────────────────────────── */
        .tk-alert {
            background: rgba(255,101,0,0.06);
            border: 1px solid rgba(255,101,0,0.22);
            border-radius: 6px;
            padding: 20px 24px;
            margin-bottom: 16px;
            opacity: 0;
            animation: tk-fade-up 0.5s cubic-bezier(0.16,1,0.3,1) 0.05s forwards;
        }

        .tk-alert-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--tk-orange);
            margin-bottom: 10px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .tk-alert-label svg {
            flex-shrink: 0;
        }

        .tk-alert-code {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tk-code {
            flex: 1;
            background: var(--tk-bg);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 12px;
            color: var(--tk-orange);
            font-family: "JetBrains Mono", "Fira Code", monospace;
            word-break: break-all;
            overflow: hidden;
            min-width: 0;
        }

        .tk-btn-copy {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            font-family: "Inter", sans-serif;
            cursor: pointer;
            border: 1px solid rgba(255,101,0,0.25);
            background: rgba(255,101,0,0.08);
            color: var(--tk-orange);
            white-space: nowrap;
            transition: background 150ms, border-color 150ms, transform 150ms;
        }

        .tk-btn-copy:hover {
            background: rgba(255,101,0,0.14);
            border-color: rgba(255,101,0,0.4);
            transform: translateY(-1px);
        }

        .tk-btn-copy:active {
            transform: translateY(0);
        }

        .tk-btn-copy:focus-visible {
            outline: 2px solid var(--tk-orange);
            outline-offset: 2px;
        }

        .tk-alert-note {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            font-size: 11px;
            color: var(--tk-faint);
        }

        .tk-alert-note svg {
            flex-shrink: 0;
        }

        /* ── Code block ──────────────────────────────────────── */
        .tk-code-block {
            background: var(--tk-bg);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
            padding: 14px 16px;
            font-size: 12px;
            color: var(--tk-orange);
            font-family: "JetBrains Mono", "Fira Code", monospace;
            word-break: break-all;
            overflow-x: auto;
        }

        /* ── Badge preview ───────────────────────────────────── */
        .tk-badge-preview {
            margin-top: 14px;
            padding: 12px 16px;
            background: var(--tk-bg);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
        }

        .tk-badge-label {
            font-size: 11px;
            color: var(--tk-faint);
            margin-bottom: 8px;
        }

        .tk-badge-img {
            height: 20px;
            display: block;
        }

        /* ── Form ────────────────────────────────────────────── */
        .tk-form-row {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .tk-form-group {
            flex: 1;
            min-width: 0;
        }

        .tk-label {
            display: block;
            font-size: 12px;
            color: var(--tk-muted);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .tk-input {
            width: 100%;
            background: var(--tk-input);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--tk-text);
            font-family: "Inter", sans-serif;
            outline: none;
            box-sizing: border-box;
            transition: border-color 150ms ease;
        }

        .tk-input:focus {
            border-color: rgba(255,101,0,0.45);
            box-shadow: 0 0 0 3px rgba(255,101,0,0.08);
        }

        .tk-input::placeholder {
            color: var(--tk-faint);
        }

        .tk-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            font-family: "Inter", sans-serif;
            cursor: pointer;
            border: none;
            background: linear-gradient(135deg, var(--tk-orange), var(--tk-amber));
            color: #fff;
            white-space: nowrap;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        .tk-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(255,101,0,0.3);
        }

        .tk-btn-primary:active {
            transform: translateY(0);
        }

        .tk-btn-primary:focus-visible {
            outline: 2px solid var(--tk-orange);
            outline-offset: 2px;
        }

        .tk-btn-primary svg {
            flex-shrink: 0;
        }

        .tk-error {
            font-size: 11px;
            color: #f87171;
            margin-top: 4px;
        }

        /* ── Token list ──────────────────────────────────────── */
        .tk-token-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--tk-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tk-token-header-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--tk-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tk-token-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            background: rgba(255,101,0,0.12);
            border: 1px solid rgba(255,101,0,0.28);
            color: var(--tk-orange);
        }

        .tk-token-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--tk-border);
            transition: background 150ms ease;
        }

        .tk-token-row:last-child {
            border-bottom: none;
        }

        .tk-token-row:hover {
            background: rgba(255,255,255,0.02);
        }

        .tk-token-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--tk-text);
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tk-token-name svg {
            flex-shrink: 0;
            color: var(--tk-orange);
        }

        .tk-token-meta {
            font-size: 11px;
            color: var(--tk-faint);
        }

        .tk-token-meta .tk-dot {
            display: inline-block;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--tk-faint);
            margin: 0 5px;
            vertical-align: middle;
        }

        .tk-btn-revoke {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 500;
            font-family: "Inter", sans-serif;
            cursor: pointer;
            border: 1px solid rgba(239,68,68,0.2);
            background: rgba(239,68,68,0.06);
            color: #f87171;
            transition: background 150ms, border-color 150ms, transform 150ms;
        }

        .tk-btn-revoke:hover {
            background: rgba(239,68,68,0.12);
            border-color: rgba(239,68,68,0.35);
            transform: translateY(-1px);
        }

        .tk-btn-revoke:active {
            transform: translateY(0);
        }

        .tk-btn-revoke:focus-visible {
            outline: 2px solid #f87171;
            outline-offset: 2px;
        }

        .tk-btn-revoke svg {
            flex-shrink: 0;
        }

        /* ── Empty state ─────────────────────────────────────── */
        .tk-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .tk-empty-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 14px;
            border-radius: 12px;
            background: rgba(255,101,0,0.06);
            border: 1px solid rgba(255,101,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tk-orange);
        }

        .tk-empty-title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 600;
            color: var(--tk-text);
        }

        .tk-empty-desc {
            margin: 0;
            font-size: 12.5px;
            color: var(--tk-muted);
        }

        /* ── Endpoints ───────────────────────────────────────── */
        .tk-endpoint {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--tk-border);
        }

        .tk-endpoint:last-child {
            border-bottom: none;
        }

        .tk-method {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            font-family: "JetBrains Mono", monospace;
            letter-spacing: 0.03em;
            flex-shrink: 0;
        }

        .tk-method-get {
            background: rgba(34,197,94,0.10);
            border: 1px solid rgba(34,197,94,0.25);
            color: #4ade80;
        }

        .tk-method-post {
            background: rgba(59,130,246,0.10);
            border: 1px solid rgba(59,130,246,0.25);
            color: #60a5fa;
        }

        .tk-endpoint-path {
            font-size: 12px;
            color: var(--tk-muted);
            font-family: "JetBrains Mono", "Fira Code", monospace;
            word-break: break-all;
        }

        .tk-endpoint-desc {
            font-size: 11.5px;
            color: var(--tk-faint);
            margin-left: auto;
            white-space: nowrap;
        }

        /* ── Security note ───────────────────────────────────── */
        .tk-security {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: var(--tk-elevated);
            border: 1px solid var(--tk-border);
            border-radius: 6px;
            margin-top: 16px;
        }

        .tk-security-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #fbbf24;
        }

        .tk-security-text {
            font-size: 12.5px;
            color: var(--tk-muted);
            line-height: 1.6;
        }

        .tk-security-text strong {
            color: var(--tk-text);
            font-weight: 600;
        }

        /* ── Keyframes ───────────────────────────────────────── */
        @keyframes tk-fade-up {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Responsive ──────────────────────────────────────── */
        @media (max-width: 900px) {
            .tk-page { padding: 28px 20px 40px; }
            .tk-header { flex-direction: column; gap: 16px; }
            .tk-form-row { flex-direction: column; }
            .tk-btn-primary { align-self: flex-start; }
        }

        @media (max-width: 600px) {
            .tk-page { padding: 20px 16px 32px; }
            .tk-title { font-size: 26px; }
            .tk-alert-code { flex-direction: column; align-items: stretch; }
            .tk-endpoint { flex-wrap: wrap; }
            .tk-endpoint-desc { margin-left: 0; margin-top: 2px; width: 100%; }
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            .tk-header, .tk-separator, .tk-alert {
                animation: none;
                opacity: 1;
            }
            .tk-btn-copy, .tk-btn-primary, .tk-btn-revoke, .tk-input, .tk-card {
                transition: none;
            }
        }
    </style>

    <main class="tk-page">
        <div class="tk-inner">

            {{-- Header --}}
            <div class="tk-header">
                <div>
                    <div class="tk-eyebrow">Jetons API</div>
                    <h1 class="tk-title">Jetons API</h1>
                    <p class="tk-subtitle">
                        Génère un jeton pour exposer tes stats sur ton portfolio GitHub.
                    </p>
                </div>
                <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                    <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:11px;font-weight:600;background:rgba(255,101,0,0.08);border:1px solid rgba(255,101,0,0.22);color:var(--tk-orange);">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                        Sécurisé
                    </span>
                </div>
            </div>

            <div class="tk-separator"></div>

            {{-- New token displayed once --}}
            @if(session('new_token'))
                <div class="tk-alert">
                    <div class="tk-alert-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20,6 9,17 4,12"/></svg>
                        Nouveau jeton créé — copie-le maintenant
                    </div>
                    <div class="tk-alert-code">
                        <code class="tk-code">{{ session('new_token') }}</code>
                        <button type="button"
                                class="tk-btn-copy"
                                onclick="
                                    var btn = this;
                                    navigator.clipboard.writeText('{{ session('new_token') }}').then(function() {
                                        btn.innerHTML = '<svg width=12 height=12 viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><polyline points=\'20,6 9,17 4,12\'/></svg> Copié!';
                                        setTimeout(function() { btn.innerHTML = '<svg width=12 height=12 viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><rect x=\'9\' y=\'9\' width=\'13\' height=\'13\' rx=\'2\'/><path d=\'M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1\'/></svg> Copier'; }, 2000);
                                    });
                                ">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            Copier
                        </button>
                    </div>
                    <div class="tk-alert-note">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Ce jeton n'est affiché qu'une seule fois. Il ne sera plus visible après cette page.
                    </div>
                </div>
            @endif

            {{-- Badge usage example --}}
            <div class="tk-card">
                <div class="tk-card-header">
                    <h2 class="tk-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--tk-orange)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        Utilise ton badge sur GitHub
                    </h2>
                </div>
                <p class="tk-card-desc">
                    Colle cette ligne dans ton README pour afficher ton bilan TimeBank en temps réel :
                </p>
                <div style="display:flex;align-items:center;gap:8px;">
                    <code class="tk-code-block" style="flex:1;">![TimeBank]({{ url('/api/v1/users/' . (auth()->user()->github_username ?? auth()->user()->name) . '/badge.svg') }})</code>
                    <button type="button"
                            class="tk-btn-copy"
                            onclick="
                                var btn = this;
                                navigator.clipboard.writeText('![TimeBank]({{ url('/api/v1/users/' . (auth()->user()->github_username ?? auth()->user()->name) . '/badge.svg') }})').then(function() {
                                    btn.innerHTML = '<svg width=12 height=12 viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><polyline points=\'20,6 9,17 4,12\'/></svg> Copié!';
                                    setTimeout(function() { btn.innerHTML = '<svg width=12 height=12 viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><rect x=\'9\' y=\'9\' width=\'13\' height=\'13\' rx=\'2\'/><path d=\'M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1\'/></svg> Copier'; }, 2000);
                                });
                            ">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Copier
                    </button>
                </div>
                <div class="tk-badge-preview">
                    <div class="tk-badge-label">Aperçu du badge :</div>
                    <img src="{{ url('/api/v1/users/' . (auth()->user()->github_username ?? auth()->user()->name) . '/badge.svg') }}"
                         alt="TimeBank badge" class="tk-badge-img" />
                </div>
            </div>

            {{-- Create token form --}}
            <div class="tk-card">
                <div class="tk-card-header">
                    <h2 class="tk-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--tk-orange)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Créer un nouveau jeton
                    </h2>
                </div>
                <form method="POST" action="{{ route('api-tokens.store') }}">
                    @csrf
                    <div class="tk-form-row">
                        <div class="tk-form-group">
                            <label for="token-name" class="tk-label">Nom du jeton</label>
                            <input type="text"
                                   id="token-name"
                                   name="name"
                                   value="{{ old('name', 'portfolio') }}"
                                   placeholder="portfolio, github-readme, etc."
                                   class="tk-input"
                                   required />
                            @error('name')
                                <p class="tk-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="tk-btn-primary">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Générer
                        </button>
                    </div>
                </form>
            </div>

            {{-- Existing tokens --}}
            <div class="tk-card" style="padding:0;overflow:hidden;">
                @if($tokens->count() > 0)
                    <div class="tk-token-header">
                        <span class="tk-token-header-title">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--tk-orange)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                            Jetons actifs
                            <span class="tk-token-count">{{ $tokens->count() }}</span>
                        </span>
                    </div>
                    @foreach($tokens as $token)
                        <div class="tk-token-row">
                            <div style="min-width:0;">
                                <div class="tk-token-name">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                                    {{ $token->name }}
                                </div>
                                <div class="tk-token-meta">
                                    Créé {{ $token->created_at->diffForHumans() }}
                                    <span class="tk-dot"></span>
                                    @if($token->last_used_at)
                                        Dernière utilisation {{ $token->last_used_at->diffForHumans() }}
                                    @else
                                        Jamais utilisé
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('api-tokens.destroy', $token->id) }}"
                                  onsubmit="return confirm('Révoquer ce jeton ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="tk-btn-revoke">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3,6 5,6 21,6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    Révoquer
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <div class="tk-empty">
                        <div class="tk-empty-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                        </div>
                        <h3 class="tk-empty-title">Aucun jeton actif</h3>
                        <p class="tk-empty-desc">Génère un jeton pour exposer tes stats publiquement.</p>
                    </div>
                @endif
            </div>

            {{-- API endpoints reference --}}
            <div class="tk-card">
                <div class="tk-card-header">
                    <h2 class="tk-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--tk-orange)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        Endpoints publics disponibles
                    </h2>
                </div>
                @foreach([
                    ['GET', '/api/v1/users/{username}',           'Profil public'],
                    ['GET', '/api/v1/users/{username}/stats',     'Stats complètes'],
                    ['GET', '/api/v1/users/{username}/badge.svg', 'Badge SVG dynamique'],
                    ['GET', '/api/v1/me/balance',                 'Solde actuel (token requis)'],
                    ['GET', '/api/v1/me/transactions',            'Historique (token requis)'],
                ] as [$method, $endpoint, $desc])
                    <div class="tk-endpoint">
                        <span class="tk-method tk-method-{{ strtolower($method) }}">{{ $method }}</span>
                        <code class="tk-endpoint-path">{{ $endpoint }}</code>
                        <span class="tk-endpoint-desc">{{ $desc }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Security guidance --}}
            <div class="tk-security">
                <div class="tk-security-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="tk-security-text">
                    <strong>Conserve tes jetons en sécurité.</strong>
                    Un jeton API donne accès à tes données TimeBank (solde, transactions).
                    Ne le partage jamais publiquement. Si un jeton est compromis, révoque-le
                    immédiatement et crée-en un nouveau.
                </div>
            </div>

        </div>
    </main>

</x-app-layout>
