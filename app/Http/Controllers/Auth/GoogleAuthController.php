<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Keep redirect intent (e.g., booking summary) through Google OAuth round-trip.
     */
    private function persistRedirect(Request $request): void
    {
        $redirect = $request->input('redirect') ?? $request->query('redirect') ?? session('redirect');

        if (!is_string($redirect)) {
            return;
        }

        $redirect = trim($redirect);
        if ($redirect === '') {
            return;
        }

        // Convert full internal URL to path+query if needed.
        if (preg_match('#^https?://#i', $redirect)) {
            $path = parse_url($redirect, PHP_URL_PATH) ?: '/';
            $query = parse_url($redirect, PHP_URL_QUERY);
            $redirect = $path . ($query ? '?' . $query : '');
        }

        if (str_starts_with($redirect, '/') && !str_starts_with($redirect, '//')) {
            session([
                'redirect' => $redirect,
                'url.intended' => $redirect,
            ]);
        }
    }

    private function missingGoogleConfigKeys(): array
    {
        $missing = [];

        if (!filled(config('services.google.client_id'))) {
            $missing[] = 'GOOGLE_CLIENT_ID';
        }

        if (!filled(config('services.google.client_secret'))) {
            $missing[] = 'GOOGLE_CLIENT_SECRET';
        }

        if (!filled(config('services.google.redirect'))) {
            $missing[] = 'GOOGLE_REDIRECT_URI';
        }

        return $missing;
    }

    private function googleConfigErrorMessage(): string
    {
        $missing = $this->missingGoogleConfigKeys();

        if (empty($missing)) {
            return 'Google authentication is not configured yet.';
        }

        return 'Google authentication is not configured yet. Missing: ' . implode(', ', $missing) . '.';
    }

    private function routeParamsWithRedirect(): array
    {
        $redirect = session('redirect');

        return $redirect ? ['redirect' => $redirect] : [];
    }

    public function redirectToGoogleForLogin(Request $request): RedirectResponse
    {
        return $this->redirectToGoogle($request, 'login');
    }

    public function redirectToGoogleForRegister(Request $request): RedirectResponse
    {
        return $this->redirectToGoogle($request, 'register');
    }

    private function redirectToGoogle(Request $request, string $mode): RedirectResponse
    {
        $this->persistRedirect($request);

        if (!empty($this->missingGoogleConfigKeys())) {
            return $this->redirectWithModeError($mode, $this->googleConfigErrorMessage());
        }

        $state = Str::random(40);

        session([
            'google_oauth_state' => $state,
            'google_auth_mode' => $mode,
        ]);

        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $expectedState = (string) session()->pull('google_oauth_state', '');
        $mode = (string) session()->pull('google_auth_mode', 'login');

        $incomingState = (string) $request->query('state', '');
        if ($expectedState === '' || $incomingState === '' || !hash_equals($expectedState, $incomingState)) {
            return $this->redirectWithModeError($mode, 'Google authentication was cancelled or expired. Please try again.');
        }

        if ($request->filled('error')) {
            return $this->redirectWithModeError($mode, 'Google authentication was not completed.');
        }

        if (!empty($this->missingGoogleConfigKeys())) {
            return $this->redirectWithModeError($mode, $this->googleConfigErrorMessage());
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => (string) $request->query('code', ''),
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.google.redirect'),
            'grant_type' => 'authorization_code',
        ]);

        if (!$tokenResponse->ok()) {
            return $this->redirectWithModeError($mode, 'Unable to sign in with Google right now. Please try again.');
        }

        $accessToken = (string) $tokenResponse->json('access_token', '');
        if ($accessToken === '') {
            return $this->redirectWithModeError($mode, 'Google sign-in token was not returned.');
        }

        $profileResponse = Http::withToken($accessToken)->get('https://openidconnect.googleapis.com/v1/userinfo');

        if (!$profileResponse->ok()) {
            return $this->redirectWithModeError($mode, 'Unable to fetch Google profile details.');
        }

        $profile = $profileResponse->json();

        $googleId = trim((string) data_get($profile, 'sub'));
        $email = strtolower(trim((string) data_get($profile, 'email')));
        $name = trim((string) data_get($profile, 'name'));
        $avatar = trim((string) data_get($profile, 'picture'));
        $emailVerified = filter_var(data_get($profile, 'email_verified', false), FILTER_VALIDATE_BOOLEAN);

        if ($googleId === '' || $email === '' || !$emailVerified) {
            return $this->redirectWithModeError($mode, 'Google account must have a verified email address.');
        }

        if ($mode === 'register') {
            return $this->registerWithGoogle($googleId, $email, $name, $avatar);
        }

        return $this->loginWithGoogle($googleId, $email, $avatar);
    }

    private function loginWithGoogle(string $googleId, string $email, string $avatar): RedirectResponse
    {
        $user = User::where('google_id', $googleId)->first();

        if (!$user) {
            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();
        }

        if (!$user) {
            return redirect()
                ->route('login', $this->routeParamsWithRedirect())
                ->with('google_error', 'No account found for this Google account. Please create one first.')
                ->with('google_suggest_create', true);
        }

        $updates = [];

        if (!$user->google_id) {
            $updates['google_id'] = $googleId;
        }

        if (!$user->email_verified_at) {
            $updates['email_verified_at'] = now();
        }

        if ($avatar !== '' && !$user->avatar) {
            $updates['avatar'] = $avatar;
        }

        if (!empty($updates)) {
            $user->update($updates);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return $this->redirectAfterLogin('Signed in with Google successfully.');
    }

    private function registerWithGoogle(string $googleId, string $email, string $name, string $avatar): RedirectResponse
    {
        $existingByGoogle = User::where('google_id', $googleId)->first();
        $existingByEmail = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($existingByGoogle || $existingByEmail) {
            return redirect()
                ->route('login', $this->routeParamsWithRedirect())
                ->with('google_error', 'Account already exists. Please log in with Google from the login page.');
        }

        $displayName = trim(preg_replace('/\s+/', ' ', $name !== '' ? $name : Str::before($email, '@'))) ?: 'Google User';

        $existingByName = User::whereRaw('LOWER(name) = ?', [mb_strtolower($displayName)])->first();
        if ($existingByName) {
            return redirect()
                ->route('register', $this->routeParamsWithRedirect())
                ->withErrors(['error' => 'That full name is already registered. Google account creation was stopped.']);
        }

        $user = User::create([
            'name' => $displayName,
            'email' => $email,
            'password' => Hash::make(Str::random(48)),
            'phone' => null,
            'address' => null,
            'avatar' => $avatar !== '' ? $avatar : null,
            'is_admin' => 0,
            'email_verified_at' => now(),
            'google_id' => $googleId,
            'auth_provider' => 'google',
        ]);

        // Google registration should not continue OTP flow state.
        session()->forget([
            'otp',
            'otp_expires_at',
            'otp_resend_available_at',
            'otp_verified',
            'otp_sent',
            'register_name',
            'register_email',
        ]);

        Auth::login($user, true);
        request()->session()->regenerate();

        return $this->redirectAfterLogin('Account created with Google successfully.');
    }

    private function redirectAfterLogin(string $successMessage): RedirectResponse
    {
        if ((int) Auth::user()->is_admin === 1) {
            session()->forget(['redirect', 'url.intended']);

            return redirect('/admin')->with('success', $successMessage);
        }

        $to = session('redirect') ?? session('url.intended');
        session()->forget(['redirect', 'url.intended']);

        if ($to) {
            return redirect($to)->with('success', $successMessage);
        }

        return redirect()->route('home')->with('success', $successMessage);
    }

    private function redirectWithModeError(string $mode, string $message): RedirectResponse
    {
        if ($mode === 'register') {
            return redirect()
                ->route('register', $this->routeParamsWithRedirect())
                ->withErrors(['error' => $message]);
        }

        return redirect()
            ->route('login', $this->routeParamsWithRedirect())
            ->with('google_error', $message);
    }
}
