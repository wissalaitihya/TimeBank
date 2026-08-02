<?php

namespace App\Providers;

use App\Models\ServiceRequest;
use App\Policies\ServiceRequestPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\ServiceMatch;
use App\Models\Review;
use App\Policies\ReviewPolicy;
use App\Policies\ServiceMatchPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(ServiceRequest::class, ServiceRequestPolicy::class);
        Gate::policy(ServiceMatch::class, ServiceMatchPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);
    }
}
