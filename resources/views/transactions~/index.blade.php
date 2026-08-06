<x-app-layout>

<div style="margin-bottom:24px;">
    <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;display:flex;align-items:center;gap:6px;">
        <span style="color:#444;">—</span> TRANSACTIONS
    </div>
    <h1 style="font-size:24px;font-weight:600;color:#fff;letter-spacing:-0.4px;">
        Historique des transactions
    </h1>
</div>

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 20px;">
        <div style="font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:#555;margin-bottom:8px;">Total crédité</div>
        <div style="font-size:24px;font-weight:700;color:#ADFF2F;letter-spacing:-0.5px;">
            +{{ number_format($stats['total_credit'], 2) }}h
        </div>
    </div>
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 20px;">
        <div style="font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:#555;margin-bottom:8px;">Total débité</div>
        <div style="font-size:24px;font-weight:700;color:#f87171;letter-spacing:-0.5px;">
            -{{ number_format($stats['total_debit'], 2) }}h
        </div>
    </div>
    <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 20px;">
        <div style="font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:#555;margin-bottom:8px;">Transactions totales</div>
        <div style="font-size:24px;font-weight:700;color:#fff;letter-spacing:-0.5px;">
            {{ $stats['total_tx'] }}
        </div>
    </div>
</div>

{{-- Transaction list --}}
<div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;overflow:hidden;">

    {{-- Table header --}}
    <div style="display:grid;grid-template-columns:1fr 3fr 120px;padding:10px 20px;border-bottom:1px solid #1a1a1a;">
        <div style="font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-weight:600;">Date</div>
        <div style="font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-weight:600;">Description</div>
        <div style="font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-weight:600;text-align:right;">Montant</div>
    </div>

    @forelse($transactions as $tx)
        @php $isCredit = in_array($tx->type, ['credit', 'bonus']); @endphp
        <div style="display:grid;grid-template-columns:1fr 3fr 120px;padding:14px 20px;border-bottom:1px solid #1a1a1a;align-items:center;"
             onmouseover="this.style.background='rgba(255,255,255,0.01)'"
             onmouseout="this.style.background='transparent'">

            {{-- Date --}}
            <div>
                <div style="font-size:12.5px;color:#ccc;">{{ $tx->created_at->format('d/m/Y') }}</div>
                <div style="font-size:11px;color:#444;margin-top:1px;">{{ $tx->created_at->format('H:i') }}</div>
            </div>

            {{-- Description --}}
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;
                    {{ $isCredit
                        ? 'background:rgba(173,255,47,0.1);border:1px solid rgba(173,255,47,0.2);color:#ADFF2F;'
                        : 'background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;' }}">
                    {{ $isCredit ? '+' : '−' }}
                </div>
                <div style="min-width:0;">
                    <div style="font-size:13px;color:#ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $tx->description }}
                    </div>
                    <div style="font-size:11px;color:#444;margin-top:1px;display:flex;align-items:center;gap:6px;">
                        <span style="padding:1px 6px;border-radius:20px;font-size:10px;
                            {{ $tx->type === 'credit' ? 'background:rgba(173,255,47,0.06);color:#6aaa1f;'
                            : ($tx->type === 'debit'  ? 'background:rgba(239,68,68,0.06);color:#c05050;'
                            : ($tx->type === 'bonus'  ? 'background:rgba(59,130,246,0.06);color:#5090c0;'
                            :                           'background:rgba(245,158,11,0.06);color:#c09030;')) }}">
                            {{ match($tx->type) {
                                'credit' => 'Crédit',
                                'debit'  => 'Débit',
                                'bonus'  => 'Bonus',
                                'refund' => 'Remboursement',
                                default  => $tx->type,
                            } }}
                        </span>
                        @if($tx->match?->offer?->skill)
                            <span style="color:#444;">· {{ $tx->match->offer->skill->nom }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Amount --}}
            <div style="text-align:right;font-size:15px;font-weight:700;color:{{ $isCredit ? '#ADFF2F' : '#f87171' }};">
                {{ $isCredit ? '+' : '−' }}{{ number_format($tx->heures, 2) }}h
            </div>
        </div>
    @empty
        <div style="padding:48px;text-align:center;">
            <div style="font-size:32px;margin-bottom:12px;">📒</div>
            <div style="font-size:15px;color:#fff;font-weight:500;margin-bottom:6px;">Aucune transaction</div>
            <div style="font-size:13px;color:#555;">Tes échanges d'heures apparaîtront ici.</div>
        </div>
    @endforelse

</div>

<div style="margin-top:16px;">{{ $transactions->links() }}</div>

</x-app-layout>