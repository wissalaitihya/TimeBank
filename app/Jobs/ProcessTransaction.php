<?php

namespace App\Jobs;

use App\Models\ServiceMatch;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessTransaction implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( public ServiceMatch $serviceMatch)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            // Lock the match to prevent two workers from processing it together.
            $match = ServiceMatch::query()
                ->lockForUpdate()
                ->findOrFail($this->serviceMatch->id);

            // Process only completed matches.
            if ($match->statut !== 'completed' || !$match->actual_duration) {
                return;
            }

            // Prevent transferring the hours twice.
            if (Transaction::where('service_match_id', $match->id)->exists()) {
                return;
            }

            $duration = (float) $match->actual_duration;

            $requester = User::query()
                ->lockForUpdate()
                ->findOrFail($match->requester_id);

            $helper = User::query()
                ->lockForUpdate()
                ->findOrFail($match->helper_id);

            // Debit the requester and credit the helper.
            $requester->decrement('solde_heures', $duration);
            $helper->increment('solde_heures', $duration);

            Transaction::create([
                'service_match_id' => $match->id,
                'from_user_id'     => $requester->id,
                'to_user_id'       => $helper->id,
                'heures'           => $duration,
                'type'             => 'debit',
                'description'      => 'Transfert d’heures après confirmation de la session.',
            ]);

            $requester->refresh();
            $helper->refresh();

            $requester->checkAndFreeze();
            $helper->checkAndFreeze();
        });
    
    }
}
