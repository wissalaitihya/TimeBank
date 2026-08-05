<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceOfferRequest;
use App\Http\Requests\UpdateServiceOfferRequest;
use App\Models\ServiceOffer;
use App\Models\Skill;
use Illuminate\Http\Request;

class ServiceOfferController extends Controller
{
    // ── My offers list ─────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $offers = $request->user()
            ->serviceOffers()
            ->with('skill')
            ->latest()
            ->paginate(12);

        return view('offers.index', compact('offers'));
    }

    // ── Public offers explorer ─────────────────────────────────────────────
    public function public(Request $request)
    {
        $offers = ServiceOffer::with(['user', 'skill'])
            ->where('statut', 'active')
            ->when($request->skill_id, fn($q) =>
                $q->where('skill_id', $request->skill_id))
            ->latest()
            ->paginate(12);

        $skills = Skill::orderBy('nom')->get();

        return view('offers.public', compact('offers', 'skills'));
    }

    // ── Create form ────────────────────────────────────────────────────────
    public function create()
    {
        $skills = Skill::orderBy('categorie')->orderBy('nom')->get();
        return view('offers.create', compact('skills'));
    }

    // ── Store ──────────────────────────────────────────────────────────────
    public function store(StoreServiceOfferRequest $request)
    {
        $request->user()->serviceOffers()->create(
            $request->validated()
        );

        return redirect()->route('offers.index')
            ->with('success', 'Offre publiée avec succès.');
    }

    // ── Show ───────────────────────────────────────────────────────────────
    public function show(ServiceOffer $serviceOffer)
    {
        $serviceOffer->load(['user.skills', 'skill', 'matches']);
        return view('offers.show', compact('serviceOffer'));
    }

    // ── Edit form ──────────────────────────────────────────────────────────
    public function edit(ServiceOffer $serviceOffer)
    {
        $this->authorize('update', $serviceOffer);
        $skills = Skill::orderBy('nom')->get();
        return view('offers.edit', compact('serviceOffer', 'skills'));
    }

    // ── Update ─────────────────────────────────────────────────────────────
    public function update(UpdateServiceOfferRequest $request, ServiceOffer $serviceOffer)
    {
        $this->authorize('update', $serviceOffer);
        $serviceOffer->update($request->validated());

        return redirect()->route('offers.index')
            ->with('success', 'Offre mise à jour.');
    }

    // ── Soft delete ────────────────────────────────────────────────────────
    public function destroy(ServiceOffer $serviceOffer)
    {
        $this->authorize('delete', $serviceOffer);
        $serviceOffer->delete();

        return redirect()->route('offers.index')
            ->with('success', 'Offre archivée.');
    }
}
