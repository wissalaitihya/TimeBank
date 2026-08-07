<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\GenerateBioWithAI;
use App\Jobs\ImproveRequestWithAI;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Services\SmartMatchingService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function __construct(
        private SmartMatchingService $matchingService
    ) {}

    // ── Smart matching ──────────────────────────────────────────────────────
    public function smartMatch(
        Request $request,
        ServiceRequest $serviceRequest
    ) {
        if ($request->user()->id !== $serviceRequest->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $suggestedIds = $this->matchingService
            ->getSuggestedProfiles($serviceRequest);

        if (empty($suggestedIds)) {
            return response()->json([
                'message'  => 'Aucun profil disponible.',
                'profiles' => [],
            ]);
        }

        $profiles = User::with('skills')
            ->whereIn('id', $suggestedIds)
            ->get()
            ->sortBy(fn($u) => array_search($u->id, $suggestedIds))
            ->values();

        return response()->json([
            'message'  => 'Profils suggérés par l\'IA.',
            'profiles' => UserResource::collection($profiles),
            'count'    => $profiles->count(),
        ]);
    }

    // ── Improve request ─────────────────────────────────────────────────────
    public function improveRequest(
        Request $request,
        ServiceRequest $serviceRequest
    ) {
        if ($request->user()->id !== $serviceRequest->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        if ($serviceRequest->ai_status === 'done') {
            return response()->json([
                'message'      => 'Description déjà améliorée.',
                'ai_suggestion'=> $serviceRequest->ai_suggestion,
            ]);
        }

        $serviceRequest->update(['ai_status' => 'pending']);
        ImproveRequestWithAI::dispatch($serviceRequest);

        return response()->json([
            'message' => 'Amélioration en cours. Recharge la page dans quelques secondes.',
        ], 202);
    }

    // ── Regenerate bio ──────────────────────────────────────────────────────
    public function regenerateBio(Request $request)
    {
        $user = $request->user();

        $reviewCount = $user->reviewsReceived()->count();

        if ($reviewCount < 5) {
            return response()->json([
                'message' => "Tu as besoin d'au moins 5 avis pour générer une bio. ({$reviewCount}/5)",
            ], 422);
        }

        GenerateBioWithAI::dispatch($user);

        return response()->json([
            'message' => 'Génération de bio en cours. Recharge ton profil dans quelques secondes.',
        ], 202);
    }
}
