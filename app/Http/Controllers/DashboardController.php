<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('skills');

        $upcomingSessions = $user->matchesAsHelper()
            ->with(['offer.skill', 'request', 'requester'])
            ->where('statut', 'accepted')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get()
            ->merge(
                $user->matchesAsRequester()
                    ->with(['offer.skill', 'request', 'helper'])
                    ->where('statut', 'accepted')
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '>', now())
                    ->orderBy('scheduled_at')
                    ->limit(5)
                    ->get()
            );

        $recentTransactions = $user->transactionsReceived()
            ->with(['fromUser', 'toUser'])
            ->union(
                $user->transactionsSent()->with(['fromUser', 'toUser'])
            )
            ->latest()
            ->limit(5)
            ->get();

        $pendingMatches = $user->matchesAsRequester()
            ->with(['helper', 'offer.skill'])
            ->where('statut', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'sessions_donnees' => $user->matchesAsHelper()
                ->where('statut', 'completed')->count(),
            'sessions_recues'  => $user->matchesAsRequester()
                ->where('statut', 'completed')->count(),
            'heures_donnees'   => $user->transactionsReceived()
                ->where('type', 'credit')->sum('heures'),
            'heures_recues'    => $user->transactionsSent()
                ->where('type', 'debit')->sum('heures'),
            'reviews_recues'   => $user->reviewsReceived()->count(),
        ];

        $topHelpers = \App\Models\User::with('skills')
    ->where('id', '!=', auth()->id())
    ->where('statut_compte', 'actif')
    ->orderByDesc('score_reputation')
    ->limit(3)
    ->get();

$frequentTags = $user->reviewsReceived()
    ->whereNotNull('tags')
    ->get()
    ->flatMap(fn($r) => $r->tags ?? [])
    ->countBy()
    ->sortDesc()
    ->keys()
    ->take(3)
    ->toArray();


return view('dashboard', compact(
    'user',
    'upcomingSessions',
    'recentTransactions',
    'pendingMatches',
    'stats',
    'topHelpers',
    'frequentTags'
));
    }
}