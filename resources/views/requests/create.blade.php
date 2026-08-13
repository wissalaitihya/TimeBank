<x-app-layout>

<div style="max-width:720px;">
    <div style="margin-bottom:24px;">
        <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;">— NOUVELLE REQUÊTE</div>
        <h1 style="font-size:28px;font-weight:700;color:#fff;letter-spacing:-0.5px;font-family:'Playfair Display',serif;">
            Décris ton <em style="color:#FF6500;font-style:italic;">besoin.</em>
        </h1>
        <p style="font-size:13px;color:#555;margin-top:4px;">
            Sois précis : ça aide le bon développeur à te trouver plus vite.
        </p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 280px;gap:16px;align-items:start;">

        {{-- Form --}}
        <form method="POST" action="{{ route('requests.store') }}">
            @csrf
            @if(request()->filled('offer_id'))
             <input
                type="hidden"
                name="offer_id"
                value="{{ request('offer_id') }}"
             >
            @endif

            <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:24px;margin-bottom:12px;">

                {{-- Title --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">
                        Titre de la requête
                    </label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                           placeholder="Fix Laravel Sanctum authentication"
                           maxlength="80"
                           id="titreInput"
                           oninput="document.getElementById('titreCount').textContent = this.value.length"
                           style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                           onfocus="this.style.borderColor='rgba(255,101,0,0.4)';this.style.boxShadow='0 0 0 3px rgba(255,101,0,0.08)'"
                           onblur="this.style.borderColor='#1f1f1f';this.style.boxShadow='none'" />
                    <div style="display:flex;justify-content:space-between;margin-top:4px;">
                        <span style="font-size:11px;color:#555;">Une phrase claire, ≤ 80 caractères.</span>
                        <span style="font-size:11px;color:#555;"><span id="titreCount">0</span>/80</span>
                    </div>
                    @error('titre')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Description</label>
                    <textarea name="description" rows="5"
                              id="descInput"
                              maxlength="1000"
                              oninput="document.getElementById('descCount').textContent = this.value.length"
                              placeholder="Décris le problème, ce que tu as déjà essayé, le comportement attendu vs actuel..."
                              style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;resize:vertical;box-sizing:border-box;"
                              onfocus="this.style.borderColor='rgba(255,101,0,0.4)';this.style.boxShadow='0 0 0 3px rgba(255,101,0,0.08)'"
                              onblur="this.style.borderColor='#1f1f1f';this.style.boxShadow='none'">{{ old('description') }}</textarea>
                    <div style="display:flex;justify-content:flex-end;margin-top:4px;">
                        <span style="font-size:11px;color:#555;"><span id="descCount">0</span>/1000</span>
                    </div>
                    @error('description')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                {{-- Skill --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Compétence principale</label>
                    <select name="skill_id"
                            style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;cursor:pointer;"
                            onfocus="this.style.borderColor='rgba(255,101,0,0.4)';this.style.boxShadow='0 0 0 3px rgba(255,101,0,0.08)'"
                            onblur="this.style.borderColor='#1f1f1f';this.style.boxShadow='none'">
                        <option value="">Choisir...</option>
                        @foreach($skills->groupBy('categorie') as $cat => $catSkills)
                            <optgroup label="{{ $cat }}">
                                @foreach($catSkills as $skill)
                                    <option value="{{ $skill->id }}" {{ old('skill_id') == $skill->id ? 'selected' : '' }}>
                                        {{ $skill->nom }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('skill_id')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                {{-- Duration + Urgency --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Durée estimée</label>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            @php
    $durations = [
        ['value' => '0.5', 'label' => '0.5h'],
        ['value' => '0.75', 'label' => '0.75h'],
        ['value' => '1', 'label' => '1h'],
        ['value' => '1.5', 'label' => '1.5h'],
    ];
@endphp

@foreach($durations as $duration)
    @php
        $isDurationSelected =
            (string) old('duree_estimee', '1') === $duration['value'];
    @endphp

    <label style="cursor:pointer;">
        <input
            type="radio"
            name="duree_estimee"
            value="{{ $duration['value'] }}"
            {{ $isDurationSelected ? 'checked' : '' }}
            style="display:none;"
            onchange="
                document.querySelectorAll('.dur-btn').forEach(button => {
                    button.style.background = '#151311';
                    button.style.color = '#888';
                    button.style.borderColor = 'rgba(255,255,255,0.08)';
                    button.style.boxShadow = 'none';
                });

                const button =
                    this.parentElement.querySelector('.dur-btn');

                button.style.background = 'rgba(255,101,0,0.12)';
                button.style.color = '#FF6500';
                button.style.borderColor = 'rgba(255,101,0,0.35)';
                button.style.boxShadow =
                    'inset 0 0 12px rgba(255,101,0,0.06)';
            "
        >

        <span
            class="dur-btn"
            style="
                display:inline-block;
                padding:6px 12px;
                border-radius:8px;
                font-size:12px;
                font-weight:500;
                border:1px solid {{ $isDurationSelected
                    ? 'rgba(255,101,0,0.35)'
                    : 'rgba(255,255,255,0.08)' }};
                background:{{ $isDurationSelected
                    ? 'rgba(255,101,0,0.12)'
                    : '#151311' }};
                color:{{ $isDurationSelected ? '#FF6500' : '#888' }};
                transition:all 0.15s;
                {{ $isDurationSelected
                    ? 'box-shadow:inset 0 0 12px rgba(255,101,0,0.06);'
                    : '' }}
            "
        >
            {{ $duration['label'] }}
        </span>
    </label>
@endforeach
</div>
@error('duree_estimee')
    <p style="font-size:11px;color:#f87171;margin-top:6px;">
        {{ $message }}
    </p>
@enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Urgence</label>
                        <div style="display:flex;gap:6px;">
                            @foreach(['low' => 'Faible', 'normal' => 'Normale', 'high' => 'Élevée'] as $val => $label)
                                @php
                                    $isSelected = old('urgence', 'normal') === $val;
                                    $selectedBg = $val === 'high' ? 'rgba(239,68,68,0.12)' : ($val === 'normal' ? 'rgba(255,101,0,0.12)' : 'rgba(255,255,255,0.04)');
                                    $selectedColor = $val === 'high' ? '#f87171' : ($val === 'normal' ? '#FF6500' : '#918B84');
                                    $selectedBorder = $val === 'high' ? 'rgba(239,68,68,0.35)' : ($val === 'normal' ? 'rgba(255,101,0,0.35)' : 'rgba(255,255,255,0.12)');
                                    $selectedShadow = $val === 'high' ? 'inset 0 0 12px rgba(239,68,68,0.06)' : ($val === 'normal' ? 'inset 0 0 12px rgba(255,101,0,0.06)' : 'none');
                                @endphp
                                <label style="cursor:pointer;">
                                    <input type="radio" name="urgence" value="{{ $val }}"
                                           {{ $isSelected ? 'checked' : '' }}
                                           style="display:none;"
                                           onchange="document.querySelectorAll('.urg-btn').forEach(b=>{b.style.background='#151311';b.style.color='#888';b.style.borderColor='rgba(255,255,255,0.08)';b.style.boxShadow='none'});var v='{{ $val }}';var bg=v==='high'?'rgba(239,68,68,0.12)':(v==='normal'?'rgba(255,101,0,0.12)':'rgba(255,255,255,0.04)');var c=v==='high'?'#f87171':(v==='normal'?'#FF6500':'#918B84');var brd=v==='high'?'rgba(239,68,68,0.35)':(v==='normal'?'rgba(255,101,0,0.35)':'rgba(255,255,255,0.12)');var shd=v==='high'?'inset 0 0 12px rgba(239,68,68,0.06)':(v==='normal'?'inset 0 0 12px rgba(255,101,0,0.06)':'none');var btn=this.parentElement.querySelector('.urg-btn');btn.style.background=bg;btn.style.color=c;btn.style.borderColor=brd;btn.style.boxShadow=shd"/>
                                    <span class="urg-btn" style="display:inline-block;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:500;border:1px solid {{ $isSelected ? $selectedBorder : 'rgba(255,255,255,0.08)' }};background:{{ $isSelected ? $selectedBg : '#151311' }};color:{{ $isSelected ? $selectedColor : '#888' }};transition:all 0.15s;{{ $isSelected ? 'box-shadow:'.$selectedShadow.';' : '' }}">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <div style="display:flex;gap:10px;">
                <button type="submit" style="background:linear-gradient(100deg,#FF6500 0%,#FFAE25 100%);color:#fff;font-weight:700;font-size:13px;padding:10px 20px;border-radius:8px;border:none;cursor:pointer;transition:transform 200ms ease,box-shadow 200ms ease;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 16px rgba(255,101,0,0.25)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                    Publier la requête
                </button>
                <a href="{{ route('requests.index') }}" style="background:#111;border:1px solid #1f1f1f;color:#888;font-size:13px;padding:10px 20px;border-radius:8px;text-decoration:none;">
                    Annuler
                </a>
            </div>
        </form>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:12px;">

            {{-- Cost card --}}
            <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 20px;">
                <div style="font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:#555;margin-bottom:8px;">Coût estimé</div>
                <div style="font-size:28px;font-weight:700;color:#FF6500;letter-spacing:-1px;">1.00h</div>
                <p style="font-size:11px;color:#666;margin-top:6px;line-height:1.6;">
                    Débité uniquement après confirmation mutuelle de la session.
                </p>
            </div>

            {{-- Balance check --}}
            <div style="background:#11100F;border:1px solid rgba(255,101,0,0.28);border-radius:12px;padding:18px 20px;">
                <div style="font-size:9px;letter-spacing:0.12em;text-transform:uppercase;color:#FF6500;margin-bottom:6px;">Solde à vérifier</div>
                <p style="font-size:12px;color:#918B84;line-height:1.6;">
                    Ton solde actuel est de
                    <span style="color:#FF6500;font-weight:600;">{{ number_format(auth()->user()->solde_heures, 2) }}h</span>.
                    @if(auth()->user()->solde_heures >= 1)
                        Cette requête sera acceptée.
                    @else
                        Assure-toi d'avoir assez de crédit.
                    @endif
                </p>
            </div>

            {{-- After publish --}}
            <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:18px 20px;">
                <div style="font-size:12px;font-weight:600;color:#fff;margin-bottom:10px;">Après publication</div>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:7px;">
                    @foreach([
                        'Les développeurs pertinents reçoivent une notification',
                        'Tu choisis l\'aidant qui te convient',
                        'Confirmation mutuelle après la session',
                    ] as $tip)
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#777;line-height:1.5;">
                            <span style="color:#FF6500;flex-shrink:0;">·</span>{{ $tip }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>

</x-app-layout>