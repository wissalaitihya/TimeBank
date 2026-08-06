<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactionsReceived()
            ->with(['fromUser', 'toUser', 'match.offer.skill'])
            ->union(
                $user->transactionsSent()
                    ->with(['fromUser', 'toUser', 'match.offer.skill'])
            )
            ->latest()
            ->paginate(20);

        $stats = [
            'total_credit' => $user->transactionsReceived()
                ->where('type', 'credit')->sum('heures'),
            'total_debit'  => $user->transactionsSent()
                ->where('type', 'debit')->sum('heures'),
            'total_tx'     => $user->transactionsReceived()->count()
                + $user->transactionsSent()->count(),
        ];

        return view('transactions.index', compact('transactions', 'stats'));
    }
}
