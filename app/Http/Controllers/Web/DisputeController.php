<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\ServiceMatch;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
 public function store(Request $request, ServiceMatch $serviceMatch){
$request->validate([
            'reason'      => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($serviceMatch->dispute()->exists()) {
            return back()->with('error', 'Un litige est déjà ouvert pour ce match.');
        }

        $serviceMatch->update(['statut' => 'disputed']);

        $serviceMatch->dispute()->create([
            'opened_by'   => auth()->id(),
            'reason'      => $request->reason,
            'description' => $request->description,
            'status'      => 'open',
            'opened_at'   => now(),
        ]);

        return redirect()->route('matches.show', $serviceMatch)
            ->with('success', 'Litige ouvert. Un administrateur va examiner la situation.');
    }

    public function show(Dispute $dispute)
    {
        $dispute->load([
            'match.helper', 'match.requester',
            'match.offer.skill', 'openedBy', 'resolvedBy'
        ]);

        return view('disputes.show', compact('dispute'));
    }
}
