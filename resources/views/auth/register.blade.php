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
    }

    .auth-badge{
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .4rem .75rem;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        font-size: .85rem;
        letter-spacing: .2px;
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
    .auth-feature i{ color:#FEA116; margin-top:.2rem; }

    .auth-right{ padding: 2.25rem; }

    .form-control, .form-select{ border-radius: 12px; }
    .form-floating > .form-control{ padding-left: 2.75rem; }

    .floating-icon{
        position: absolute;
        left: .95rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        pointer-events: none;
        font-size: 1rem;
        z-index: 2;
    }

    .eye-btn{
        position: absolute;
        right: .75rem;
        top: 50%;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #6b7280;
        padding: .35rem .45rem;
        border-radius: 10px;
        z-index: 3;
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
    .btn-vd:hover{ background:#ffb13a; border-color:#ffb13a; color:#0F172B; }
    .btn-vd:disabled{
        opacity: .55;
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-ghost{
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #0F172B;
        font-weight: 600;
        padding: .75rem 1rem;
    }
    .btn-ghost:hover{ background: #f9fafb; }

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
    .auth-links a:hover{ text-decoration: underline; }

    .divider{
        display:flex;
        align-items:center;
        gap:.75rem;
        color:#9ca3af;
        font-size:.85rem;
        margin: 0;
    }
    .divider:before, .divider:after{
        content:"";
        flex:1;
        height:1px;
        background: #e5e7eb;
    }

    .password-rules{
        margin: 0 0 1rem;
        padding: .75rem .85rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
    }
    .password-rule{
        display: flex;
        align-items: center;
        gap: .5rem;
        color: #64748b;
        font-size: .88rem;
        line-height: 1.3;
    }
    .password-rule + .password-rule{
        margin-top: .35rem;
    }
    .password-rule i{
        color: #94a3b8;
        font-size: .6rem;
        transition: color .15s ease;
    }
    .password-rule.is-met{
        color: #166534;
        font-weight: 600;
    }
    .password-rule.is-met i{
        color: #16a34a;
    }

    .password-match-indicator{
        font-size: .78rem;
        font-weight: 600;
        color: #94a3b8;
        min-height: 1rem;
    }
    .password-match-indicator.is-match{
        color: #16a34a;
    }
    .password-match-indicator.is-mismatch{
        color: #dc2626;
    }

    /* Stepper */
    .stepper{
        display:flex;
        gap: .65rem;
        justify-content:center;
        align-items:center;
        margin: 1rem 0 1.25rem;
        flex-wrap: wrap;
    }
    .step{
        display:flex;
        align-items:center;
        gap:.5rem;
        padding:.35rem .65rem;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background:#fff;
        color:#6b7280;
        font-size:.85rem;
        font-weight: 600;
    }
    .step .dot{
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display:grid;
        place-items:center;
        border: 1px solid #e5e7eb;
        background:#fff;
        font-weight: 800;
        color:#9ca3af;
        font-size:.85rem;
    }
    .step.active{
        border-color: rgba(254,161,22,.5);
        box-shadow: 0 8px 18px rgba(254,161,22,.12);
        color:#0F172B;
    }
    .step.active .dot{
        border-color: rgba(254,161,22,.5);
        background: rgba(254,161,22,.12);
        color:#0F172B;
    }
    .step.done{
        border-color: rgba(34,197,94,.35);
        color:#0F172B;
    }
    .step.done .dot{
        border-color: rgba(34,197,94,.35);
        background: rgba(34,197,94,.12);
        color:#16a34a;
    }
    .step-sep{
        color:#d1d5db;
        font-weight: 700;
    }

    /* OTP box */
    .otp-box{
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1rem;
        background: #fff;
    }
    .otp-meta{
        display:flex;
        justify-content: space-between;
        align-items:center;
        gap: .75rem;
        flex-wrap: wrap;
        margin-top: .5rem;
        font-size: .9rem;
    }
    .timer-pill{
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        padding:.25rem .6rem;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background:#f9fafb;
        color:#111827;
        font-weight: 600;
    }

    /* ===== OTP Rounded Boxes ===== */
    .otp-inputs{
        display:flex;
        gap:12px;
        align-items:center;
        justify-content:flex-start;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .otp-digit{
        width: 54px;
        height: 56px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        text-align: center;
        font-size: 20px;
        font-weight: 800;
        color: #0F172B;
        outline: none;
        transition: .15s ease;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.7);
    }

    .otp-digit:focus{
        border-color: rgba(254,161,22,.70);
        box-shadow: 0 0 0 .2rem rgba(254,161,22,.22);
        background: #fff;
    }

    .otp-digit.is-filled{
        background: rgba(254,161,22,.10);
        border-color: rgba(254,161,22,.35);
    }

    .otp-floating{ position: relative; margin-top: 10px; }
    .otp-hint{ margin-top: 8px; color:#6b7280; font-size:.9rem; }

    /* ===== OTP Shake on error ===== */
    .otp-inputs.shake{
        animation: otp-shake .38s ease-in-out;
    }

    @keyframes otp-shake{
        0%, 100% { transform: translateX(0); }
        15% { transform: translateX(-10px); }
        30% { transform: translateX(10px); }
        45% { transform: translateX(-8px); }
        60% { transform: translateX(8px); }
        75% { transform: translateX(-5px); }
        90% { transform: translateX(5px); }
    }

    .otp-inputs.otp-error .otp-digit{
        border-color: rgba(239,68,68,.65);
        background: rgba(239,68,68,.06);
    }
    .otp-inputs.otp-error .otp-digit:focus{
        box-shadow: 0 0 0 .2rem rgba(239,68,68,.20);
    }

    /* ===== MODALS (Privacy + Terms) ===== */
    .vd-modal{
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.6);
        z-index: 9999;
        padding: 1rem;
        align-items: center;
        justify-content: center;
    }

    .vd-modal-card{
        width: min(640px, 100%);
        max-height: 85vh;
        background: rgba(255,255,255,.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,.25);
        border: 1px solid rgba(15,23,43,.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .vd-modal-head{
        display:flex;
        align-items:flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.25rem .75rem;
        margin: 0;
        position: sticky;
        top: 0;
        background: rgba(255,255,255,.97);
        backdrop-filter: blur(10px);
        z-index: 2;
        border-bottom: 1px solid rgba(15,23,43,.08);
    }

    .vd-modal-title{
        font-weight: 800;
        margin: 0;
        color:#0F172B;
        letter-spacing: -.2px;
    }

    .vd-modal-close{
        border: 0;
        background: transparent;
        font-size: 1.6rem;
        line-height: 1;
        color: #6b7280;
        cursor: pointer;
        padding: .15rem .35rem;
        border-radius: 10px;
    }
    .vd-modal-close:hover{ background: rgba(15,23,43,.06); color:#0F172B; }

    .vd-modal-body{
        padding: 1rem 1.25rem 1.25rem;
        overflow-y: auto;
        white-space: pre-line;
        flex: 1 1 auto;
    }

    .vd-modal-footer{
        padding: .85rem 1.25rem;
        position: sticky;
        bottom: 0;
        background: rgba(255,255,255,.97);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(15,23,43,.08);
        z-index: 2;
    }

    .vd-modal-footer .form-check-label{ color: #374151; font-size: .95rem; }
    .vd-modal-footer .form-check-input{ width: 1.15rem; height: 1.15rem; margin-top: .2rem; }

    @media (max-width: 991.98px){
        .auth-right{ padding: 1.75rem; }
        .auth-card .auth-left{ padding: 1.75rem; }
    }

    body.modal-open{ overflow: hidden; }
</style>

@php
    $isStep1 = (!session('otp_sent') && !session('otp_verified'));
    $isStep2 = (session('otp_sent') && !session('otp_verified'));
    $isStep3 = (session('otp_verified'));

    $redirect = request('redirect') ?? session('redirect');
@endphp

<div class="auth-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-10 col-xl-9">
                <div class="card auth-card">
                    <div class="row g-0">

                        <div class="col-lg-5 d-none d-lg-block">
                            <div class="auth-left">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="auth-logo">
                                        <i class="fa-solid fa-user-plus fa-lg"></i>
                                    </div>
                                    <div class="auth-badge">
                                        <i class="fa-solid fa-shield-halved"></i>
                                        Verified Registration
                                    </div>
                                </div>

                                <h3 class="auth-title">Create your account</h3>
                                <p class="auth-subtitle">
                                    We’ll send a one-time password (OTP) to verify your email before setting a password.
                                </p>

                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>OTP verification for security</div>
                                </div>
                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Manage bookings and reservation details</div>
                                </div>
                                <div class="auth-feature">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Quick & simple sign up process</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-7">
                            <div class="auth-right">

                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        <h4 class="mb-1 fw-bold" style="color:#0F172B;">Create Account</h4>
                                        <p class="mb-0 text-muted">Follow the steps to register.</p>
                                    </div>
                                </div>

                                @if ($errors->has('error'))
                                    <div class="alert alert-danger mb-3">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success mb-3">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="stepper">
                                    <div class="step {{ $isStep1 ? 'active' : ($isStep2 || $isStep3 ? 'done' : '') }}">
                                        <span class="dot">{{ $isStep2 || $isStep3 ? '✓' : '1' }}</span>
                                        <span>Email</span>
                                    </div>
                                    <span class="step-sep">→</span>
                                    <div class="step {{ $isStep2 ? 'active' : ($isStep3 ? 'done' : '') }}">
                                        <span class="dot">{{ $isStep3 ? '✓' : '2' }}</span>
                                        <span>OTP</span>
                                    </div>
                                    <span class="step-sep">→</span>
                                    <div class="step {{ $isStep3 ? 'active' : '' }}">
                                        <span class="dot">3</span>
                                        <span>Password</span>
                                    </div>
                                </div>

                                {{-- STEP 1 --}}
                                @if($isStep1)
                                    <a
                                        href="{{ route('auth.google.register', $redirect ? ['redirect' => $redirect] : []) }}"
                                        class="btn btn-google w-100 mb-3"
                                    >
                                        <svg class="google-mark" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
                                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.655 32.657 29.21 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.841 1.154 7.959 3.041l5.657-5.657C34.047 6.053 29.287 4 24 4 12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.841 1.154 7.959 3.041l5.657-5.657C34.047 6.053 29.287 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                                            <path fill="#4CAF50" d="M24 44c5.186 0 9.862-1.977 13.409-5.192l-6.19-5.238C29.144 35.091 26.663 36 24 36c-5.189 0-9.625-3.329-11.293-7.946l-6.522 5.025C9.497 39.556 16.688 44 24 44z"/>
                                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.055 12.055 0 0 1-4.084 5.571l.003-.002 6.19 5.238C36.971 39.21 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                                        </svg>
                                        <span>Create account with Google (No OTP)</span>
                                    </a>

                                    <div class="divider mb-3">or continue with email + OTP</div>

                                    <form method="POST" action="{{ route('send.otp') }}" id="sendOtpForm">
                                        @csrf
                                        @if($redirect)
                                            <input type="hidden" name="redirect" value="{{ $redirect }}">
                                        @endif

                                        <div class="form-floating position-relative mb-3">
                                            <i class="fa-solid fa-user floating-icon"></i>
                                            <input type="text" id="name" name="name" autocomplete="off"
                                                   class="form-control ps-5 @error('name') is-invalid @enderror"
                                                   placeholder="Full Name"
                                                   value="{{ old('name', session('register_name') ?? '') }}" required>
                                            <label for="name" class="ps-5">Full Name</label>
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-floating position-relative mb-3">
                                            <i class="fa-solid fa-envelope floating-icon"></i>
                                            <input type="email" id="email" name="email" autocomplete="off"
                                                   class="form-control ps-5 @error('email') is-invalid @enderror"
                                                   placeholder="Email Address"
                                                   value="{{ old('email', session('register_email') ?? '') }}" required>
                                            <label for="email" class="ps-5">Email Address</label>
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="d-flex align-items-start gap-2 mb-3">
                                            <input type="checkbox" class="form-check-input mt-1" id="privacy" name="privacy" required disabled>
                                            <label class="form-check-label" for="privacy" style="font-size:.95rem;">
                                                I agree to the <a href="#" class="auth-links" id="privacyLink">Data Privacy Policy</a>
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-vd w-100" id="sendOtpBtn">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Send OTP
                                        </button>
                                    </form>
                                @endif

                                {{-- STEP 2 --}}
                                @if($isStep2)
                                    @php
                                        $otpExpiresAt = session('otp_expires_at');
                                        $otpRemaining = $otpExpiresAt ? max(0, (int)$otpExpiresAt - now()->timestamp) : 0;

                                        $resendAt = session('otp_resend_available_at');
                                        $resendRemaining = $resendAt ? max(0, (int)$resendAt - now()->timestamp) : 0;
                                    @endphp

                                    <div class="otp-box mb-3">
                                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                            <div class="text-muted" style="font-size:.95rem;">
                                                We sent a code to
                                                <span class="fw-semibold" style="color:#0F172B;">
                                                    {{ session('register_email') ?? old('email') ?? 'your email' }}
                                                </span>
                                            </div>

                                            <span class="timer-pill">
                                                <i class="fa-regular fa-clock"></i>
                                                <span>
                                                    Expires:
                                                    <span id="otpTimer" data-remaining="{{ $otpRemaining }}">--:--</span>
                                                </span>
                                            </span>
                                        </div>

                                        <form method="POST" action="{{ route('verify.otp') }}" class="mt-3" id="otpForm">
                                            @csrf
                                            @if($redirect)
                                                <input type="hidden" name="redirect" value="{{ $redirect }}">
                                            @endif

                                            <div class="otp-floating mb-2">
                                                <input type="hidden" name="otp" id="otpHidden" value="">

                                                <div class="otp-inputs" id="otpInputs" aria-label="OTP input">
                                                    <input class="otp-digit" inputmode="numeric" autocomplete="one-time-code" maxlength="1" />
                                                    <input class="otp-digit" inputmode="numeric" maxlength="1" />
                                                    <input class="otp-digit" inputmode="numeric" maxlength="1" />
                                                    <input class="otp-digit" inputmode="numeric" maxlength="1" />
                                                    <input class="otp-digit" inputmode="numeric" maxlength="1" />
                                                    <input class="otp-digit" inputmode="numeric" maxlength="1" />
                                                </div>

                                                @error('otp') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                                <div class="otp-hint">
                                                    Enter the 6-digit code from your email. Verification will continue automatically once complete.
                                                </div>
                                            </div>

                                            @if(session('otp_error'))
                                                <div class="alert alert-danger mt-2 mb-0" id="otpServerError">
                                                    {{ session('otp_error') }}
                                                </div>
                                            @endif

                                            <div class="otp-meta">
                                                <div class="text-muted">
                                                    Didn’t receive the code?
                                                    <button type="button" class="btn btn-link p-0 ms-1 auth-links" id="openResend">
                                                        Resend OTP <span id="resendCountdown" class="text-muted"></span>
                                                    </button>
                                                </div>

                                                <button type="submit" class="btn btn-vd" id="verifyOtpBtn">
                                                    <i class="fa-solid fa-circle-check me-2"></i> Verify OTP
                                                </button>
                                            </div>
                                        </form>

                                        <form method="POST" action="{{ route('send.otp') }}" id="resendForm" class="d-none">
                                            @csrf
                                            @if($redirect)
                                                <input type="hidden" name="redirect" value="{{ $redirect }}">
                                            @endif
                                            <input type="hidden" name="name" value="{{ session('register_name') }}">
                                            <input type="hidden" name="email" value="{{ session('register_email') }}">
                                            <input type="hidden" name="privacy" value="1">
                                            <button type="submit" id="resendBtn" disabled>Resend OTP</button>
                                        </form>

                                        <small class="text-muted d-block mt-2">
                                            Tip: Check your spam/junk folder if you can’t find the email.
                                        </small>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('login', $redirect ? ['redirect' => $redirect] : []) }}" class="btn btn-ghost w-100">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Back to Login
                                        </a>
                                    </div>
                                @endif

                                {{-- STEP 3 --}}
                                @if($isStep3)
                                    <form method="POST" action="{{ route('register.final') }}">
                                        @csrf
                                        @if($redirect)
                                            <input type="hidden" name="redirect" value="{{ $redirect }}">
                                        @endif

                                        <div class="form-floating position-relative mb-3">
                                            <i class="fa-solid fa-phone floating-icon"></i>
                                            <input type="text" id="phone" name="phone" autocomplete="off"
                                                   class="form-control ps-5 @error('phone') is-invalid @enderror"
                                                   placeholder="Phone"
                                                   value="{{ old('phone') }}"
                                                   required
                                                   inputmode="numeric"
                                                   autocomplete="off"
                                                   maxlength="11">
                                            <label for="phone" class="ps-5">Phone</label>
                                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-floating position-relative mb-3">
                                            <i class="fa-solid fa-location-dot floating-icon"></i>
                                            <input type="text" id="address" name="address" autocomplete="off"
                                                   class="form-control ps-5 @error('address') is-invalid @enderror"
                                                   placeholder="Address" value="{{ old('address') }}">
                                            <label for="address" class="ps-5">Address</label>
                                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-floating position-relative mb-2">
                                            <i class="fa-solid fa-lock floating-icon"></i>
                                            <input type="password" id="password" name="password"
                                                   class="form-control ps-5 pe-5 @error('password') is-invalid @enderror"
                                                   placeholder="Password" required>
                                            <label for="password" class="ps-5">Password</label>

                                            <button type="button" class="eye-btn" id="togglePasswordBtn" aria-label="Toggle password visibility">
                                                <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                            </button>

                                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="password-rules" id="registerPasswordRules" aria-live="polite">
                                            <div class="password-rule" data-rule="uppercase"><i class="fa-solid fa-circle"></i>One uppercase letter</div>
                                            <div class="password-rule" data-rule="special"><i class="fa-solid fa-circle"></i>One special character</div>
                                            <div class="password-rule" data-rule="number"><i class="fa-solid fa-circle"></i>One number</div>
                                            <div class="password-rule" data-rule="length"><i class="fa-solid fa-circle"></i>At least 8 characters</div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <label for="password_confirmation" class="form-label fw-semibold mb-0">Confirm Password</label>
                                                <small id="registerMatchIndicator" class="password-match-indicator" aria-live="polite"></small>
                                            </div>

                                            <div class="position-relative">
                                                <i class="fa-solid fa-lock floating-icon"></i>
                                                <input type="password" id="password_confirmation" name="password_confirmation"
                                                       class="form-control ps-5 pe-5"
                                                       placeholder="Confirm Password" required>

                                                <button type="button" class="eye-btn" id="toggleConfirmBtn" aria-label="Toggle confirm password visibility">
                                                    <i class="fa-solid fa-eye" id="toggleIconConfirm"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-start gap-2 mb-3">
                                            <input type="checkbox" class="form-check-input mt-1" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms" style="font-size:.95rem;">
                                                I agree to the <a href="#" class="auth-links" id="termsLink">Terms and Conditions</a>
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-vd w-100" id="registerBtn" disabled>
                                            <i class="fa-solid fa-user-check me-2"></i> Create Account
                                        </button>
                                    </form>
                                @endif

                                <p class="text-center mt-3 mb-0 auth-links">
                                    Already have an account?
                                    <a href="{{ route('login', $redirect ? ['redirect' => $redirect] : []) }}">Log In</a>
                                </p>

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

{{-- PRIVACY MODAL --}}
<div id="privacyPopup" class="vd-modal" aria-hidden="true">
    <div class="vd-modal-card" role="dialog" aria-modal="true" aria-labelledby="privacyTitle">
        <div class="vd-modal-head">
            <div>
                <h4 class="vd-modal-title" id="privacyTitle">Data Privacy Notice</h4>
                <div class="text-muted" style="font-size:.9rem;">Republic Act No. 10173 (Data Privacy Act of 2012)</div>
            </div>
        </div>

        <div class="vd-modal-body">
            <div>
We respect your privacy and are committed to protecting your personal information.

By registering in the Villa Diana Hotel Booking System, you agree that we may collect,
use, and store your personal data such as your name, email address, phone number,
and address for the following purposes:

• Account registration and verification
• Booking management
• Communication regarding reservations
• System security and fraud prevention

Your information will not be shared with third parties without your consent
and will be protected in accordance with Republic Act No. 10173
(Data Privacy Act of 2012).

By continuing, you confirm that you understand and agree to this policy.
            </div>
        </div>

        <div class="vd-modal-footer">
            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                <div class="form-check m-0">
                    <input class="form-check-input" type="checkbox" id="privacyModalCheck">
                    <label class="form-check-label" for="privacyModalCheck">
                        I have read and agree to the Data Privacy Notice.
                    </label>
                </div>

                <button id="agreePrivacyBtn" class="btn btn-vd" disabled>
                    I Agree
                </button>
            </div>
        </div>
    </div>
</div>

{{-- TERMS MODAL --}}
<div id="termsPopup" class="vd-modal" aria-hidden="true">
    <div class="vd-modal-card" role="dialog" aria-modal="true" aria-labelledby="termsTitle">
        <div class="vd-modal-head">
            <div>
                <h4 class="vd-modal-title" id="termsTitle">Terms and Conditions</h4>
                <div class="text-muted" style="font-size:.9rem;">Hotel policies for all guests</div>
            </div>
            <button class="vd-modal-close" id="termsClose" aria-label="Close terms">&times;</button>
        </div>

        <div class="vd-modal-body">
            <div>
                HOTEL TERMS & CONDITIONS
                
                PLEASE BE REMINDED THAT THESE CONDITIONS APPLY TO ALL GUESTS OF THE HOTEL.

                1. BOOKINGS
                Guests may book in advance or on arrival. Rooms are subject to availability and the hotel reserves the right to refuse booking for good reason. Although payment is generally on departure, guests may be required to provide a deposit on booking or arrival.

                2. CHECK-IN AND CHECK-OUT RULES
                Guests may check in anytime from 2:00 PM on the day of arrival. If the guest has not checked in by 4:00 PM, the hotel reserves the right to release the room unless the guest has notified the hotel of late arrival. Rooms are held for the entire day of arrival.

                On departure, guests must vacate their rooms and check-out no later than 12:00 PM. Failure to do so will entitle the hotel to charge for an additional night.

                3. CHARGES
                Charges are at the hotel’s current room rates available upon request. Pricelists for additional items, such as restaurant meals and room service, are on display at relevant locations and available on request.

                The hotel reserves the right to charge guests for any damage caused to any of the hotel’s property (including furniture and fixtures).

                Rooms are allowed a maximum of 2 persons per room. Visitors of guests are allowed until 10:00 PM. After this time, they will be asked to register and will be charged ₱350 per person.

                4. PAYMENT
                Guests must pay all outstanding charges on departure. The hotel reserves the right to hold any guest who refuses to give payment for services acquired.

                5. CANCELLATION
                For cancellation of pre-paid bookings, a refund will be given for the fully paid reservations. Deposits will not be returned for cancelled reservations.

                6. RIGHT OF REFUSAL
                The hotel reserves the right to refuse a guest entry and accommodation if, on arrival, management reasonably considers that the guest is under the influence of alcohol or drugs, unsuitably dressed, or behaving in a threatening, abusive, or otherwise unacceptable manner.

                7. DISTURBANCE
                The hotel reserves the right to require a guest to leave if he/she is causing disturbance, annoying other guests or hotel staff, or behaving in an unacceptable manner.

                8. HOTEL RULES
                Guests shall comply with all reasonable rules and procedures in effect at the hotel, including but not limited to health and security procedures and statutory registration requirements.
                Guests shall not bring their own food or drink into the hotel for consumption on the premises.
                Animals are not allowed in the rooms.
                Children under the age of 14 must be supervised by adult guests at all times.

                9. LIABILITY
                The hotel shall not be liable to guests for any loss or damage to property caused by misconduct or negligence of a guest, an act of God, or where the guest remains in exclusive charge of the property concerned.
                The hotel shall not be liable for any failure or delay in performing obligations due to causes beyond its control, including war, riot, natural disaster, epidemic, bad weather, terrorist activity, government or regulatory action, industrial dispute, failure of power, or other similar events.
                The hotel is not liable for any loss or damage caused to a guest’s vehicle, unless caused by the hotel’s willful misconduct.
                Guests will be liable for any loss, damage, or personal injury they may cause at the hotel.
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const isStep1 = {!! $isStep1 ? 'true' : 'false' !!};

    const privacyPopup = document.getElementById('privacyPopup');
    const termsPopup   = document.getElementById('termsPopup');

    const privacyCheckbox = document.getElementById('privacy');
    const privacyModalCheck = document.getElementById('privacyModalCheck');
    const agreeBtn = document.getElementById('agreePrivacyBtn');
    const termsClose = document.getElementById('termsClose');

    function openModal(modalEl){
        if (!modalEl) return;
        modalEl.style.display = 'flex';
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    function closeModal(modalEl){
        if (!modalEl) return;
        modalEl.style.display = 'none';
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    function openPrivacyModal(){
        if (!privacyPopup) return;
        openModal(privacyPopup);

        if (privacyModalCheck) privacyModalCheck.checked = false;
        if (agreeBtn) agreeBtn.disabled = true;
    }

    if (isStep1 && privacyPopup) openPrivacyModal();

    document.getElementById('privacyLink')?.addEventListener('click', function(e){
        e.preventDefault();
        openPrivacyModal();
    });

    privacyModalCheck?.addEventListener('change', function(){
        if (agreeBtn) agreeBtn.disabled = !this.checked;
    });

    agreeBtn?.addEventListener('click', function(){
        if (privacyModalCheck && !privacyModalCheck.checked) return;

        if (privacyCheckbox){
            privacyCheckbox.disabled = false;
            privacyCheckbox.checked = true;
        }

        closeModal(privacyPopup);
    });

    document.getElementById('termsLink')?.addEventListener('click', function(e){
        e.preventDefault();
        openModal(termsPopup);
    });

    termsClose?.addEventListener('click', function(){
        closeModal(termsPopup);
    });

    window.addEventListener('click', function(e){
        if (e.target === termsPopup){
            closeModal(termsPopup);
        }
    });

    const termsCheckbox = document.getElementById('terms');
    const registerBtn = document.getElementById('registerBtn');
    if (termsCheckbox && registerBtn){
        termsCheckbox.addEventListener('change', function(){
            registerBtn.disabled = !this.checked;
        });
    }

    const sendOtpForm = document.getElementById('sendOtpForm');
    const sendOtpBtn  = document.getElementById('sendOtpBtn');
    if (sendOtpForm && sendOtpBtn) {
        sendOtpForm.addEventListener('submit', function () {
            sendOtpBtn.disabled = true;
            sendOtpBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Sending...';
        });
    }

    document.getElementById('togglePasswordBtn')?.addEventListener('click', function(){
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (!password || !icon) return;

        if (password.type === 'password'){
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    document.getElementById('toggleConfirmBtn')?.addEventListener('click', function(){
        const password = document.getElementById('password_confirmation');
        const icon = document.getElementById('toggleIconConfirm');
        if (!password || !icon) return;

        if (password.type === 'password'){
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    const registerPasswordInput = document.getElementById('password');
    const registerConfirmPasswordInput = document.getElementById('password_confirmation');
    const registerPasswordRules = document.getElementById('registerPasswordRules');
    const registerMatchIndicator = document.getElementById('registerMatchIndicator');
    if (registerPasswordInput && registerPasswordRules) {
        const ruleEls = {
            uppercase: registerPasswordRules.querySelector('[data-rule="uppercase"]'),
            special: registerPasswordRules.querySelector('[data-rule="special"]'),
            number: registerPasswordRules.querySelector('[data-rule="number"]'),
            length: registerPasswordRules.querySelector('[data-rule="length"]')
        };

        const updatePasswordRules = (value) => {
            const checks = {
                uppercase: /[A-Z]/.test(value),
                special: /[@$!%*?&#]/.test(value),
                number: /\d/.test(value),
                length: value.length >= 8
            };

            Object.keys(ruleEls).forEach((key) => {
                const el = ruleEls[key];
                if (!el) return;
                el.classList.toggle('is-met', checks[key]);
            });
        };

        const updatePasswordMatch = () => {
            if (!registerMatchIndicator || !registerConfirmPasswordInput) return;

            const password = registerPasswordInput.value || '';
            const confirm = registerConfirmPasswordInput.value || '';

            registerMatchIndicator.classList.remove('is-match', 'is-mismatch');

            if (!confirm) {
                registerMatchIndicator.textContent = '';
                return;
            }

            if (password === confirm) {
                registerMatchIndicator.textContent = 'Passwords match';
                registerMatchIndicator.classList.add('is-match');
                return;
            }

            registerMatchIndicator.textContent = 'Passwords do not match';
            registerMatchIndicator.classList.add('is-mismatch');
        };

        registerPasswordInput.addEventListener('input', function () {
            updatePasswordRules(this.value || '');
            updatePasswordMatch();
        });

        registerConfirmPasswordInput?.addEventListener('input', updatePasswordMatch);

        updatePasswordRules(registerPasswordInput.value || '');
        updatePasswordMatch();
    }

    const otpWrap = document.getElementById('otpInputs');
    const otpHidden = document.getElementById('otpHidden');

    let inputs = [];
    let syncOtp = () => {};

    if (otpWrap && otpHidden) {
        inputs = Array.from(otpWrap.querySelectorAll('.otp-digit'));

        syncOtp = function () {
            const code = inputs.map(i => (i.value || '')).join('');
            otpHidden.value = code;
            inputs.forEach(i => i.classList.toggle('is-filled', !!i.value));
        };

        function focusFirstEmpty() {
            const empty = inputs.find(i => !i.value);
            (empty || inputs[inputs.length - 1]).focus();
        }

        inputs.forEach((input, idx) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/\D/g, '').slice(0, 1);
                syncOtp();

                if (input.value && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                }

                const code = otpHidden.value || '';
                if (code.length === 6) {
                    setTimeout(() => {
                        document.getElementById('otpForm')?.requestSubmit();
                    }, 180);
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (input.value) {
                        input.value = '';
                        syncOtp();
                        e.preventDefault();
                    } else if (idx > 0) {
                        inputs[idx - 1].focus();
                        inputs[idx - 1].value = '';
                        syncOtp();
                        e.preventDefault();
                    }
                }
                if (e.key === 'ArrowLeft' && idx > 0) inputs[idx - 1].focus();
                if (e.key === 'ArrowRight' && idx < inputs.length - 1) inputs[idx + 1].focus();
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
                const digits = paste.replace(/\D/g, '').slice(0, inputs.length).split('');
                digits.forEach((d, i) => { inputs[i].value = d; });
                syncOtp();

                const code = otpHidden.value || '';
                if (code.length === 6) {
                    setTimeout(() => {
                        document.getElementById('otpForm')?.requestSubmit();
                    }, 180);
                } else {
                    focusFirstEmpty();
                }
            });
        });

        setTimeout(() => {
            inputs[0]?.focus();
            syncOtp();
        }, 150);
    }

    @if(session('otp_error'))
    if (otpWrap && inputs.length) {
        otpWrap.classList.add('otp-error');

        otpWrap.classList.remove('shake');
        void otpWrap.offsetWidth;
        otpWrap.classList.add('shake');

        if (navigator.vibrate) navigator.vibrate(80);

        inputs.forEach(i => i.value = '');
        syncOtp();
        setTimeout(() => inputs[0].focus(), 120);

        setTimeout(() => otpWrap.classList.remove('otp-error'), 2500);
    }
    @endif

    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);
        });
    }

    @if(session('otp_sent') && !session('otp_verified'))
        const timerEl = document.getElementById('otpTimer');
        const verifyBtn = document.getElementById('verifyOtpBtn');

        const resendBtn = document.getElementById('resendBtn');
        const openResend = document.getElementById('openResend');
        const resendCountdownEl = document.getElementById('resendCountdown');

        if (timerEl){
            let timeLeft = parseInt(timerEl.dataset.remaining || "0", 10);

            const renderOtp = () => {
                if (timeLeft <= 0){
                    timerEl.textContent = "Expired";
                    timerEl.style.color = "red";
                    if (verifyBtn) verifyBtn.disabled = true;
                    return false;
                }

                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;

                timerEl.textContent =
                    minutes.toString().padStart(2,'0') + ':' +
                    seconds.toString().padStart(2,'0');

                return true;
            };

            renderOtp();

            const otpInterval = setInterval(() => {
                timeLeft = Math.max(0, timeLeft - 1);
                if (!renderOtp()) clearInterval(otpInterval);
            }, 1000);
        }

        let resendLeft = {{ (int)($resendRemaining ?? 0) }};

        const setResendState = () => {
            if (!resendBtn) return;

            const ready = resendLeft <= 0;

            resendBtn.disabled = !ready;

            if (resendCountdownEl) {
                resendCountdownEl.textContent = ready ? '' : `(${resendLeft}s)`;
            }

            if (openResend) {
                openResend.style.opacity = ready ? '1' : '.65';
                openResend.style.pointerEvents = ready ? 'auto' : 'none';
            }
        };

        setResendState();

        const resendInterval = setInterval(() => {
            resendLeft = Math.max(0, resendLeft - 1);
            setResendState();
            if (resendLeft <= 0) clearInterval(resendInterval);
        }, 1000);

        openResend?.addEventListener('click', function(){
            if (resendBtn && !resendBtn.disabled){
                document.getElementById('resendForm')?.submit();
            }
        });
    @endif
});
</script>
@endsection
