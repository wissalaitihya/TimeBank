<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceOfferRequest;
use App\Http\Requests\UpdateServiceOfferRequest;
use App\Http\Resources\ServiceOfferResource;
use App\Models\ServiceOffer;
use Illuminate\Http\Request;

class ServiceOfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = ServiceOffer::with(['user', 'skill'])
            ->where('statut', 'active')
            ->when($request->skill_id, fn($q) =>
                $q->where('skill_id', $request->skill_id)
            )
            ->latest()
            ->paginate(15);

        return ServiceOfferResource::collection($offers);
    }

    // ── Create a new offer ─────────────────────────────────────────────────
    public function store(StoreServiceOfferRequest $request)
    {
        $this->authorize('create', ServiceOffer::class);

        $offer = $request->user()->serviceOffers()->create(
            $request->validated()
        );

        return new ServiceOfferResource(
            $offer->load(['user', 'skill'])
        );
    }

    // ── Show offer detail ──────────────────────────────────────────────────
    public function show(ServiceOffer $serviceOffer)
    {
        $this->authorize('view', $serviceOffer);

        return new ServiceOfferResource(
            $serviceOffer->load(['user', 'skill'])
        );
    }

    // ── Update offer ───────────────────────────────────────────────────────
    public function update(UpdateServiceOfferRequest $request, ServiceOffer $serviceOffer)
    {
        $this->authorize('update', $serviceOffer);

        $serviceOffer->update($request->validated());

        return new ServiceOfferResource(
            $serviceOffer->load(['user', 'skill'])
        );
    }

    // ── Archive offer (soft delete) ────────────────────────────────────────
    public function destroy(ServiceOffer $serviceOffer)
    {
        $this->authorize('delete', $serviceOffer);

        $serviceOffer->delete();

        return response()->json([
            'message' => 'Offre archivée avec succès.',
        ]);
    }

    // ── My offers ──────────────────────────────────────────────────────────
    public function myOffers(Request $request)
    {
        $offers = $request->user()
            ->serviceOffers()
            ->with(['skill'])
            ->latest()
            ->paginate(15);

        return ServiceOfferResource::collection($offers);
    }
}
