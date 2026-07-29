<?php

namespace App\Jobs;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ImproveRequestWithAI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(
        public ServiceRequest $serviceRequest
    )
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->serviceRequest->update([
                'ai_status' => 'skipped',
            ]);

        } catch (\Exception $e) {
            $this->serviceRequest->update([
                'ai_status' => 'skipped',
            ]);
        }
    
    }
}
