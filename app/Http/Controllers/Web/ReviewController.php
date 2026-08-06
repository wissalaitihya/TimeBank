<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ServiceMatch;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $reviewsReceived = $user->reviewsReceived()
            ->with(['reviewer', 'match.offer.skill'])
            ->latest()
            ->get();

        $reviewsGiven = $user->reviewsGiven()
            ->with(['reviewed', 'match.offer.skill'])
            ->latest()
            ->get();

        $avgNote = $reviewsReceived->avg('note');

        return view('reviews.index', compact(
            'reviewsReceived', 'reviewsGiven', 'avgNote'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_match_id' => 'required|exists:service_matches,id',
            'note'             => 'required|integer|min:1|max:5',
            'commentaire'      => 'nullable|string|max:1000',
            'tags'             => 'nullable|array',
            'tags.*'           => 'string|in:pedagogue,ponctuel,patient,expert,clair,disponible',
        ]);

        $match = ServiceMatch::findOrFail($request->service_match_id);

        $reviewedId = auth()->id() === $match->helper_id
            ? $match->requester_id
            : $match->helper_id;

        $review = Review::create([
            'service_match_id' => $match->id,
            'reviewer_id'      => auth()->id(),
            'reviewed_id'      => $reviewedId,
            'note'             => $request->note,
            'commentaire'      => $request->commentaire,
            'tags'             => $request->tags ?? [],
        ]);

        $review->reviewed->updateReputation();

        if ($review->reviewed->reviewsReceived()->count() >= 5) {
            \App\Jobs\GenerateBioWithAI::dispatch($review->reviewed);
        }

        return redirect()->route('matches.show', $match)
            ->with('success', 'Avis publié avec succès.');
    }
}
