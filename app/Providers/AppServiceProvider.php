<?php

namespace App\Providers;

use App\Models\Laundry;
use App\Observers\LaundryObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        Laundry::observe(LaundryObserver::class);
        Schema::defaultStringLength(191);
        // URL::forceScheme('https');
    }
}
