<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\ServiceMatch;

class ApiReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $match = ServiceMatch::findOrFail($request->service_match_id);

        // Check policy
        $this->authorize('store', [Review::class, $match]);

        // Determine who is being reviewed
        $reviewedId = $request->user()->id === $match->helper_id
            ? $match->requester_id
            : $match->helper_id;

        $review = Review::create([
            'service_match_id' => $match->id,
            'reviewer_id'      => $request->user()->id,
            'reviewed_id'      => $reviewedId,
            'note'             => $request->note,
            'commentaire'      => $request->commentaire,
            'tags'             => $request->tags ?? [],
        ]);

        // Update reputation of reviewed user
        $reviewed = $review->reviewed;
        $reviewed->updateReputation();

        // Trigger AI bio generation if 5+ reviews received
        if ($reviewed->reviewsReceived()->count() >= 5) {
            \App\Jobs\GenerateBioWithAI::dispatch($reviewed);
        }

        return new ReviewResource(
            $review->load(['reviewer', 'reviewed', 'match'])
        );
    }

    //List reviews for a user 
    public function userReviews(Request $request, $username)
    {
        $user = \App\Models\User::where('github_username', $username)
            ->orWhere('name', $username)
            ->firstOrFail();

        $reviews = $user->reviewsReceived()
            ->with(['reviewer', 'reviewed', 'match'])
            ->latest()
            ->paginate(10);

        return ReviewResource::collection($reviews);
    }

    // List reviews for a match 
    public function matchReviews(ServiceMatch $serviceMatch)
    {
        $reviews = $serviceMatch->reviews()
            ->with(['reviewer', 'reviewed', 'match'])
            ->get();

        return ReviewResource::collection($reviews);
    }

    // My received reviews 
    public function myReviews(Request $request)
    {
        $reviews = $request->user()
            ->reviewsReceived()
            ->with(['reviewer', 'match'])
            ->latest()
            ->paginate(10);

        return ReviewResource::collection($reviews);
    }
}
