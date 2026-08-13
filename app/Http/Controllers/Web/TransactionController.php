<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

    $transactions = \App\Models\Transaction::query()
        ->with(['fromUser', 'toUser', 'match.offer.skill'])
        ->where(function ($query) use ($user) {
            $query->where('from_user_id', $user->id)
                ->orWhere('to_user_id', $user->id);
        })
        ->latest()
        ->paginate(20);

    $stats = [
        'total_credit' => \App\Models\Transaction::query()
            ->where('to_user_id', $user->id)
            ->sum('heures'),

        'total_debit' => \App\Models\Transaction::query()
            ->where('from_user_id', $user->id)
            ->sum('heures'),

        'total_tx' => \App\Models\Transaction::query()
            ->where(function ($query) use ($user) {
                $query->where('from_user_id', $user->id)
                    ->orWhere('to_user_id', $user->id);
            })
            ->count(),
    ];

    return view('transactions.index', compact('transactions', 'stats'));
    }
}
