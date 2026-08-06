<x-app-layout>

<div style="max-width:680px;">

    <div style="margin-bottom:24px;">
        <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;display:flex;align-items:center;gap:6px;">
            <span style="color:#444;">—</span> JETONS API
        </div>
        <h1 style="font-size:24px;font-weight:600;color:#fff;letter-spacing:-0.4px;">Jetons API</h1>
        <p style="font-size:13px;color:#555;margin-top:4px;">
            Génère un jeton pour exposer tes stats sur ton portfolio GitHub.
        </p>
    </div>

    {{-- New token displayed once --}}
    @if(session('new_token'))
        <div style="background:rgba(173,255,47,0.06);border:1px solid rgba(173,255,47,0.2);border-radius:12px;padding:20px 24px;margin-bottom:20px;">
            <div style="font-size:12px;font-weight:600;color:#ADFF2F;margin-bottom:8px;letter-spacing:0.06em;text-transform:uppercase;">
                ✓ Nouveau jeton créé — copie-le maintenant
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <code style="flex:1;background:#0a0a0a;border:1px solid #2a2a2a;border-radius:8px;padding:10px 14px;font-size:12px;color:#ADFF2F;font-family:'JetBrains Mono','Fira Code',monospace;word-break:break-all;overflow:hidden;">
                    {{ session('new_token') }}
                </code>
                <button onclick="navigator.clipboard.writeText('{{ session('new_token') }}').then(()=>this.textContent='Copié!')"
                        style="background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);color:#ADFF2F;padding:10px 14px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;font-family:'Inter',sans-serif;">
                    Copier
                </button>
            </div>
            <p style="font-size:11px;color:#666;margin-top:8px;">
                ⚠️ Ce jeton n'est affiché qu'une seule fois. Il ne sera plus visible après cette page.
            </p>
        </div>
    @endif

    {{-- Badge usage example --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-bottom:20px;">
        <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:10px;">Utilise ton badge sur GitHub</div>
        <p style="font-size:12px;color:#666;margin-bottom:10px;line-height:1.65;">
            Colle cette ligne dans ton GitHub README pour afficher ton bilan TimeBank en temps réel :
        </p>
        <code style="display:block;background:#0a0a0a;border:1px solid #1f1f1f;border-radius:8px;padding:12px 14px;font-size:12px;color:#ADFF2F;font-family:'JetBrains Mono','Fira Code',monospace;word-break:break-all;">
            ![TimeBank]({{ url('/api/v1/users/' . (auth()->user()->github_username ?? auth()->user()->name) . '/badge.svg') }})
        </code>
        <div style="margin-top:12px;padding:10px 14px;background:#0a0a0a;border:1px solid #1f1f1f;border-radius:8px;">
            <div style="font-size:11px;color:#555;margin-bottom:6px;">Aperçu du badge :</div>
            <img src="{{ url('/api/v1/users/' . (auth()->user()->github_username ?? auth()->user()->name) . '/badge.svg') }}"
                 alt="TimeBank badge" style="height:20px;" />
        </div>
    </div>

    {{-- Create token form --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-bottom:20px;">
        <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:14px;">Créer un nouveau jeton</div>
        <form method="POST" action="{{ route('api-tokens.store') }}">
            @csrf
            <div style="display:flex;gap:10px;align-items:flex-end;">
                <div style="flex:1;">
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Nom du jeton</label>
                    <input type="text" name="name" value="{{ old('name', 'portfolio') }}"
                           placeholder="portfolio, github-readme, etc."
                           style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                           onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                           onblur="this.style.borderColor='#1f1f1f'" />
                    @error('name')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <button type="submit"
                        style="background:#ADFF2F;color:#000;font-weight:700;font-size:13px;padding:10px 18px;border-radius:8px;border:none;cursor:pointer;white-space:nowrap;">
                    + Générer
                </button>
            </div>
        </form>
    </div>

    {{-- Existing tokens --}}
    @if($tokens->count() > 0)
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;overflow:hidden;">
            <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
                <span style="font-size:13px;font-weight:600;color:#fff;">Jetons actifs ({{ $tokens->count() }})</span>
            </div>
            @foreach($tokens as $token)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #1a1a1a;">
                    <div>
                        <div style="font-size:13px;color:#fff;font-weight:500;margin-bottom:3px;">
                            {{ $token->name }}
                        </div>
                        <div style="font-size:11px;color:#555;">
                            Créé {{ $token->created_at->diffForHumans() }}
                            @if($token->last_used_at)
                                · Dernière utilisation {{ $token->last_used_at->diffForHumans() }}
                            @else
                                · Jamais utilisé
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('api-tokens.destroy', $token->id) }}"
                          onsubmit="return confirm('Révoquer ce jeton ?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;font-size:12px;padding:6px 12px;border-radius:8px;cursor:pointer;font-family:'Inter',sans-serif;">
                            Révoquer
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:32px;text-align:center;">
            <div style="font-size:28px;margin-bottom:10px;">🔑</div>
            <div style="font-size:14px;color:#fff;font-weight:500;margin-bottom:6px;">Aucun jeton actif</div>
            <div style="font-size:12px;color:#555;">Génère un jeton pour exposer tes stats publiquement.</div>
        </div>
    @endif

    {{-- API endpoints reference --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-top:20px;">
        <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:12px;">Endpoints publics disponibles</div>
        @foreach([
            ['GET', '/api/v1/users/{username}',           'Profil public'],
            ['GET', '/api/v1/users/{username}/stats',     'Stats complètes'],
            ['GET', '/api/v1/users/{username}/badge.svg', 'Badge SVG dynamique'],
            ['GET', '/api/v1/me/balance',                 'Solde actuel (token requis)'],
            ['GET', '/api/v1/me/transactions',            'Historique (token requis)'],
        ] as [$method, $endpoint, $desc])
            <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #1a1a1a;">
                <span style="font-size:10px;font-weight:700;padding:2px 6px;border-radius:4px;font-family:'JetBrains Mono',monospace;
                    {{ $method === 'GET' ? 'background:rgba(34,197,94,0.1);color:#4ade80;' : 'background:rgba(59,130,246,0.1);color:#60a5fa;' }}">
                    {{ $method }}
                </span>
                <code style="font-size:11px;color:#888;font-family:'JetBrains Mono','Fira Code',monospace;">
                    {{ $endpoint }}
                </code>
                <span style="font-size:11px;color:#444;margin-left:auto;">{{ $desc }}</span>
            </div>
        @endforeach
    </div>

</div>

</x-app-layout>