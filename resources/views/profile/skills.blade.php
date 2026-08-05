<x-app-layout>

<div style="max-width:700px;">
    <div style="margin-bottom:24px;">
        <div style="font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:#555;margin-bottom:6px;">— PROFIL</div>
        <h1 style="font-size:22px;font-weight:600;color:#fff;">Gérer mes compétences</h1>
        <p style="font-size:13px;color:#555;margin-top:4px;">Sélectionne les technologies que tu maîtrises et indique ton niveau.</p>
    </div>

    <form method="POST" action="{{ route('profile.skills.update') }}" id="skillsForm">
        @csrf

        @php $categories = $skills->groupBy('categorie'); @endphp

        @foreach($categories as $category => $categorySkills)
            <div style="background:#111;border:1px solid #1f1f1f;border-radius:12px;padding:20px 24px;margin-bottom:12px;">
                <div style="font-size:11px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#555;margin-bottom:14px;">
                    {{ $category }}
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach($categorySkills as $skill)
                        @php $userSkill = $user->skills->firstWhere('id', $skill->id); @endphp
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:8px;background:#161616;border:1px solid {{ $userSkill ? 'rgba(173,255,47,0.2)' : '#1a1a1a' }};"
                             id="skill-row-{{ $skill->id }}">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <input type="checkbox"
                                       id="skill-{{ $skill->id }}"
                                       onchange="toggleSkill({{ $skill->id }}, this.checked)"
                                       {{ $userSkill ? 'checked' : '' }}
                                       style="accent-color:#ADFF2F;width:15px;height:15px;cursor:pointer;" />
                                <label for="skill-{{ $skill->id }}" style="font-size:13px;color:#fff;cursor:pointer;font-weight:{{ $userSkill ? '500' : '400' }};">
                                    {{ $skill->nom }}
                                </label>
                            </div>
                            <div id="niveau-{{ $skill->id }}" style="display:{{ $userSkill ? 'flex' : 'none' }};gap:6px;">
                                @foreach(['debutant' => 'Débutant', 'intermediaire' => 'Inter.', 'expert' => 'Expert'] as $val => $label)
                                    <button type="button"
                                            onclick="setNiveau({{ $skill->id }}, '{{ $val }}')"
                                            id="btn-{{ $skill->id }}-{{ $val }}"
                                            style="
                                                padding:3px 10px;border-radius:20px;font-size:11px;font-weight:500;cursor:pointer;border:1px solid;transition:all 0.15s;
                                                {{ $userSkill && $userSkill->pivot->niveau === $val
                                                    ? 'background:rgba(173,255,47,0.15);border-color:rgba(173,255,47,0.3);color:#ADFF2F;'
                                                    : 'background:transparent;border-color:#2a2a2a;color:#555;' }}
                                            ">
                                        {{ $label }}
                                    </button>
                                @endforeach
                                <input type="hidden"
                                       name="skills[{{ $skill->id }}][id]"
                                       value="{{ $skill->id }}"
                                       id="hidden-id-{{ $skill->id }}"
                                       {{ $userSkill ? '' : 'disabled' }} />
                                <input type="hidden"
                                       name="skills[{{ $skill->id }}][niveau]"
                                       value="{{ $userSkill->pivot->niveau ?? 'debutant' }}"
                                       id="hidden-niveau-{{ $skill->id }}"
                                       {{ $userSkill ? '' : 'disabled' }} />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div style="display:flex;gap:10px;margin-top:16px;">
            <button type="submit" style="background:#ADFF2F;color:#000;font-weight:700;font-size:13px;padding:10px 20px;border-radius:8px;border:none;cursor:pointer;">
                Sauvegarder mes compétences
            </button>
            <a href="{{ route('profile.show') }}" style="background:#111;border:1px solid #1f1f1f;color:#888;font-size:13px;padding:10px 20px;border-radius:8px;text-decoration:none;">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
function toggleSkill(id, checked) {
    const niveauDiv  = document.getElementById('niveau-' + id);
    const hiddenId   = document.getElementById('hidden-id-' + id);
    const hiddenNiv  = document.getElementById('hidden-niveau-' + id);
    const row        = document.getElementById('skill-row-' + id);

    niveauDiv.style.display  = checked ? 'flex' : 'none';
    hiddenId.disabled        = !checked;
    hiddenNiv.disabled       = !checked;
    row.style.borderColor    = checked ? 'rgba(173,255,47,0.2)' : '#1a1a1a';
}

function setNiveau(id, niveau) {
    document.getElementById('hidden-niveau-' + id).value = niveau;
    ['debutant','intermediaire','expert'].forEach(v => {
        const btn = document.getElementById('btn-' + id + '-' + v);
        if (v === niveau) {
            btn.style.background    = 'rgba(173,255,47,0.15)';
            btn.style.borderColor   = 'rgba(173,255,47,0.3)';
            btn.style.color         = '#ADFF2F';
        } else {
            btn.style.background    = 'transparent';
            btn.style.borderColor   = '#2a2a2a';
            btn.style.color         = '#555';
        }
    });
}
</script>

</x-app-layout>