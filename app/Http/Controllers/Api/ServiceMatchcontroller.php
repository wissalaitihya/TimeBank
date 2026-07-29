<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceMatchRequest;
use App\Http\Requests\UpdateServiceMatchRequest;
use App\Jobs\ProcessTransaction;
use App\Models\ServiceMatch;
use App\Models\ServiceOffer;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceMatchcontroller extends Controller
{
    public function index(Request $request)
    {
        $matches = ServiceMatch::with([
                'helper', 'requester', 'offer.skill', 'request'
            ])
            ->where(function ($q) use ($request) {
                $q->where('helper_id', $request->user()->id)
                  ->orWhere('requester_id', $request->user()->id);
            })
            ->when($request->statut, fn($q) =>
                $q->where('statut', $request->statut)
            )
            ->latest()
            ->paginate(15);

        return ServiceMatchResource::collection($matches);
    }

    // ── Propose a match ────────────────────────────────────────────────────
    public function store(StoreServiceMatchRequest $request)
    {
        $this->authorize('create', ServiceMatch::class);

        $offer   = ServiceOffer::findOrFail($request->offer_id);
        $serviceRequest = ServiceRequest::findOrFail($request->request_id);

        // Validate that offer and request share the same skill
        if ($offer->skill_id !== $serviceRequest->skill_id) {
            return response()->json([
                'message' => 'L offre et la demande doivent concerner la même compétence.',
            ], 422);
        }

        // Prevent matching with yourself
        if ($offer->user_id === $serviceRequest->user_id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas créer un match avec vous-même.',
            ], 422);
        }

        $match = ServiceMatch::create([
            'offer_id'           => $offer->id,
            'request_id'         => $serviceRequest->id,
            'helper_id'          => $offer->user_id,
            'requester_id'       => $serviceRequest->user_id,
            'proposed_by'        => $request->user()->id,
            'message'            => $request->message,
            'statut'             => 'pending',
            'estimated_duration' => $serviceRequest->duree_estimee,
        ]);

        // Update request status
        $serviceRequest->update(['statut' => 'matched']);

        return new ServiceMatchResource(
            $match->load(['helper', 'requester', 'offer.skill', 'request'])
        );
    }

    // ── Show match detail ──────────────────────────────────────────────────
    public function show(ServiceMatch $serviceMatch)
    {
        $this->authorize('view', $serviceMatch);

        return new ServiceMatchResource(
            $serviceMatch->load(['helper', 'requester', 'offer.skill', 'request'])
        );
    }

    // ── Accept a match ─────────────────────────────────────────────────────
    public function accept(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('accept', $serviceMatch);

        $serviceMatch->update(['statut' => 'accepted']);

        return new ServiceMatchResource(
            $serviceMatch->load(['helper', 'requester', 'offer.skill', 'request'])
        );
    }

    // ── Refuse a match ─────────────────────────────────────────────────────
    public function refuse(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('refuse', $serviceMatch);

        $serviceMatch->update(['statut' => 'refused']);

        // Reopen the request
        $serviceMatch->request->update(['statut' => 'open']);

        return new ServiceMatchResource(
            $serviceMatch->load(['helper', 'requester', 'offer.skill', 'request'])
        );
    }

    // ── Schedule session ───────────────────────────────────────────────────
    public function schedule(UpdateServiceMatchRequest $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('schedule', $serviceMatch);

        $serviceMatch->update([
            'scheduled_at' => $request->scheduled_at,
            'session_link' => $request->session_link,
            'platform'     => $request->platform,
        ]);

        return new ServiceMatchResource(
            $serviceMatch->load(['helper', 'requester', 'offer.skill', 'request'])
        );
    }

    // ── Confirm session end ────────────────────────────────────────────────
    public function confirm(UpdateServiceMatchRequest $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('confirm', $serviceMatch);

        $user = $request->user();

        // Record who confirmed and their declared duration
        if ($user->id === $serviceMatch->helper_id) {
            $serviceMatch->update([
                'helper_confirmed_at'      => now(),
                'helper_declared_duration' => $request->declared_duration,
            ]);
        } else {
            $serviceMatch->update([
                'requester_confirmed_at'      => now(),
                'requester_declared_duration' => $request->declared_duration,
            ]);
        }

        // Reload to check if both confirmed
        $serviceMatch->refresh();

        if ($serviceMatch->isBothConfirmed()) {
            // Calculate actual duration
            $actualDuration = ($serviceMatch->helper_declared_duration
                + $serviceMatch->requester_declared_duration) / 2;

            $serviceMatch->update([
                'actual_duration' => $actualDuration,
                'statut'          => 'completed',
            ]);

            // Dispatch transaction job — returns 202
            ProcessTransaction::dispatch($serviceMatch);

            return response()->json([
                'message'  => 'Session confirmée. Transaction en cours de traitement.',
                'match'    => new ServiceMatchResource(
                    $serviceMatch->load(['helper', 'requester'])
                ),
            ], 202);
        }

        return response()->json([
            'message' => 'Confirmation enregistrée. En attente de l autre partie.',
            'match'   => new ServiceMatchResource(
                $serviceMatch->load(['helper', 'requester'])
            ),
        ]);
    }

    // ── Open dispute ───────────────────────────────────────────────────────
    public function dispute(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('dispute', $serviceMatch);

        $request->validate([
            'reason'      => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $serviceMatch->update(['statut' => 'disputed']);

        $serviceMatch->dispute()->create([
            'opened_by'   => $request->user()->id,
            'reason'      => $request->reason,
            'description' => $request->description,
            'status'      => 'open',
            'opened_at'   => now(),
        ]);

        return response()->json([
            'message' => 'Litige ouvert. Un administrateur va examiner la situation.',
        ], 201);
    }
}
