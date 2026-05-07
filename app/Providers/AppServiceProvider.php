<?php

namespace App\Providers;

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
        \App\Models\Cow::observe(\App\Observers\CowObserver::class);
        \App\Models\FeedAllocation::observe(\App\Observers\FeedAllocationObserver::class);
        \App\Models\FeedPurchase::observe(\App\Observers\FeedPurchaseObserver::class);
        \App\Models\Treatment::observe(\App\Observers\TreatmentObserver::class);
        \App\Models\Insemination::observe(\App\Observers\InseminationObserver::class);
    }
}
