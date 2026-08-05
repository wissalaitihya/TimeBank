<x-app-layout>

<div style="max-width:720px;">

    <a href="{{ route('requests.index') }}" style="font-size:12px;color:#555;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;"
       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#555'">
        ← Mes demandes
    </a>

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
                <span style="
                    padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;
                    {{ $serviceRequest->urgence === 'high'
                        ? 'background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171;'
                        : ($serviceRequest->urgence === 'normal'
                            ? 'background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);color:#fbbf24;'
                            : 'background:rgba(255,255,255,0.04);border:1px solid #1f1f1f;color:#666;') }}
                ">
                    {{ $serviceRequest->urgence === 'high' ? 'Élevée' : ($serviceRequest->urgence === 'normal' ? 'Normale' : 'Faible') }}
                </span>
                <span style="padding:3px 10px;border-radius:20px;font-size:10px;background:rgba(255,255,255,0.04);border:1px solid #1f1f1f;color:#666;">
                    {{ $serviceRequest->skill->nom }}
                </span>
                <span style="font-size:12px;color:#555;">
                    {{ number_format($serviceRequest->duree_estimee, 2) }}h estimée
                </span>
            </div>
            <h1 style="font-size:22px;font-weight:600;color:#fff;margin-bottom:6px;">
                {{ $serviceRequest->titre }}
            </h1>
            <p style="font-size:12px;color:#555;">
                Publiée {{ $serviceRequest->created_at->diffForHumans() }}
            </p>
        </div>
        @can('update', $serviceRequest)
            <a href="{{ route('requests.edit', $serviceRequest) }}"
               style="flex-shrink:0;display:inline-flex;align-items:center;gap:6px;background:#111;border:1px solid #1f1f1f;color:#888;font-size:12px;padding:8px 14px;border-radius:8px;text-decoration:none;">
                Modifier
            </a>
        @endcan
    </div>

    {{-- Description --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:22px 24px;margin-bottom:14px;">
        <div style="font-size:11px;font-weight:600;color:#555;margin-bottom:10px;letter-spacing:0.08em;text-transform:uppercase;">Description</div>
        <p style="font-size:14px;color:#ccc;line-height:1.75;white-space:pre-wrap;">{{ $serviceRequest->description }}</p>

        @if($serviceRequest->ai_status === 'done' && $serviceRequest->description_originale !== $serviceRequest->description)
            <div style="margin-top:14px;padding-top:14px;border-top:1px solid #1a1a1a;">
                <div style="font-size:10px;color:#ADFF2F;margin-bottom:6px;letter-spacing:0.08em;text-transform:uppercase;">✨ Améliorée par l'IA</div>
                <details>
                    <summary style="font-size:12px;color:#555;cursor:pointer;">Voir la description originale</summary>
                    <p style="font-size:13px;color:#555;line-height:1.65;margin-top:8px;">{{ $serviceRequest->description_originale }}</p>
                </details>
            </div>
        @endif
    </div>

    {{-- Propose match (for other users) --}}
    @if($serviceRequest->user_id !== auth()->id() && $serviceRequest->statut === 'open')
        <div style="background:rgba(173,255,47,0.05);border:1px solid rgba(173,255,47,0.15);border-radius:12px;padding:20px 24px;margin-bottom:14px;">
            <div style="font-size:14px;font-weight:600;color:#fff;margin-bottom:6px;">Tu peux aider ?</div>
            <p style="font-size:13px;color:#666;margin-bottom:16px;">Propose ton aide — la session sera confirmée mutuellement.</p>
            <form method="POST" action="{{ route('matches.store') }}">
                @csrf
                <input type="hidden" name="request_id" value="{{ $serviceRequest->id }}" />
                <div style="margin-bottom:12px;">
                    <select name="offer_id"
                            style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;cursor:pointer;margin-bottom:10px;">
                        <option value="">Choisir mon offre...</option>
                        @foreach(auth()->user()->serviceOffers()->where('statut','active')->get() as $offer)
                            <option value="{{ $offer->id }}">{{ $offer->titre }}</option>
                        @endforeach
                    </select>
                    <textarea name="message" rows="2" placeholder="Message optionnel..."
                              style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;font-family:'Inter',sans-serif;outline:none;resize:none;box-sizing:border-box;"></textarea>
                </div>
                <button type="submit" style="background:#ADFF2F;color:#000;font-weight:700;font-size:13px;padding:10px 20px;border-radius:8px;border:none;cursor:pointer;">
                    Proposer mon aide →
                </button>
            </form>
        </div>
    @endif

    {{-- Existing matches --}}
    @if($serviceRequest->matches->count() > 0 && $serviceRequest->user_id === auth()->id())
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;">
            <div style="font-size:13px;font-weight:600;color:#fff;margin-bottom:14px;">
                Propositions reçues ({{ $serviceRequest->matches->count() }})
            </div>
            @foreach($serviceRequest->matches as $match)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #1a1a1a;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#ADFF2F;">
                            {{ strtoupper(substr($match->helper->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:500;color:#fff;">{{ $match->helper->name }}</div>
                            <div style="font-size:11px;color:#555;">⭐ {{ number_format($match->helper->score_reputation / 20, 1) }}/5</div>
                        </div>
                    </div>
                    <a href="{{ route('matches.show', $match) }}"
                       style="padding:6px 14px;border-radius:8px;font-size:12px;background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);color:#ADFF2F;text-decoration:none;">
                        Voir →
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</div>

</x-app-layout>