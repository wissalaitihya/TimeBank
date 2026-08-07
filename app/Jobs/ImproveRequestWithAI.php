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
        return <<<PROMPT
        Tu es un assistant technique expert qui aide les développeurs à
        structurer leurs demandes d'aide technique.

        Voici la demande originale :
        Titre : {$this->serviceRequest->titre}
        Urgence : {$this->serviceRequest->urgence}
        Durée estimée : {$this->serviceRequest->duree_estimee}h
        Compétence : {$this->serviceRequest->skill->nom}

        Reformule et structure cette demande.

        Réponds UNIQUEMENT avec un objet JSON valide, sans markdown, sans backticks :
        {
          "titre_ameliore": "Titre clair et technique (max 80 caractères)",
          "description_structuree": "Description avec contexte, problème exact, tentatives et comportement attendu",
          "urgence_suggeree": "low|normal|high",
          "duree_estimee": 1.0,
          "skill_detecte": "nom du skill principal"
        }
        PROMPT;
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
