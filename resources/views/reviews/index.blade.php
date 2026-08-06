<x-app-layout>

<div style="margin-bottom:24px;">
    <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;display:flex;align-items:center;gap:6px;">
        <span style="color:#444;">—</span> AVIS
    </div>
    <div style="display:flex;align-items:flex-end;gap:16px;flex-wrap:wrap;">
        <h1 style="font-size:24px;font-weight:600;color:#fff;letter-spacing:-0.4px;">Mes avis</h1>
        @if($avgNote)
            <div style="display:flex;align-items:center;gap:8px;padding-bottom:2px;">
                <span style="color:#ADFF2F;font-size:18px;">
                    @for($i = 1; $i <= 5; $i++) {{ $i <= round($avgNote) ? '★' : '☆' }} @endfor
                </span>
                <span style="font-size:14px;color:#888;">
                    {{ number_format($avgNote, 1) }}/5 · {{ $reviewsReceived->count() }} avis
                </span>
            </div>
        @endif
    </div>
</div>

{{-- Tabs --}}
<div style="display:flex;gap:4px;margin-bottom:20px;border-bottom:1px solid #1f1f1f;padding-bottom:0;">
    <button onclick="showTab('received')"
            id="tab-received"
            style="padding:8px 16px;background:none;border:none;border-bottom:2px solid #ADFF2F;color:#ADFF2F;font-size:13px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;">
        Reçus ({{ $reviewsReceived->count() }})
    </button>
    <button onclick="showTab('given')"
            id="tab-given"
            style="padding:8px 16px;background:none;border:none;border-bottom:2px solid transparent;color:#555;font-size:13px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;">
        Donnés ({{ $reviewsGiven->count() }})
    </button>
</div>

{{-- Received --}}
<div id="panel-received">
    @forelse($reviewsReceived as $review)
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 22px;margin-bottom:10px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:10px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:50%;background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#ADFF2F;">
                        {{ strtoupper(substr($review->reviewer->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:500;color:#fff;">{{ $review->reviewer->name }}</div>
                        <div style="font-size:11px;color:#555;">{{ $review->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div style="color:#ADFF2F;font-size:16px;letter-spacing:2px;">
                    @for($i = 1; $i <= 5; $i++) {{ $i <= $review->note ? '★' : '☆' }} @endfor
                </div>
            </div>
            @if($review->commentaire)
                <p style="font-size:13px;color:#ccc;line-height:1.65;margin-bottom:10px;">
                    "{{ $review->commentaire }}"
                </p>
            @endif
            @if($review->tags && count($review->tags) > 0)
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @foreach($review->tags as $tag)
                        <span style="padding:3px 10px;border-radius:20px;font-size:10px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;background:rgba(173,255,47,0.08);border:1px solid rgba(173,255,47,0.2);color:#ADFF2F;">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif
            @if($review->match?->offer?->skill)
                <div style="margin-top:10px;font-size:11px;color:#444;">
                    Session · {{ $review->match->offer->skill->nom }}
                </div>
            @endif
        </div>
    @empty
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:48px;text-align:center;">
            <div style="font-size:32px;margin-bottom:12px;">⭐</div>
            <div style="font-size:15px;color:#fff;font-weight:500;margin-bottom:6px;">Aucun avis reçu</div>
            <div style="font-size:13px;color:#555;">Complète des sessions pour recevoir tes premiers avis.</div>
        </div>
    @endforelse
</div>

{{-- Given --}}
<div id="panel-given" style="display:none;">
    @forelse($reviewsGiven as $review)
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 22px;margin-bottom:10px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:10px;flex-wrap:wrap;gap:10px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.04);border:1px solid #1f1f1f;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#888;">
                        {{ strtoupper(substr($review->reviewed->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:13px;font-weight:500;color:#fff;">{{ $review->reviewed->name }}</div>
                        <div style="font-size:11px;color:#555;">{{ $review->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div style="color:#ADFF2F;font-size:16px;letter-spacing:2px;">
                    @for($i = 1; $i <= 5; $i++) {{ $i <= $review->note ? '★' : '☆' }} @endfor
                </div>
            </div>
            @if($review->commentaire)
                <p style="font-size:13px;color:#ccc;line-height:1.65;">"{{ $review->commentaire }}"</p>
            @endif
        </div>
    @empty
        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:48px;text-align:center;">
            <div style="font-size:32px;margin-bottom:12px;">✍️</div>
            <div style="font-size:15px;color:#fff;font-weight:500;margin-bottom:6px;">Aucun avis donné</div>
            <div style="font-size:13px;color:#555;">Après chaque session terminée, laisse un avis à ton partenaire.</div>
        </div>
    @endforelse
</div>

<script>
function showTab(tab) {
    document.getElementById('panel-received').style.display = tab === 'received' ? 'block' : 'none';
    document.getElementById('panel-given').style.display    = tab === 'given'    ? 'block' : 'none';
    document.getElementById('tab-received').style.color          = tab === 'received' ? '#ADFF2F' : '#555';
    document.getElementById('tab-received').style.borderBottomColor = tab === 'received' ? '#ADFF2F' : 'transparent';
    document.getElementById('tab-given').style.color             = tab === 'given'    ? '#ADFF2F' : '#555';
    document.getElementById('tab-given').style.borderBottomColor    = tab === 'given'    ? '#ADFF2F' : 'transparent';
}
</script>

</x-app-layout>