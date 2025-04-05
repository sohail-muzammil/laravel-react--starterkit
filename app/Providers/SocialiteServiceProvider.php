<?php

namespace App\Providers;

use App\Models\OauthProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureSocialite();
    }

    protected function configureSocialite()
    {
        if (Schema::hasTable('oauth_providers')) {
            $providers = OauthProvider::all();

            foreach ($providers as $provider) {
                Config::set("services.{$provider->name}", [
                    'client_id'     => $provider->client_id,
                    'client_secret' => $provider->client_secret,
                    'redirect'      => env('APP_URL') . '/auth/callback/' . $provider->name,
                ]);
            }
        }
    }
}