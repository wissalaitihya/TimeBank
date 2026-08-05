<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->load('skills');

        $stats = [
            'sessions_donnees' => $user->matchesAsHelper()
                ->where('statut', 'completed')
                ->count(),

            'sessions_recues' => $user->matchesAsRequester()
                ->where('statut', 'completed')
                ->count(),

            'heures_donnees' => $user->transactionsReceived()
                ->where('type', 'credit')
                ->sum('heures'),

            'heures_recues' => $user->transactionsSent()
                ->where('type', 'debit')
                ->sum('heures'),

            'reviews_recues' => $user->reviewsReceived()
                ->count(),

            'reputation' => round(
                (float) $user->reviewsReceived()->avg('note'),
                1
            ),
        ];

        return view('profile.show', compact('user', 'stats'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,'.$user->id,
            ],
            'bio' => [
                'nullable',
                'string',
                'max:500',
            ],
            'niveau' => [
                'nullable',
                'in:junior,intermediaire,senior',
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function skills(Request $request): View
    {
        $user = $request->user()->load('skills');

        $skills = Skill::query()
            ->orderBy('categorie')
            ->orderBy('nom')
            ->get();

        return view('profile.skills', compact('user', 'skills'));
    }

    public function updateSkills(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'skills' => [
                'nullable',
                'array',
            ],
            'skills.*.id' => [
                'required',
                'exists:skills,id',
            ],
            'skills.*.niveau' => [
                'required',
                'in:debutant,intermediaire,expert',
            ],
        ]);

        $sync = [];

        foreach ($validated['skills'] ?? [] as $skill) {
            $sync[$skill['id']] = [
                'niveau' => $skill['niveau'],
                'source' => 'manuel',
            ];
        }

        $request->user()->skills()->sync($sync);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Compétences mises à jour.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        $user = $request->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}