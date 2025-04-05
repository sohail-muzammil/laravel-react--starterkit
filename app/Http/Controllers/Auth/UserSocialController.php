<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Models\OauthProvider;
use App\Models\UserSocial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class UserSocialController extends Controller
{
    public function redirect(string $providerName): RedirectResponse
    {
        return Inertia::location(
            Socialite::driver($providerName)->stateless()->redirect()->getTargetUrl()
        );
    }

    public function callback(string $providerName): RedirectResponse
    {
        try {
            $socialiteUser = Socialite::driver($providerName)->stateless()->user();

            $oauthProviderId = OauthProvider::where('name', $providerName)->value('id');

            if (Auth::check()) {
                try {
                    $this->connectSocialAccount(Auth::user(), $socialiteUser, $oauthProviderId);
                    return to_route('dashboard')->with('success', ucfirst($oauthProviderId) . ' account connected successfully.');
                } catch (Exception $e) {
                    return to_route('dashboard')->withErrors(['error' => $e->getMessage()]);
                }
            }

            $user = User::with('userSocialAccounts')
                ->where('email', $socialiteUser->getEmail())
                ->first();

            if ($user) {
                if (!$this->hasSocialAccount($user, $oauthProviderId, $socialiteUser->getId())) {
                    return to_route('login')->withErrors([
                        'error' => ucfirst($oauthProviderId) . ' account not connected. Sign up or use another method.'
                    ]);
                }

                Auth::login($user);
            } else {
                $userSocialAccount = $this->findOrCreateProviderUser($socialiteUser, $oauthProviderId);
                Auth::login($userSocialAccount->user);
            }

            request()->session()->regenerate();
            return to_route('dashboard');
        } catch (Exception $e) {
            Log::error('Socialite callback error: ' . $e->getMessage());
            return to_route('login')->withErrors(['error' => 'Login failed. Please try again.']);
        }
    }

    private function connectSocialAccount(User $user, SocialiteUser $socialiteUser, string $oauthProviderId): void
    {
        if (UserSocial::where('oauth_provider_id', $oauthProviderId)
            ->where('social_id', $socialiteUser->getId())
            ->exists()
        ) {
            throw new Exception(ucfirst($oauthProviderId) . ' account is already linked to another user.');
        }

        if ($user->userSocialAccounts()->where('oauth_provider_id', $oauthProviderId)->exists()) {
            throw new Exception(ucfirst($oauthProviderId) . ' account is already connected.');
        }

        $this->createSocialAccount($user, $socialiteUser, $oauthProviderId);
    }

    private function createSocialAccount(User $user, SocialiteUser $socialiteUser, string $oauthProviderId): UserSocial
    {
        return $user->userSocialAccounts()->create([
            'oauth_provider_id' => $oauthProviderId,
            'social_id' => $socialiteUser->getId(),
            'nickname' => $socialiteUser->getNickname(),
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
            'avatar' => $socialiteUser->getAvatar(),
            'data' => json_encode($socialiteUser->user),
            'token' => $socialiteUser->token,
            'refresh_token' => $socialiteUser->refreshToken,
            'token_expires_at' => $socialiteUser->expiresIn ? now()->addSeconds($socialiteUser->expiresIn) : null,
        ]);
    }

    private function findOrCreateProviderUser(SocialiteUser $socialiteUser, string $oauthProviderId): UserSocial
    {
        return DB::transaction(function () use ($socialiteUser, $oauthProviderId) {
            $providerAccount = UserSocial::firstOrNew([
                'oauth_provider_id' => $oauthProviderId,
                'social_id' => $socialiteUser->getId(),
            ]);

            if ($providerAccount->exists) {
                return $providerAccount;
            }

            $user = User::firstOrCreate(
                ['email' => $socialiteUser->getEmail()],
                [
                    'name' => $socialiteUser->getName(),
                    'email_verified_at' => now(),
                ]
            );

            return $this->createSocialAccount($user, $socialiteUser, $oauthProviderId);
        });
    }

    public function disconnect(string $oauthProviderId): RedirectResponse
    {
        try {
            $socialAccount = Auth::user()->userSocialAccounts()
                ->where('oauth_provider_id', $oauthProviderId)
                ->firstOrFail();

            $socialAccount->delete();
            return to_route('dashboard')->with('success', ucfirst($oauthProviderId) . ' account disconnected.');
        } catch (Exception $e) {
            return to_route('dashboard')->withErrors(['error' => 'Disconnection failed. Try again.']);
        }
    }

    private function hasSocialAccount(User $user, string $oauthProviderId, string $socialId): bool
    {
        return $user->userSocialAccounts
            ->where('oauth_provider_id', $oauthProviderId)
            ->where('social_id', $socialId)
            ->isNotEmpty();
    }
}