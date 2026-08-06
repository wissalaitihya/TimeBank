<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransaction;
use App\Models\ServiceMatch;
use App\Models\ServiceOffer;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceMatchController extends Controller
{
    // ── All my matches ─────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $matches = ServiceMatch::with([
                'helper', 'requester', 'offer.skill', 'request'
            ])
            ->where(function ($q) {
                $q->where('helper_id', auth()->id())
                  ->orWhere('requester_id', auth()->id());
            })
            ->when($request->statut, fn($q) =>
                $q->where('statut', $request->statut))
            ->latest()
            ->paginate(15);

        return view('matches.index', compact('matches'));
    }

    // ── Sessions (accepted + scheduled) ───────────────────────────────────
    public function sessions()
    {
        $sessions = ServiceMatch::with([
                'helper', 'requester', 'offer.skill', 'request'
            ])
            ->where(function ($q) {
                $q->where('helper_id', auth()->id())
                  ->orWhere('requester_id', auth()->id());
            })
            ->where('statut', 'accepted')
            ->orderBy('scheduled_at')
            ->get();

        return view('matches.sessions', compact('sessions'));
    }

    // ── Show single match ──────────────────────────────────────────────────
    public function show(ServiceMatch $serviceMatch)
    {
        $this->authorize('view', $serviceMatch);

        $serviceMatch->load([
            'helper', 'requester', 'offer.skill',
            'request.skill', 'transaction', 'dispute', 'reviews.reviewer'
        ]);

        $user         = auth()->user();
        $isHelper     = $serviceMatch->helper_id    === $user->id;
        $isRequester  = $serviceMatch->requester_id === $user->id;
        $hasConfirmed = $isHelper
            ? $serviceMatch->helper_confirmed_at !== null
            : $serviceMatch->requester_confirmed_at !== null;

        return view('matches.show', compact(
            'serviceMatch', 'isHelper', 'isRequester', 'hasConfirmed'
        ));
    }

    // ── Store (propose a match) ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'offer_id'   => 'required|exists:service_offers,id',
            'request_id' => 'required|exists:service_requests,id',
            'message'    => 'nullable|string|max:500',
        ]);

        $offer          = ServiceOffer::findOrFail($request->offer_id);
        $serviceRequest = ServiceRequest::findOrFail($request->request_id);

        if ($offer->user_id === $serviceRequest->user_id) {
            return back()->with('error', 'Vous ne pouvez pas créer un match avec vous-même.');
        }

        $match = ServiceMatch::create([
            'offer_id'           => $offer->id,
            'request_id'         => $serviceRequest->id,
            'helper_id'          => $offer->user_id,
            'requester_id'       => $serviceRequest->user_id,
            'proposed_by'        => auth()->id(),
            'message'            => $request->message,
            'statut'             => 'pending',
            'estimated_duration' => $serviceRequest->duree_estimee,
        ]);

        $serviceRequest->update(['statut' => 'matched']);

        return redirect()->route('matches.show', $match)
            ->with('success', 'Match proposé avec succès.');
    }

    // ── Accept ─────────────────────────────────────────────────────────────
    public function accept(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('accept', $serviceMatch);
        $serviceMatch->update(['statut' => 'accepted']);

        return redirect()->route('matches.show', $serviceMatch)
            ->with('success', 'Match accepté ! Planifiez votre session.');
    }

    // ── Refuse ─────────────────────────────────────────────────────────────
    public function refuse(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('refuse', $serviceMatch);
        $serviceMatch->update(['statut' => 'refused']);
        $serviceMatch->request->update(['statut' => 'open']);

        return redirect()->route('matches.index')
            ->with('success', 'Match refusé.');
    }

    // ── Schedule session ───────────────────────────────────────────────────
    public function schedule(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('schedule', $serviceMatch);

        $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'session_link' => 'nullable|string|max:255',
            'platform'     => 'nullable|string|max:100',
        ]);

        $serviceMatch->update([
            'scheduled_at' => $request->scheduled_at,
            'session_link' => $request->session_link,
            'platform'     => $request->platform ?? 'Discord',
        ]);

        return redirect()->route('matches.show', $serviceMatch)
            ->with('success', 'Session planifiée avec succès.');
    }

    // ── Confirm session end ────────────────────────────────────────────────
    public function confirm(Request $request, ServiceMatch $serviceMatch)
    {
        $this->authorize('confirm', $serviceMatch);

        $request->validate([
            'declared_duration' => 'required|numeric|min:0.25|max:8',
        ]);

        $user = auth()->user();

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

        $serviceMatch->refresh();

        if ($serviceMatch->isBothConfirmed()) {
            $actual = ($serviceMatch->helper_declared_duration
                + $serviceMatch->requester_declared_duration) / 2;

            $serviceMatch->update([
                'actual_duration' => $actual,
                'statut'          => 'completed',
            ]);

            ProcessTransaction::dispatch($serviceMatch);

            return redirect()->route('matches.show', $serviceMatch)
                ->with('success', 'Session confirmée ! La transaction est en cours de traitement.');
        }

        return redirect()->route('matches.show', $serviceMatch)
            ->with('success', 'Confirmation enregistrée. En attente de l\'autre partie.');
    }
}
