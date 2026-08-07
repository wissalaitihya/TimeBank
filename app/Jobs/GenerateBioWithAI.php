<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateBioWithAI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $timeout = 60;

    public function __construct(
        public User $user
    ) {}

    public function handle(): void
    {
        try {
            $reviews = $this->user
                ->reviewsReceived()
                ->latest()
                ->limit(20)
                ->get();

            if ($reviews->isEmpty()) return;

            $reviewsText = $reviews->map(fn($r) =>
                "Note: {$r->note}/5" .
                ($r->commentaire ? " — {$r->commentaire}" : '') .
                ($r->tags ? ' — Tags: ' . implode(', ', $r->tags) : '')
            )->join("\n");

            $skills = $this->user->skills
                ->map(fn($s) => "{$s->nom} ({$s->pivot->niveau})")
                ->join(', ');

            $prompt = $this->buildPrompt($reviewsText, $skills);

            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-6',
                'max_tokens' => 1024,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            if ($response->failed()) {
                throw new \Exception('Anthropic API error: ' . $response->body());
            }

            $content = $response->json('content.0.text');
            $json    = $this->extractJson($content);
            $data    = json_decode($json, true);

            if (!$data || !isset($data['bio'])) {
                throw new \Exception('Invalid AI response');
            }

            $this->user->update([
                'ai_generated_bio' => $data,
                'bio'              => $data['bio'],
            ]);

            Log::info('AI bio generated', ['user_id' => $this->user->id]);

        } catch (\Exception $e) {
            Log::error('GenerateBioWithAI failed', [
                'user_id' => $this->user->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    private function buildPrompt(string $reviews, string $skills): string
    {
        return <<<PROMPT
        Tu es un assistant RH qui génère des biographies professionnelles
        courtes et authentiques pour des développeurs.

        Développeur : {$this->user->name}
        Niveau : {$this->user->niveau}
        Compétences : {$skills}

        Avis reçus :
        {$reviews}

        Génère une bio basée sur ce que la communauté dit réellement.

        Réponds UNIQUEMENT avec un objet JSON valide, sans markdown, sans backticks :
        {
          "bio": "Biographie professionnelle en 2-3 phrases",
          "points_forts": ["point1", "point2", "point3"],
          "ton": "professionnel|accessible|expert",
          "tags_frequents": ["tag1", "tag2"]
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

    public function failed(\Throwable $exception): void
    {
        Log::error('GenerateBioWithAI failed permanently', [
            'user_id' => $this->user->id,
            'error'   => $exception->getMessage(),
        ]);
    }
}