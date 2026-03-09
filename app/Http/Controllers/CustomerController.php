<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Persist redirect across: register -> sendOtp -> verifyOtp -> registerFinal
     * Accepts redirect from query or post, stores in session('redirect').
     */
    private function persistRedirect(Request $request): void
    {
        $redirect = $request->input('redirect') ?? $request->query('redirect') ?? session('redirect');

        if (is_string($redirect)) {
            $redirect = trim($redirect);

            // Only store "safe" internal redirects. Prevent open-redirect attacks.
            // Allow:
            // - full internal path: /booking/summary?... (starts with /)
            // - route-like string without scheme/host
            if ($redirect !== '') {
                // If they passed a full URL (http/https), convert to internal path + query
                if (preg_match('#^https?://#i', $redirect)) {
                    $path = parse_url($redirect, PHP_URL_PATH) ?: '/';
                    $query = parse_url($redirect, PHP_URL_QUERY);
                    $redirect = $path . ($query ? '?' . $query : '');
                }

                // Only allow safe internal redirects
                if (str_starts_with($redirect, '/') && !str_starts_with($redirect, '//')) {
                    session(['redirect' => $redirect]);
                    session(['url.intended' => $redirect]);
                }
            }
        }
    }

    public function showRegisterForm(Request $request)
    {
        $this->persistRedirect($request);

        // Save booking intent (if they came from room booking)
        if ($request->filled('room_id')) {
            session([
                'booking_intent' => [
                    'room_id' => (int) $request->room_id,
                    'query'   => $request->except('_token'),
                ]
            ]);
        }

        return view('auth.register');
    }

    private function normalizeName(?string $name): ?string
    {
        if ($name === null) return null;
        return trim(preg_replace('/\s+/', ' ', $name));
    }

    private function normalizePhone(?string $phone): ?string
    {
        if ($phone === null) return null;

        $digits = preg_replace('/\D+/', '', $phone);

        // Convert 63xxxxxxxxxx to 09xxxxxxxxx
        if (strlen($digits) === 12 && str_starts_with($digits, '63')) {
            $digits = '0' . substr($digits, 2);
        }

        return $digits;
    }

    public function sendOtp(Request $request)
{
    $this->persistRedirect($request);

    $request->merge([
        'name'  => $this->normalizeName($request->input('name')),
        'email' => $request->filled('email') ? strtolower(trim($request->email)) : $request->email,
    ]);

    $request->validate([
        'name' => [
            'required',
            'string',
            'min:2',
            'max:255',
            'regex:/^[A-Za-z]+(?:[ .\'-][A-Za-z]+)*$/',
            'unique:users,name',
        ],
        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
        ],
        'privacy' => 'accepted',
    ], [
        'name.regex'        => 'Full name must contain letters only (spaces, dot, apostrophe, hyphen allowed).',
        'name.unique'       => 'That full name is already registered.',
        'email.unique'      => 'That email is already registered.',
        'privacy.accepted'  => 'You must agree to the Data Privacy Policy.',
    ]);

    // Rate limit: 1 OTP per 60s per email+ip
    $key = 'send-otp:' . strtolower($request->email) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 1)) {
        $seconds = RateLimiter::availableIn($key);
        session(['otp_sent' => true]);

        return back()
            ->withInput()
            ->withErrors(['email' => "OTP already sent. Please wait {$seconds} seconds and try again."]);
    }

    RateLimiter::hit($key, 60);

    // New OTP request => reset OTP session
    session()->forget(['otp', 'otp_expires_at', 'otp_resend_available_at', 'otp_verified']);

    $otp = random_int(100000, 999999);

    session([
        'register_name'           => $request->name,
        'register_email'          => $request->email,
        'otp'                     => $otp,
        'otp_expires_at'          => now()->addMinutes(5)->timestamp,
        'otp_resend_available_at' => now()->addSeconds(60)->timestamp,
        'otp_verified'            => false,
        'otp_sent'                => true,
    ]);

    try {
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Your Villa Diana Hotel Verification Code');
        });
    } catch (\Exception $e) {
        \Log::error('OTP mail failed: ' . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['email' => 'Failed to send OTP email. Please try again later.']);
    }

    return back()->withInput()->with('success', 'OTP sent to your email.');
}

    public function verifyOtp(Request $request)
    {
        $this->persistRedirect($request);

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.digits' => 'OTP must be exactly 6 digits.',
        ]);

        // Keep UI on Step 2 during verify attempts
        session(['otp_sent' => true]);

        $sentOtp   = session('otp');
        $expiresAt = session('otp_expires_at');

        if (!$sentOtp || !$expiresAt) {
            return back()->with('otp_error', 'No OTP request found. Please request a new OTP.');
        }

        if (now()->timestamp > (int) $expiresAt) {
            session()->forget(['otp', 'otp_expires_at', 'otp_resend_available_at', 'otp_verified']);
            session(['otp_sent' => true]);

            return back()->with('otp_error', 'OTP expired. Please request a new one.');
        }

        if ((string) $request->otp !== (string) $sentOtp) {
            return back()->with('otp_error', 'Invalid OTP. Please try again.');
        }

        session([
            'otp_verified' => true,
            'otp_sent'     => true,
        ]);

        return back()->with('success', 'OTP verified. Please set your password.');
    }

    public function registerFinal(Request $request)
    {
        $this->persistRedirect($request);

        if (!session('otp_verified')) {
            return redirect()->route('register', session('redirect') ? ['redirect' => session('redirect')] : [])
                ->withErrors(['error' => 'Please verify OTP first.']);
        }

        $name  = session('register_name');
        $email = session('register_email');

        if (!$name || !$email) {
            return redirect()->route('register', session('redirect') ? ['redirect' => session('redirect')] : [])
                ->withErrors(['error' => 'Registration session expired. Please start again.']);
        }

        $request->merge([
            'phone' => $this->normalizePhone($request->input('phone')),
        ]);

        $request->validate([
            'phone' => [
                'required',
                'digits:11',
                'unique:users,phone',
            ],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'terms' => 'accepted',
        ], [
            'phone.required'  => 'Phone number is required.',
            'phone.digits'    => 'Phone number must be exactly 11 digits (e.g., 09XXXXXXXXX).',
            'phone.unique'    => 'That phone number is already registered.',
            'password.min'    => 'Password must be at least 8 characters.',
            'password.regex'  => 'Password must contain at least 1 uppercase letter, 1 number, and 1 symbol.',
            'terms.accepted'  => 'You must agree to the Terms and Conditions.',
        ]);

        // Final safety re-check
        if (User::where('name', $name)->exists()) {
            return redirect()->route('register', session('redirect') ? ['redirect' => session('redirect')] : [])
                ->withErrors(['error' => 'That full name is already registered.']);
        }
        if (User::where('email', $email)->exists()) {
            return redirect()->route('register', session('redirect') ? ['redirect' => session('redirect')] : [])
                ->withErrors(['error' => 'That email is already registered.']);
        }

        $user = User::create([
            'name'              => $name,
            'email'             => $email,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'password'          => Hash::make($request->password),
            'is_admin'          => 0,
            'email_verified_at' => now(),
        ]);

        // Clear OTP + registration session (keep redirect until after we use it)
        session()->forget([
            'otp',
            'otp_expires_at',
            'otp_resend_available_at',
            'otp_verified',
            'otp_sent',
            'register_name',
            'register_email',
        ]);

        Auth::login($user);

        // ✅ Prefer explicit session redirect, fallback to intended, fallback home
        $to = session('redirect') ?? session('url.intended');

        // Once used, you can forget redirect (optional)
        session()->forget(['redirect', 'url.intended']);

        if ($to) {
            return redirect($to)->with('success', 'Account created successfully! You can continue your booking.');
        }

        return redirect()->route('home')->with('success', 'Account created successfully! You can continue your booking.');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        if ($user) {
            $user->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Your account has been deleted successfully.');
    }
}
