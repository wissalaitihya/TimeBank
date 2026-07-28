<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Skill;
use  App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirect(){
        return Socialite::driver('github')->redirect();
    }

    public function callback(){
     $githubUser = Socialite::driver('github')->user();
     // to fincd or create the user
     $user = User::firstOrCreate(
        ['github_id' => $githubUser->getId()],
        [
                'name'                => $githubUser->getName() ?? $githubUser->getNickname(),
                'email'               => $githubUser->getEmail(),
                'password'            => bcrypt(str()->random(24)),
                'github_username'     => $githubUser->getNickname(),
                'github_access_token' => $githubUser->token,
                'solde_heures'        => 2.00,
                'statut_compte'       => 'actif',
        ]
     );
      //update token if user already exists 
      $user->update([
        'github_access_token' => $githubUser->token,
        'github_username'  => $githubUser->getNickname(),
      ]);
      
      //auto-detect skills from github repos
      $this->detectSkillsFromGithub($user);
      Auth::login()($user);
        return redirect()->route('dashboard');
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