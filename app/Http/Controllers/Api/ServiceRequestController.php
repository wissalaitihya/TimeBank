<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Models\ServiceRequest;
use App\Jobs\ImproveRequestWithAI;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = ServiceRequest::with(['user', 'skill'])
            ->where('statut', 'open')
            ->when($request->skill_id, fn($q) =>
                $q->where('skill_id', $request->skill_id)
            )
            ->when($request->urgence, fn($q) =>
                $q->where('urgence', $request->urgence)
            )
            ->orderByRaw("FIELD(urgence, 'high', 'normal', 'low')")
            ->latest()
            ->paginate(15);

        return ServiceRequestResource::collection($requests);
    }

    // ── Create a new request ───────────────────────────────────────────────
    public function store(StoreServiceRequestRequest $request)
    {
        $this->authorize('create', ServiceRequest::class);

        $validated = $request->validated();

        // Store original description before AI improvement
        $validated['description_originale'] = $validated['description'];
        $validated['ai_status'] = 'pending';

        $serviceRequest = $request->user()
            ->serviceRequests()
            ->create($validated);

        // Dispatch AI improvement job asynchronously
        ImproveRequestWithAI::dispatch($serviceRequest);

        return new ServiceRequestResource(
            $serviceRequest->load(['user', 'skill'])
        );
    }

    // ── Show request detail ────────────────────────────────────────────────
    public function show(ServiceRequest $serviceRequest)
    {
        $this->authorize('view', $serviceRequest);

        return new ServiceRequestResource(
            $serviceRequest->load(['user', 'skill'])
        );
    }

    // ── Update request ─────────────────────────────────────────────────────
    public function update(UpdateServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        $this->authorize('update', $serviceRequest);

        $serviceRequest->update($request->validated());

        return new ServiceRequestResource(
            $serviceRequest->load(['user', 'skill'])
        );
    }

    // ── Archive request (soft delete) ──────────────────────────────────────
    public function destroy(ServiceRequest $serviceRequest)
    {
        $this->authorize('delete', $serviceRequest);

        $serviceRequest->delete();

        return response()->json([
            'message' => 'Demande archivée avec succès.',
        ]);
    }

    // ── My requests ────────────────────────────────────────────────────────
    public function myRequests(Request $request)
    {
        $requests = $request->user()
            ->serviceRequests()
            ->with(['skill'])
            ->latest()
            ->paginate(15);

        return ServiceRequestResource::collection($requests);
    }
}
