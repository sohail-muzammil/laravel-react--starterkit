<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

use Inertia\Inertia;

use App\Models\OauthProvider;

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
        Inertia::share([
            'oauth_providers' => fn () => OauthProvider::where('enabled', true)
            ->orderBy('name')
            ->get(),
        ]);

        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
