@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<style>
    /* ===== Modern Auth UI (Villa Diana vibe) ===== */
    .auth-wrap{
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        padding: 3rem 0;
        background:
            radial-gradient(900px circle at 15% 20%, rgba(254,161,22,.18), transparent 55%),
            radial-gradient(800px circle at 85% 25%, rgba(15,23,43,.18), transparent 55%),
            radial-gradient(900px circle at 60% 90%, rgba(254,161,22,.10), transparent 55%),
            linear-gradient(180deg, #f7f8fb 0%, #ffffff 55%, #f7f8fb 100%);
    }

    .auth-card{
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 14px 40px rgba(15, 23, 43, .12);
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(10px);
    }

    .auth-card .auth-left{
        background:
            radial-gradient(900px circle at 20% 30%, rgba(254,161,22,.35), transparent 55%),
            linear-gradient(135deg, #0F172B 0%, #111c39 60%, #0F172B 100%);
        color: #fff;
        padding: 2.25rem;
        height: 100%;
        position: relative;
    }

    .auth-logo{
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
    }

    .auth-title{
        font-weight: 800;
        letter-spacing: -.3px;
        margin-top: 1rem;
        margin-bottom: .25rem;
    }

    .auth-subtitle{
        color: rgba(255,255,255,.72);
        margin-bottom: 1.5rem;
        font-size: .95rem;
    }

    .auth-feature{
        display: flex;
        gap: .75rem;
        margin-top: .85rem;
        color: rgba(255,255,255,.85);
        font-size: .92rem;
    }
    .auth-feature i{
        color: #FEA116;
        margin-top: .2rem;
    }

    .auth-right{
        padding: 2.25rem;
    }

    .form-control, .form-select{
        border-radius: 12px;
    }

    /* More consistent padding for floating inputs */
    .form-floating > .form-control{
        padding-left: 3rem !important;
        padding-right: 3rem !important;
    }

    /* ===== ICON ALIGNMENT FIX (MAIL + LOCK) ===== */
    .form-floating.position-relative{
        position: relative;
    }

    .floating-icon{
        position: absolute;
        left: 18px;
        top: calc((3.5rem + 2px) / 2);
        transform: translateY(-50%);
        color: #6b7280;
        pointer-events: none;
        font-size: 1rem;
        z-index: 5;
        line-height: 1;
    }

    /* Keep icon aligned even when invalid border shows */
    .form-control.is-invalid,
    .was-validated .form-control:invalid{
        background-position: right calc(.75em + 2.2rem) center !important;
        padding-right: 3.5rem !important;
    }

    /* Prevent invalid-feedback from pushing layout weirdly */
    .invalid-feedback{
        margin-top: .35rem;
    }

    /* ===== EYE BUTTON ALIGNMENT FIX ===== */
    .eye-btn{
        position: absolute;
        right: 12px;
        top: calc((3.5rem + 2px) / 2);
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #6b7280;
        padding: .35rem .45rem;
        border-radius: 10px;
        z-index: 6;
        line-height: 1;
    }
    .eye-btn:hover{
        background: rgba(15,23,43,.06);
        color: #0F172B;
    }

    .btn-vd{
        background: #FEA116;
        border-color: #FEA116;
        color: #0F172B;
        font-weight: 700;
        letter-spacing: .2px;
        border-radius: 12px;
        padding: .85rem 1rem;
        box-shadow: 0 10px 20px rgba(254,161,22,.25);
    }
    .btn-vd:hover{
        background: #ffb13a;
        border-color: #ffb13a;
        color: #0F172B;
    }

    .btn-google{
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #111827;
        font-weight: 700;
        padding: .8rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .55rem;
    }
    .btn-google:hover{
        background: #f9fafb;
        color: #111827;
        border-color: #d1d5db;
    }

    .google-mark{
        width: 18px;
        height: 18px;
        flex: 0 0 18px;
    }

    .auth-links a{
        color: #FEA116;
        font-weight: 600;
        text-decoration: none;
    }
    .auth-links a:hover{
        text-decoration: underline;
    }

    .divider{
        display:flex;
        align-items:center;
        gap:.75rem;
        color:#9ca3af;
        font-size:.85rem;
        margin: 1rem 0 0;
    }
    .divider:before, .divider:after{
        content:"";
        flex:1;
        height:1px;
        background: #e5e7eb;
    }

    @media (max-width: 991.98px){
        .auth-right{ padding: 1.75rem; }
        .auth-card .auth-left{ padding: 1.75rem; }
    }
</style>

@php
    // ✅ Redirect persistence: request -> session fallback
    $redirect = request('redirect') ?? session('redirect');

    // store it so it survives refresh / validation errors
    if ($redirect) {
        session(['redirect' => $redirect, 'url.intended' => $redirect]);
    }
@endphp

<div class="auth-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-9 col-xl-8">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-left">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="auth-logo">
                                        <i class="fa-solid fa-hotel fa-lg"></i>
                                    </div>
                                </div>

                                <h3 class="auth-title">Welcome back</h3>
                                <p class="auth-subtitle">
                                    Log in to manage your bookings and reservations with Villa Diana Hotel.
                                </p>

                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Fast booking updates & notifications</div>
                                </div>
                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>View and track your reservations easily</div>
                                </div>
                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Safe & secure account access</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="auth-right">

                                @if(session('login_err'))
                                    <div class="alert alert-danger rounded-3">
                                        {{ session('login_err') }}
                                    </div>
                                @endif

                                @if(session('google_error'))
                                    <div class="alert alert-danger rounded-3">
                                        {{ session('google_error') }}
                                        @if(session('google_suggest_create'))
                                            <div class="mt-2 auth-links">
                                                <a href="{{ route('register', $redirect ? ['redirect' => $redirect] : []) }}">Create account</a>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if($errors->any() && !$errors->has('login_err'))
                                    <div class="alert alert-danger rounded-3">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fw-bold" style="color:#0F172B;">Log in</h4>
                                        <p class="mb-0 text-muted">Enter your details to continue.</p>
                                    </div>
                                </div>

                                {{-- ✅ Keep action simple; redirect goes via hidden input --}}
                                <form novalidate method="POST" action="{{ route('login') }}">
                                    @csrf

                                    @if($redirect)
                                        <input type="hidden" name="redirect" value="{{ $redirect }}">
                                    @endif

                                    <div class="form-floating position-relative mb-3">
                                        <i class="fa-solid fa-envelope floating-icon"></i>
                                        <input
                                            type="text"
                                            name="login"
                                            id="login"
                                            value="{{ old('login') }}"
                                            class="form-control @error('login') is-invalid @enderror"
                                            placeholder="Email or full name"
                                            required
                                            autocomplete="off"
                                        >
                                        <label for="login" class="ps-5">Email or Full Name</label>

                                        @error('login')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-floating position-relative mb-2">
                                        <i class="fa-solid fa-lock floating-icon"></i>
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password"
                                            required
                                            autocomplete="current-password"
                                        >
                                        <label for="password" class="ps-5">Password</label>

                                        <button type="button" class="eye-btn" onclick="togglePassword()" aria-label="Toggle password visibility">
                                            <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                        </button>

                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end mb-3 auth-links">
                                        <a href="{{ route('password.request') }}">Forgot password?</a>
                                    </div>

                                    <button type="submit" class="btn btn-vd w-100">
                                        <i class="fa-solid fa-right-to-bracket me-2"></i> Log In
                                    </button>

                                    <a
                                        href="{{ route('auth.google.login', $redirect ? ['redirect' => $redirect] : []) }}"
                                        class="btn btn-google w-100 mt-2"
                                    >
                                        <svg class="google-mark" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
                                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.655 32.657 29.21 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.841 1.154 7.959 3.041l5.657-5.657C34.047 6.053 29.287 4 24 4 12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.841 1.154 7.959 3.041l5.657-5.657C34.047 6.053 29.287 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                                            <path fill="#4CAF50" d="M24 44c5.186 0 9.862-1.977 13.409-5.192l-6.19-5.238C29.144 35.091 26.663 36 24 36c-5.189 0-9.625-3.329-11.293-7.946l-6.522 5.025C9.497 39.556 16.688 44 24 44z"/>
                                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.055 12.055 0 0 1-4.084 5.571l.003-.002 6.19 5.238C36.971 39.21 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                                        </svg>
                                        <span>Continue with Google</span>
                                    </a>

                                    <div class="divider">or</div>

                                    <p class="text-center mt-3 mb-0 auth-links">
                                        Don’t have an account?
                                        <a href="{{ route('register', $redirect ? ['redirect' => $redirect] : []) }}">Create one</a>
                                    </p>
                                </form>

                                <p class="text-center text-muted mt-3 mb-0" style="font-size:.85rem;">
                                    By continuing, you agree to our terms and privacy policy.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-lg-none text-center mt-3 text-muted" style="font-size:.9rem;">
                    <i class="fa-solid fa-location-dot me-1"></i> Villa Diana Hotel • Booking & Reservation
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    if (!password || !icon) return;

    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
