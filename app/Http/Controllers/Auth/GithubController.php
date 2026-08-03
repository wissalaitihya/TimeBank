<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $githubId = (string) $githubUser->getId();
        $nickname = (string) $githubUser->getNickname();
        $email = strtolower(trim((string) $githubUser->getEmail()));

        $user = User::where('github_id', $githubId)->first();

        if ($user === null && $email !== '') {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $user->update([
                'github_id' => $githubId,
                'github_username' => $nickname !== '' ? $nickname : null,
                'github_access_token' => $githubUser->token,
            ]);
        } else {
            $name = $githubUser->getName() ?: ($nickname !== '' ? $nickname : $githubId);

            $user = User::create([
                'name' => $name,
                'username' => $this->uniqueUsername($nickname !== '' ? $nickname : $githubId),
                'email' => $email !== '' ? $email : $githubId.'@users.noreply.github.com',
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(32)),
                'github_id' => $githubId,
                'github_username' => $nickname !== '' ? $nickname : null,
                'github_access_token' => $githubUser->token,
                'solde_heures' => 2.00,
                'statut_compte' => 'actif',
            ]);
        }

        $this->detectSkillsFromGithub($user);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    private function uniqueUsername(string $preferred): string
    {
        $base = Str::lower(Str::slug($preferred, '-'));

        if (strlen($base) < 3) {
            $base = 'github-user';
        }

        $base = substr($base, 0, 30);
        $username = $base;
        $suffix = 1;

        while (User::where('username', $username)->exists()) {
            $username = substr($base, 0, 28 - strlen((string) $suffix)).'-'.$suffix;
            $suffix++;
        }

        return $username;
    }

    private function detectSkillsFromGithub(User $user): void
    {
        try {
            // Get public repos
            $repos = Http::withToken($user->github_access_token)
                ->get('https://api.github.com/user/repos', [
                    'per_page' => 30,
                    'sort'     => 'updated',
                ])
                ->json();

            if (!is_array($repos)) return;

            // Collect all languages
            $detectedLanguages = [];

            foreach ($repos as $repo) {
                if (isset($repo['language']) && $repo['language']) {
                    $detectedLanguages[] = $repo['language'];
                }
            }
            $detectedLanguages = array_unique($detectedLanguages);

            // Map GitHub languages to TimeBank skills
            $languageMap = [
                'PHP'        => 'Laravel',
                'JavaScript' => 'JavaScript',
                'TypeScript' => 'TypeScript',
                'Python'     => 'Python',
                'Java'       => 'Java',
                'Dart'       => 'Flutter',
                'CSS'        => 'CSS',
                'HTML'       => 'HTML',
            ];

            foreach ($detectedLanguages as $language) {
                if (isset($languageMap[$language])) {
                    $skillName = $languageMap[$language];
                    $skill = Skill::where('nom', $skillName)->first();

                    if ($skill) {
                        $user->skills()->syncWithoutDetaching([
                            $skill->id => [
                                'niveau'           => 'debutant',
                                'source'           => 'github',
                                'confidence_score' => 50.00,
                            ],
                        ]);
                    }
                }
            }

        } catch (\Exception $e) {
            // Silently fail — GitHub API is optional
        }
    }
}
