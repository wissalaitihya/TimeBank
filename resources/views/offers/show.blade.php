<x-app-layout>

<div style="max-width:720px;">

    {{-- Header --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('offers.index') }}" style="font-size:12px;color:#555;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:14px;"
           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#555'">
            ← Mes offres
        </a>
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
                    <span style="padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.25);color:#ADFF2F;">
                        {{ $serviceOffer->skill->nom }}
                    </span>
                    <span style="font-size:12px;color:#555;">
                        {{ number_format($serviceOffer->duree_estimee, 2) }}h estimée
                    </span>
                </div>
                <h1 style="font-size:22px;font-weight:600;color:#fff;margin-bottom:6px;">
                    {{ $serviceOffer->titre }}
                </h1>
                <p style="font-size:13px;color:#555;">
                    Publiée {{ $serviceOffer->created_at->diffForHumans() }}
                    @if($serviceOffer->user_id === auth()->id()) · <span style="color:#ADFF2F;">Votre offre</span> @endif
                </p>
            </div>
            @can('update', $serviceOffer)
                <a href="{{ route('offers.edit', $serviceOffer) }}"
                   style="flex-shrink:0;display:inline-flex;align-items:center;gap:6px;background:#111;border:1px solid #1f1f1f;color:#888;font-size:12px;padding:8px 14px;border-radius:8px;text-decoration:none;">
                    Modifier
                </a>
            @endcan
        </div>
    </div>

    {{-- Description --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:22px 24px;margin-bottom:14px;">
        <div style="font-size:12px;font-weight:600;color:#555;margin-bottom:10px;letter-spacing:0.06em;text-transform:uppercase;">Description</div>
        <p style="font-size:14px;color:#ccc;line-height:1.75;">{{ $serviceOffer->description }}</p>
    </div>

    {{-- Offerer info --}}
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-bottom:14px;">
        <div style="font-size:12px;font-weight:600;color:#555;margin-bottom:12px;letter-spacing:0.06em;text-transform:uppercase;">Proposé par</div>
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:38px;height:38px;border-radius:50%;background:rgba(173,255,47,0.12);border:1px solid rgba(173,255,47,0.2);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#ADFF2F;">
                {{ strtoupper(substr($serviceOffer->user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:14px;font-weight:500;color:#fff;">{{ $serviceOffer->user->name }}</div>
                <div style="font-size:12px;color:#555;margin-top:2px;">
                    ⭐ {{ number_format($serviceOffer->user->score_reputation / 20, 1) }}/5 ·
                    {{ ucfirst($serviceOffer->user->niveau ?? 'Développeur') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Propose match --}}
    @if($serviceOffer->user_id !== auth()->id() && $serviceOffer->statut === 'active')
        <div style="background:rgba(173,255,47,0.05);border:1px solid rgba(173,255,47,0.15);border-radius:12px;padding:20px 24px;">
            <div style="font-size:14px;font-weight:600;color:#fff;margin-bottom:6px;">Proposer un match</div>
            <p style="font-size:13px;color:#666;margin-bottom:16px;">Cette offre correspond à ton besoin ? Propose un échange.</p>
            <a href="{{ route('requests.create') }}?offer_id={{ $serviceOffer->id }}"
               style="display:inline-flex;background:#ADFF2F;color:#000;font-weight:700;font-size:13px;padding:10px 20px;border-radius:8px;text-decoration:none;">
                Proposer un match →
            </a>
        </div>
    @endif

</div>

</x-app-layout>