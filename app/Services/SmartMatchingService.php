<?php

namespace App\Services;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmartMatchingService
{
    public function getSuggestedProfiles(ServiceRequest $request): array
    {
        try {
            $candidates = User::whereHas('skills', fn($q) =>
                    $q->where('skill_id', $request->skill_id)
                )
                ->where('id', '!=', $request->user_id)
                ->where('statut_compte', 'actif')
                ->with(['skills'])
                ->withCount([
                    'matchesAsHelper as sessions_done' =>
                        fn($q) => $q->where('statut', 'completed')
                ])
                ->orderByDesc('score_reputation')
                ->limit(20)
                ->get();

            if ($candidates->isEmpty()) return [];

            $candidateList = $candidates->map(fn($u) => [
                'id'               => $u->id,
                'skills'           => $u->skills->pluck('nom')->join(', '),
                'score_reputation' => $u->score_reputation,
                'sessions_done'    => $u->sessions_done,
                'niveau'           => $u->niveau,
            ])->toArray();

            $prompt = $this->buildPrompt($request, $candidateList);

            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-6',
                'max_tokens' => 512,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->failed()) {
                throw new \Exception('Anthropic API error');
            }

            $content = $response->json('content.0.text');
            $json    = $this->extractJson($content);
            $data    = json_decode($json, true);

            return $data['profils_recommandes'] ?? [];

        } catch (\Exception $e) {
            Log::error('SmartMatching failed', [
                'request_id' => $request->id,
                'error'      => $e->getMessage(),
            ]);

            // Fallback — sort by reputation
            return User::whereHas('skills', fn($q) =>
                    $q->where('skill_id', $request->skill_id)
                )
                ->where('id', '!=', $request->user_id)
                ->where('statut_compte', 'actif')
                ->orderByDesc('score_reputation')
                ->limit(5)
                ->pluck('id')
                ->toArray();
        }
    }

    private function buildPrompt(ServiceRequest $request, array $candidates): string
    {
        $candidatesJson = json_encode($candidates, JSON_PRETTY_PRINT);

        return <<<PROMPT
        Tu es un système de matching pour une plateforme d'entraide entre développeurs.

        Demande :
        Titre : {$request->titre}
        Description : {$request->description}
        Compétence : {$request->skill->nom}

        Candidats disponibles :
        {$candidatesJson}

        Suggère les 5 profils les plus pertinents.

        Réponds UNIQUEMENT avec un objet JSON valide, sans markdown, sans backticks :
        {
          "profils_recommandes": [1, 2, 3, 4, 5],
          "raisons": ["raison1", "raison2", "raison3", "raison4", "raison5"]
        }
        PROMPT;
    }

    private function extractJson(string $text): string
    {
        $text  = preg_replace('/```json\s*/i', '', $text);
        $text  = preg_replace('/```\s*/i', '', $text);
        $start = strpos($text, '{');
        $end   = strrpos($text, '}');

        if ($start !== false && $end !== false) {
            return substr($text, $start, $end - $start + 1);
        }

        return $text;
    }
}