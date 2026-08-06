<x-app-layout>

<div style="max-width:680px;">

    <a href="{{ route('matches.show', $dispute->match) }}" style="font-size:12px;color:#555;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;"
       onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#555'">
        ← Retour au match
    </a>

    <div style="margin-bottom:20px;">
        <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;">— LITIGE</div>
        <h1 style="font-size:22px;font-weight:600;color:#fff;">Litige en cours</h1>
    </div>

    <div style="background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.2);border-radius:12px;padding:22px 24px;margin-bottom:16px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
            <span style="padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;
                {{ $dispute->status === 'open'
                    ? 'background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#f87171;'
                    : 'background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.25);color:#ADFF2F;' }}">
                {{ $dispute->status === 'open' ? 'OUVERT' : 'RÉSOLU' }}
            </span>
            <span style="font-size:12px;color:#555;">
                Ouvert {{ $dispute->opened_at?->diffForHumans() ?? $dispute->created_at->diffForHumans() }}
            </span>
        </div>

        <div style="font-size:15px;font-weight:600;color:#fff;margin-bottom:8px;">
            {{ $dispute->reason }}
        </div>

        @if($dispute->description)
            <p style="font-size:13px;color:#999;line-height:1.65;">{{ $dispute->description }}</p>
        @endif
    </div>

    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-bottom:16px;">
        <div style="font-size:12px;font-weight:600;color:#555;margin-bottom:12px;letter-spacing:0.06em;text-transform:uppercase;">Ouvert par</div>
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:50%;background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#ADFF2F;">
                {{ strtoupper(substr($dispute->openedBy->name, 0, 1)) }}
            </div>
            <span style="font-size:13px;color:#fff;">{{ $dispute->openedBy->name }}</span>
        </div>
    </div>

    @if($dispute->admin_decision)
        <div style="background:rgba(173,255,47,0.05);border:1px solid rgba(173,255,47,0.15);border-radius:12px;padding:20px 24px;">
            <div style="font-size:12px;font-weight:600;color:#ADFF2F;margin-bottom:8px;letter-spacing:0.06em;text-transform:uppercase;">Décision de l'administrateur</div>
            <p style="font-size:13px;color:#ccc;line-height:1.65;">{{ $dispute->admin_decision }}</p>
            @if($dispute->approved_duration)
                <div style="margin-top:10px;font-size:14px;font-weight:700;color:#ADFF2F;">
                    Durée approuvée : {{ number_format($dispute->approved_duration, 2) }}h
                </div>
            @endif
        </div>
    @else
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;text-align:center;">
            <div style="font-size:24px;margin-bottom:10px;">⏳</div>
            <div style="font-size:14px;color:#fff;font-weight:500;margin-bottom:4px;">En attente d'arbitrage</div>
            <div style="font-size:12px;color:#555;">Un administrateur va examiner votre litige sous 24-48h.</div>
        </div>
    @endif

</div>

</x-app-layout>