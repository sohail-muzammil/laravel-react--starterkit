<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\OauthProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SocialiteController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/socialite', [
            'socialAccounts' => $request->user()->userSocialAccounts->pluck('provider_name'),
        ]);
    }
}