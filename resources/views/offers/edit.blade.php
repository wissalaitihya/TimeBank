<x-app-layout>

<div style="max-width:680px;">
    <div style="margin-bottom:24px;">
        <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;">— MODIFIER L'OFFRE</div>
        <h1 style="font-size:22px;font-weight:600;color:#fff;">Modifier l'offre</h1>
    </div>

    <form method="POST" action="{{ route('offers.update', $serviceOffer) }}">
        @csrf @method('PATCH')

        <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:24px;margin-bottom:12px;">

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Titre</label>
                <input type="text" name="titre" value="{{ old('titre', $serviceOffer->titre) }}"
                       style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                       onblur="this.style.borderColor='#1f1f1f'" />
                @error('titre')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Description</label>
                <textarea name="description" rows="4"
                          style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;resize:vertical;box-sizing:border-box;"
                          onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                          onblur="this.style.borderColor='#1f1f1f'">{{ old('description', $serviceOffer->description) }}</textarea>
                @error('description')<p style="font-size:11px;color:#f87171;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Compétence</label>
                    <select name="skill_id"
                            style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;cursor:pointer;"
                            onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                            onblur="this.style.borderColor='#1f1f1f'">
                        @foreach($skills->groupBy('categorie') as $cat => $catSkills)
                            <optgroup label="{{ $cat }}">
                                @foreach($catSkills as $skill)
                                    <option value="{{ $skill->id }}" {{ $serviceOffer->skill_id == $skill->id ? 'selected' : '' }}>
                                        {{ $skill->nom }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Statut</label>
                    <select name="statut"
                            style="width:100%;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;cursor:pointer;"
                            onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                            onblur="this.style.borderColor='#1f1f1f'">
                        <option value="active" {{ $serviceOffer->statut === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ $serviceOffer->statut === 'paused' ? 'selected' : '' }}>En pause</option>
                        <option value="archived" {{ $serviceOffer->statut === 'archived' ? 'selected' : '' }}>Archivée</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="display:block;font-size:12px;color:#888;margin-bottom:6px;">Durée estimée (heures)</label>
                <input type="number" name="duree_estimee" step="0.25" min="0.25" max="8"
                       value="{{ old('duree_estimee', $serviceOffer->duree_estimee) }}"
                       style="width:120px;background:#161616;border:1px solid #1f1f1f;border-radius:8px;padding:10px 14px;font-size:14px;color:#fff;font-family:'Inter',sans-serif;outline:none;"
                       onfocus="this.style.borderColor='rgba(173,255,47,0.4)'"
                       onblur="this.style.borderColor='#1f1f1f'" />
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" style="background:#ADFF2F;color:#000;font-weight:700;font-size:13px;padding:10px 20px;border-radius:8px;border:none;cursor:pointer;">
                Sauvegarder
            </button>
            <a href="{{ route('offers.index') }}" style="background:#111;border:1px solid #1f1f1f;color:#888;font-size:13px;padding:10px 20px;border-radius:8px;text-decoration:none;">
                Annuler
            </a>
        </div>
    </form>
</div>

</x-app-layout>