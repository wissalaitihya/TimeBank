<?php

namespace App\Jobs;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImproveRequestWithAI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public function __construct(
        public ServiceRequest $serviceRequest
    ) {}

    public function handle(): void
    {
        if ($this->serviceRequest->ai_status === 'done') return;

        $apiKey = config('services.groq.key');
        $model  = config('services.groq.model');

        if (!$apiKey) {
            Log::warning('ImproveRequestWithAI: GROQ_API_KEY not configured', [
                'id' => $this->serviceRequest->id,
            ]);
            $this->serviceRequest->update(['ai_status' => 'skipped']);
            return;
        }

        $this->serviceRequest->update(['ai_status' => 'pending']);

        try {
            $prompt = $this->buildPrompt();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'      => $model,
                'max_tokens' => 1024,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->failed()) {
                throw new \Exception('Groq API error: ' . $response->status());
            }

            $content = $response->json('choices.0.message.content');

            if (!$content) {
                throw new \Exception('Empty response from Groq');
            }

            $json = $this->extractJson($content);
            $data = json_decode($json, true);

            if (!$data || !isset($data['titre_ameliore'])) {
                throw new \Exception('Invalid AI response structure');
            }

            $this->serviceRequest->update([
                'ai_status'     => 'done',
                'ai_suggestion' => $data,
            ]);

            Log::info('AI improved request', ['id' => $this->serviceRequest->id]);

        } catch (\Exception $e) {
            Log::error('ImproveRequestWithAI failed', [
                'id'    => $this->serviceRequest->id,
                'error' => $e->getMessage(),
            ]);

            $this->serviceRequest->update(['ai_status' => 'skipped']);
        }
    }

    private function buildPrompt(): string
    {
         return 'Tu reformules une demande d\'aide technique.

Demande originale :
Titre : ' . $this->serviceRequest->titre . '
Description : ' . $this->serviceRequest->description . '
Compétence sélectionnée : ' . $this->serviceRequest->skill->nom . '

Règles obligatoires :
- N\'invente aucune information absente de la demande originale.
- N\'invente aucun code d\'erreur.
- N\'invente aucune technologie non mentionnée.
- N\'invente aucune tentative effectuée par l\'utilisateur.
- Si une information est inconnue, écris "Non précisé".
- Conserve le sens exact de la demande.
- L\'urgence doit être uniquement : low, normal ou high.
- La durée doit être un nombre exprimé en heures.

Réponds uniquement avec ce JSON :
{
  "titre_ameliore": "titre clair, sans information inventée",
  "description_structuree": "description fidèle à la demande originale",
  "urgence_suggeree": "low, normal ou high",
  "duree_estimee": 1,
  "skill_detecte": "compétence réellement mentionnée ou sélectionnée"
}';
    }

    private function extractJson(string $text): string
    {
        $text = preg_replace('/```json\s*/i', '', $text);
        $text = preg_replace('/```\s*/i', '', $text);

        $start = strpos($text, '{');
        $end   = strrpos($text, '}');

        if ($start !== false && $end !== false) {
            return substr($text, $start, $end - $start + 1);
        }

        return $text;
    }

    public function failed(\Throwable $exception): void
    {
        $this->serviceRequest->update(['ai_status' => 'skipped']);
    }
}
