<x-dashboard-layout>

    {{-- Welcome --}}
    <div>
        <div class="dash-eyebrow" style="display:flex;align-items:center;gap:8px;">
            <span style="width:14px;height:1px;background:#ADFF2F;display:inline-block;"></span>
            {{ strtoupper(now()->locale('fr')->translatedFormat('l d F Y')) }}
        </div>
        <h1 class="dash-h1" style="font-size:38px;line-height:1.12;margin:10px 0 6px;">
            Bonjour, <em>{{ explode(' ', $user->name)[0] }}</em>.
        </h1>
        <p style="font-size:13px;color:#6B6F64;margin:0;">
            Voici ton tableau de bord TimeBank.
        </p>
    </div>

    {{-- Balance + Réputation --}}
    <div class="dash-grid-balance" style="margin-top:22px;">

        <section class="dash-card" style="padding:18px 18px 14px;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">
                <div>
                    <div class="dash-eyebrow" style="margin-bottom:9px;">Solde de temps</div>
                    <div style="display:flex;align-items:baseline;gap:7px;">
                        <span class="dash-value" style="font-size:40px;line-height:1;">{{ number_format($user->solde_heures, 2) }}</span>
                        <span class="dash-serif" style="font-size:18px;color:#ADFF2F;opacity:.65;">h</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:11px;flex-wrap:wrap;">
                        @if($user->isGele())
                            <span class="dash-pill dash-pill-red">
                                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Compte gelé
                            </span>
                        @elseif($user->isSoldeWarning())
                            <span class="dash-pill dash-pill-amber">
                                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                Solde bas
                            </span>
                        @else
                            <span class="dash-pill dash-pill-lime">
                                <span style="width:5px;height:5px;border-radius:50%;background:#ADFF2F;display:inline-block;"></span>
                                Actif
                            </span>
                        @endif
                        @php
                            $lastTx = $recentTransactions->first();
                        @endphp
                        <span style="display:inline-flex;align-items:center;gap:5px;font-size:10.5px;color:#565B51;">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15.5 14"/></svg>
                            {{ $lastTx ? 'Dernière activité : ' . $lastTx->created_at->format('d/m/Y') : 'Aucune activité récente' }}
                        </span>
                    </div>
                </div>
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#3A4035" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:2px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <div style="border-top:1px solid #171A15;margin-top:14px;padding-top:12px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                    <span style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#6B6F64;font-weight:600;">30 derniers jours</span>
                    <span style="font-size:10px;color:#565B51;">Aucune variation</span>
                </div>
                <svg viewBox="0 0 340 56" preserveAspectRatio="none" style="width:100%;height:52px;display:block;">
                    <line x1="0" y1="14" x2="340" y2="14" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                    <line x1="0" y1="28" x2="340" y2="28" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                    <line x1="0" y1="42" x2="340" y2="42" stroke="rgba(255,255,255,0.045)" stroke-width="1"/>
                    <polyline points="0,51 340,51" fill="none" stroke="rgba(173,255,47,0.45)" stroke-width="1.5"/>
                    <circle cx="340" cy="51" r="2.5" fill="#ADFF2F"/>
                </svg>
            </div>
        </section>

        <section class="dash-card" style="padding:18px;">
            <div class="dash-eyebrow" style="margin-bottom:9px;">Réputation</div>
            <div style="display:flex;align-items:baseline;gap:6px;">
                <span class="dash-serif" style="font-size:34px;font-weight:700;color:#fff;line-height:1;">{{ $user->score_reputation }}</span>
                <span style="font-size:12px;color:#565B51;">/100</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-top:9px;">
                @php
                    $stars = (int) round($user->score_reputation / 20);
                @endphp
                <div style="display:flex;gap:2px;align-items:center;">
                    @for($i = 0; $i < 5; $i++)
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="{{ $i < $stars ? '#ADFF2F' : 'none' }}" stroke="{{ $i < $stars ? '#ADFF2F' : '#3A4035' }}" stroke-width="1.6" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>
                <span style="font-size:11px;color:#6B6F64;">{{ $stats['reviews_recues'] }} avis reçu{{ $stats['reviews_recues'] > 1 ? 's' : '' }}</span>
            </div>
            <div style="border-top:1px solid #1E2417;margin-top:14px;padding-top:12px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <span style="font-size:10px;letter-spacing:.12em;text-transform:uppercase;color:#6B6F64;font-weight:600;">Compétences</span>
                    <a href="{{ route('profile.show') }}" style="font-size:10.5px;color:#6B6F64;text-decoration:none;">Gérer →</a>
                </div>
                @if($user->skills->count() > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach($user->skills as $skill)
                            <span class="dash-chip {{ $skill->pivot->niveau === 'expert' ? 'dash-chip-lime' : ($skill->pivot->niveau === 'intermediaire' ? 'dash-chip-blue' : 'dash-chip-gray') }}">
                                {{ $skill->nom }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p style="font-size:11.5px;color:#565B51;margin:0;">Aucune compétence ajoutée.</p>
                @endif
            </div>
        </section>

    </div>

    {{-- Aperçu des états du ledger --}}
    <div style="margin-top:16px;">
        <div class="dash-eyebrow" style="margin-bottom:9px;">Aperçu des états du ledger</div>
        <div class="dash-grid-ledger">

            <div class="dash-ledger" style="border-color:{{ $user->isSoldeWarning() ? 'rgba(245,158,11,.45)' : 'rgba(245,158,11,.28)' }};{{ $user->isSoldeWarning() ? 'box-shadow:0 0 24px rgba(245,158,11,.08);' : '' }}">
                <span style="width:30px;height:30px;border-radius:8px;background:rgba(245,158,11,.10);border:1px solid rgba(245,158,11,.28);color:#fbbf24;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </span>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                        <span style="font-size:12.5px;font-weight:600;color:#fff;">Solde bas</span>
                        <span class="dash-badge {{ $user->isSoldeWarning() ? 'dash-badge-amber' : 'dash-badge-muted' }}">{{ $user->isSoldeWarning() ? 'Ton état actuel' : 'État possible' }}</span>
                    </div>
                    <p style="font-size:11.5px;color:#8A8E84;margin:3px 0 0;">Moins de 0,5h disponible. Propose ton aide à la communauté pour recharger ton solde.</p>
                </div>
            </div>

            <div class="dash-ledger" style="border-color:{{ $user->isGele() ? 'rgba(239,68,68,.45)' : 'rgba(239,68,68,.28)' }};{{ $user->isGele() ? 'box-shadow:0 0 24px rgba(239,68,68,.08);' : '' }}">
                <span style="width:30px;height:30px;border-radius:8px;background:rgba(239,68,68,.10);border:1px solid rgba(239,68,68,.28);color:#f87171;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                        <span style="font-size:12.5px;font-weight:600;color:#fff;">Compte gelé</span>
                        <span class="dash-badge {{ $user->isGele() ? 'dash-badge-red' : 'dash-badge-muted' }}">{{ $user->isGele() ? 'Ton état actuel' : 'État possible' }}</span>
                    </div>
                    <p style="font-size:11.5px;color:#8A8E84;margin:3px 0 0;">Solde inférieur à -2h. Aide quelqu'un pour débloquer ton compte.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Sessions à venir --}}
    <section class="dash-card" style="margin-top:16px;padding:16px 18px;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
            <h2 style="font-size:13.5px;font-weight:600;color:#fff;margin:0;display:flex;align-items:center;gap:8px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ADFF2F" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Sessions à venir
            </h2>
            <div style="display:flex;align-items:center;gap:14px;">
                <a href="{{ route('requests.public') }}" style="font-size:11.5px;color:#565B51;text-decoration:none;">Explorer les requêtes</a>
                <a href="{{ route('matches.index') }}" style="font-size:11.5px;color:#ADFF2F;text-decoration:none;font-weight:500;">Toutes les sessions →</a>
            </div>
        </div>
        @forelse($upcomingSessions as $session)
            @php
                $participant = $session->requester_id === $user->id ? $session->helper : $session->requester;
                $badges = [
                    'pending'   => ['En attente', 'dash-badge-amber'],
                    'accepted'  => ['Acceptée',   'dash-badge-lime'],
                    'refused'   => ['Refusée',    'dash-badge-red'],
                    'completed' => ['Terminée',   'dash-badge-muted'],
                    'disputed'  => ['Litige',     'dash-badge-red'],
                ];
                $badge = $badges[$session->statut] ?? ['En attente', 'dash-badge-muted'];
                $duration = $session->estimated_duration ? number_format($session->estimated_duration, 2) : '—';
            @endphp
            <div class="dash-row">
                <span class="dash-avatar">{{ strtoupper(substr($participant->name ?? '?', 0, 1)) }}</span>
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                        <span style="font-size:13px;font-weight:500;color:#fff;">{{ $session->offer->skill->nom ?? 'Session' }}</span>
                        <span class="dash-badge {{ $badge[1] }}">{{ $badge[0] }}</span>
                    </div>
                    <div style="font-size:11px;color:#6B6F64;margin-top:2px;">
                        {{ $participant->name ?? '—' }} · {{ $session->scheduled_at?->format('d/m H:i') ?? '—' }} · {{ $duration }}h
                    </div>
                </div>
                <a href="{{ route('matches.show', $session) }}" class="dash-btn-ghost">Voir</a>
            </div>
        @empty
            <div class="dash-empty" style="margin-top:10px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3A4035" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div style="font-size:12.5px;color:#6B6F64;">Aucune session planifiée</div>
                <div style="font-size:11px;color:#565B51;margin-top:2px;">Quand un match sera accepté, ta session apparaîtra ici.</div>
            </div>
        @endforelse
    </section>

    {{-- Dernières transactions + Matchs recommandés --}}
    <div class="dash-grid-bottom" style="margin-top:16px;">

        <section class="dash-card" style="padding:16px 18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                <h2 style="font-size:13.5px;font-weight:600;color:#fff;margin:0;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ADFF2F" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Dernières transactions
                </h2>
                <a href="{{ route('transactions.index') }}" style="font-size:11.5px;color:#ADFF2F;text-decoration:none;font-weight:500;">Tout voir →</a>
            </div>
            @forelse($recentTransactions as $tx)
                @php($positive = in_array($tx->type, ['credit', 'bonus']))
                <div class="dash-row">
                    <span class="dash-tx-icon {{ $positive ? 'lime' : 'red' }}">
                        @if($positive)
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                        @else
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="7" x2="7" y2="17"/><polyline points="17 17 7 17 7 7"/></svg>
                        @endif
                    </span>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:12.5px;color:#E5E7E1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $tx->description }}</div>
                        <div style="font-size:10.5px;color:#565B51;margin-top:1px;">{{ $tx->created_at->format('d/m/Y') }}</div>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:{{ $positive ? '#ADFF2F' : '#f87171' }};white-space:nowrap;">
                        {{ $positive ? '+' : '-' }}{{ number_format($tx->heures, 2) }}h
                    </span>
                </div>
            @empty
                <div class="dash-empty" style="margin-top:10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3A4035" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <div style="font-size:12.5px;color:#6B6F64;">Aucune transaction</div>
                    <div style="font-size:11px;color:#565B51;margin-top:2px;">Tes échanges d'heures apparaîtront ici.</div>
                </div>
            @endforelse
        </section>

        <section class="dash-card" style="padding:16px 18px;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;">
                <h2 style="font-size:13.5px;font-weight:600;color:#fff;margin:0;display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ADFF2F" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Matchs recommandés
                </h2>
                <a href="{{ route('matches.index') }}" style="font-size:11.5px;color:#ADFF2F;text-decoration:none;font-weight:500;">Tout voir →</a>
            </div>
            @forelse($pendingMatches as $match)
                <div class="dash-row">
                    <span class="dash-avatar">{{ strtoupper(substr($match->helper->name ?? '?', 0, 1)) }}</span>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13px;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $match->helper->name }}</div>
                        <div style="font-size:11px;color:#6B6F64;">{{ $match->offer->skill->nom ?? '—' }}</div>
                    </div>
                    <span class="dash-badge dash-badge-amber">En attente</span>
                    <a href="{{ route('matches.show', $match) }}" class="dash-btn-ghost">Voir</a>
                </div>
            @empty
                <div class="dash-empty" style="margin-top:10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3A4035" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:8px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div style="font-size:12.5px;color:#6B6F64;">Aucun match recommandé</div>
                    <div style="font-size:11px;color:#565B51;margin-top:2px;">Les correspondances proposées apparaîtront ici.</div>
                </div>
            @endforelse
        </section>

    </div>

</x-dashboard-layout>
