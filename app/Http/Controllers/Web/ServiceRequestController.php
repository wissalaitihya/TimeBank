<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;
use App\Jobs\ImproveRequestWithAI;
use App\Models\ServiceRequest;
use App\Models\Skill;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
     // ── My requests ────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $requests = $request->user()
            ->serviceRequests()
            ->with('skill')
            ->latest()
            ->paginate(12);

        return view('requests.index', compact('requests'));
    }

    // ── Public explorer ────────────────────────────────────────────────────
    public function public(Request $request)
    {
        $requests = ServiceRequest::with(['user', 'skill'])
            ->where('statut', 'open')
            ->when($request->skill_id, fn($q) =>
                $q->where('skill_id', $request->skill_id))
            ->when($request->urgence, fn($q) =>
                $q->where('urgence', $request->urgence))
            ->orderByRaw("FIELD(urgence, 'high', 'normal', 'low')")
            ->latest()
            ->paginate(12);

        $skills = Skill::orderBy('nom')->get();

        return view('requests.public', compact('requests', 'skills'));
    }

    // ── Create form ────────────────────────────────────────────────────────
    public function create(Request $request)
    {
        if (auth()->user()->isGele()) {
            return redirect()->route('dashboard')
                ->with('error', 'Ton compte est gelé. Aide quelqu\'un d\'abord.');
        }

        $skills   = Skill::orderBy('categorie')->orderBy('nom')->get();
        $offerId  = $request->query('offer_id');

        return view('requests.create', compact('skills', 'offerId'));
    }

    // ── Store ──────────────────────────────────────────────────────────────
    public function store(StoreServiceRequestRequest $request)
    {
        $this->authorize('create', ServiceRequest::class);

        $validated = $request->validated();
        $validated['description_originale'] = $validated['description'];
        $validated['ai_status'] = 'pending';

        $serviceRequest = $request->user()
            ->serviceRequests()
            ->create($validated);

        ImproveRequestWithAI::dispatch($serviceRequest);

        return redirect()->route('requests.index')
            ->with('success', 'Demande publiée. L\'IA améliore ta description en arrière-plan.');
    }

    // ── Show ───────────────────────────────────────────────────────────────
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['user.skills', 'skill', 'matches.helper']);
        return view('requests.show', compact('serviceRequest'));
    }

    // ── Edit ───────────────────────────────────────────────────────────────
    public function edit(ServiceRequest $serviceRequest)
    {
        $this->authorize('update', $serviceRequest);
        $skills = Skill::orderBy('nom')->get();
        return view('requests.edit', compact('serviceRequest', 'skills'));
    }

    // ── Update ─────────────────────────────────────────────────────────────
    public function update(UpdateServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        $this->authorize('update', $serviceRequest);
        $serviceRequest->update($request->validated());

        return redirect()->route('requests.index')
            ->with('success', 'Demande mise à jour.');
    }

    // ── Destroy ────────────────────────────────────────────────────────────
    public function destroy(ServiceRequest $serviceRequest)
    {
        $this->authorize('delete', $serviceRequest);
        $serviceRequest->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Demande archivée.');
    }
}
