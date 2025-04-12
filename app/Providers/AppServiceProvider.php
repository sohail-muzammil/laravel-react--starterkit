<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use Inertia\Inertia;

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
        $this->configureSocialite();

        $providers = collect(config('socialite.providers'))
            ->filter(fn($provider) => $provider['enabled'] ?? false)
            ->toArray();
        Inertia::share('socialite_providers', $providers);

        Model::shouldBeStrict(! $this->app->isProduction());
    }

    protected function configureSocialite()
    {
        $providers = config('socialite.providers');

        foreach ($providers as $name => $provider) {
            Config::set("services.{$name}", [
                'client_id'     => $provider['client_id'],
                'client_secret' => $provider['client_secret'],
                'redirect'      => env('APP_URL') . '/auth/callback/' . $name,
            ]);
        }
    }
}
