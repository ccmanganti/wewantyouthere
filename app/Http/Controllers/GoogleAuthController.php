<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Throwable;

class GoogleAuthController extends Controller
{
    private function configured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }

    public function redirect(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/app');
        }

        if (! $this->configured()) {
            return redirect('/app/login')->withErrors([
                'google' => 'Google sign-in is not available yet. Please use email and password.',
            ]);
        }

        // Stateful OAuth keeps Laravel's CSRF state protection for the callback.
        return Socialite::driver('google')->scopes(['openid', 'email', 'profile'])->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        if (! $this->configured()) {
            return redirect('/app/login')->withErrors(['google' => 'Google sign-in is not configured.']);
        }

        if ($request->has('error')) {
            return redirect('/app/login')->withErrors([
                'google' => 'Google sign-in was cancelled or could not be completed.',
            ]);
        }

        try {
            // Do not call stateless(); Socialite checks Google's OAuth state.
            $google = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            Log::warning('Google sign-in failed during callback', ['exception' => get_class($exception)]);

            return redirect('/app/login')->withErrors([
                'google' => 'Could not sign in with Google. Please try again or use your email and password.',
            ]);
        }

        $identity = trim((string) $google->getId());
        $email = mb_strtolower(trim((string) $google->getEmail()));

        // Only a Google-verified email can be used to link an existing local account.
        $raw = is_array($google->user ?? null) ? $google->user : [];
        $verified = in_array(
            $raw['email_verified'] ?? $raw['verified_email'] ?? false,
            [true, 1, 'true', '1'],
            true,
        );

        if (! $verified || $identity === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/app/login')->withErrors([
                'google' => 'Google did not provide a verified email address. Please use email and password.',
            ]);
        }

        try {
            $user = DB::transaction(function () use ($identity, $email, $google) {
                $user = User::query()->where('google_id', $identity)->lockForUpdate()->first();

                if (! $user) {
                    $user = User::query()->where('email', $email)->lockForUpdate()->first();

                    if ($user && $user->google_id && $user->google_id !== $identity) {
                        return null; // Never replace an existing Google identity.
                    }
                }

                if (! $user) {
                    $user = User::create([
                        'name' => Str::limit(trim((string) $google->getName()) ?: 'Invitation Creator', 120, ''),
                        'email' => $email,
                        // Never store Google access tokens; local password stays unpredictable.
                        'password' => Str::random(64),
                    ]);
                    $user->assignRole(Role::findOrCreate('User', 'web'));
                }

                if (! $user->google_id) {
                    $user->forceFill(['google_id' => $identity])->save();
                }

                if (! $user->email_verified_at) {
                    $user->forceFill(['email_verified_at' => now()])->save();
                }

                return $user;
            });
        } catch (Throwable $exception) {
            Log::error('Google sign-in account linking failed', ['exception' => get_class($exception)]);

            return redirect('/app/login')->withErrors([
                'google' => 'We could not complete account setup. Please try again or use email sign-in.',
            ]);
        }

        if (! $user) {
            return redirect('/app/login')->withErrors([
                'google' => 'This account is linked to another Google identity. Please use email sign-in.',
            ]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        // The existing Filament middleware resumes an invitation awaiting publication.
        return redirect('/app');
    }
}
