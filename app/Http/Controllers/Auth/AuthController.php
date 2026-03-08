<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Persist redirect so intended() returns user back to booking summary.
     * Works for both:
     * - GET /login?redirect=...
     * - POST /login (hidden input redirect)
     */
    private function persistRedirect(Request $request): void
    {
        $redirect = $request->input('redirect')
            ?? $request->query('redirect')
            ?? session('redirect');

        if ($redirect) {
            session([
                'redirect' => $redirect,
                'url.intended' => $redirect,
            ]);
        }
    }

    private function passwordMatchesAnyUser(string $plainPassword): bool
    {
        foreach (User::select(['id', 'password'])->cursor() as $candidate) {
            if (Hash::check($plainPassword, (string) $candidate->password)) {
                return true;
            }
        }

        return false;
    }

    public function showLoginForm(Request $request)
    {
        $this->persistRedirect($request);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->persistRedirect($request);

        $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email or full name is required.',
            'password.required' => 'Password is required.',
        ]);

        $loginInput = trim((string) $request->input('login'));
        $password = (string) $request->input('password');
        $isEmailInput = filter_var($loginInput, FILTER_VALIDATE_EMAIL) !== false;

        if ($isEmailInput) {
            $user = User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
        } else {
            $user = User::whereRaw('LOWER(name) = ?', [mb_strtolower($loginInput)])->first();
        }

        if (!$user) {
            $message = 'Invalid credentials';

            if ($isEmailInput) {
                $message = $this->passwordMatchesAnyUser($password)
                    ? 'Invalid credentials'
                    : 'Email not found';
            }

            return back()
                ->withErrors(['login' => $message])
                ->withInput($request->except('password'));
        }

        if (!Hash::check($password, (string) $user->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password try again'])
                ->withInput($request->except('password'));
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ((int) Auth::user()->is_admin === 1) {
            session()->forget(['redirect', 'url.intended']);
            return redirect('/admin');
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Optional: clear stored redirect so logout doesn't revive booking flow
        session()->forget(['redirect', 'url.intended']);

        return redirect()->route('home');
    }
}
