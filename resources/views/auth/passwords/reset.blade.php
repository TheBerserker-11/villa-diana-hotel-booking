@extends('layouts.app')

@section('content')
<style>
    body{
        background: radial-gradient(1200px 600px at 20% 10%, rgba(1,60,43,.10), transparent 60%),
                    radial-gradient(900px 500px at 90% 20%, rgba(254,161,22,.10), transparent 55%),
                    #f6f7fb;
    }

    .auth-wrapper{
        min-height:82vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:24px 12px;
    }

    .auth-card{
        width:100%;
        max-width:460px;
        border:none;
        border-radius:20px;
        background:#fff;
        box-shadow:0 18px 45px rgba(0,0,0,.10);
        overflow:hidden;
    }

    .auth-top{
        padding:22px 26px;
        background: linear-gradient(135deg, #013C2B 0%, #0b5b43 55%, #013C2B 100%);
        color:#fff;
        position:relative;
    }
    .auth-top:after{
        content:"";
        position:absolute;
        inset:-40px -40px auto auto;
        width:140px;
        height:140px;
        border-radius:999px;
        background: rgba(254,161,22,.20);
    }

    .auth-brand{ display:flex; align-items:center; gap:12px; }

    .auth-badge{
        width:44px;
        height:44px;
        border-radius:14px;
        background: rgba(255,255,255,.14);
        display:flex;
        align-items:center;
        justify-content:center;
        border:1px solid rgba(255,255,255,.18);
    }
    .auth-badge i{ color:#FEA116;font-size:18px; }

    .auth-logo{ font-weight:800;font-size:18px;margin:0; }
    .auth-sub{ opacity:.85;font-size:13px;margin:2px 0 0; }

    .auth-body{ padding:26px; }

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

    .form-label{ font-weight:700;color:#0f172b;font-size:13px;margin-bottom:6px; }
    .field-wrap{ position:relative; }

    .field-wrap .left-icon,
    .field-wrap .toggle-password{
        position:absolute;
        top:50%;
        transform:translateY(-50%);
        width:34px;
        height:34px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:14px;
        border-radius:10px;
    }

    .field-wrap .left-icon{
        left:12px;
        color:#94a3b8;
        pointer-events:none;
    }

    .field-wrap .toggle-password{
        right:12px;
        color:#94a3b8;
        cursor:pointer;
        transition:.15s;
    }
    .field-wrap .toggle-password:hover{
        background:#f1f5f9;
        color:#475569;
    }

    .form-control{
        height:50px;
        border-radius:14px;
        border:1px solid #e6ebf2;
        background:#fff;
        padding-left:54px;
        padding-right:16px;
    }
    .field-wrap.has-toggle .form-control{ padding-right:54px; }

    .form-control:focus{
        border-color: rgba(254,161,22,.55);
        box-shadow: 0 0 0 .2rem rgba(254,161,22,.15);
    }

    .btn-reset{
        height:50px;
        border-radius:14px;
        background:#FEA116;
        border:none;
        font-weight:800;
        letter-spacing:.35px;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        box-shadow:0 10px 26px rgba(254,161,22,.25);
    }

    .btn-link-soft{ color:#64748b;text-decoration:none;font-size:13px; }
    .btn-link-soft:hover{ color:#0f172b;text-decoration:underline; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-top">
            <div class="auth-brand">
                <div class="auth-badge"><i class="fa fa-key"></i></div>
                <div>
                    <p class="auth-logo mb-0">Villa Diana Hotel</p>
                    <p class="auth-sub mb-0">Reset your password securely</p>
                </div>
            </div>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:.9rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="password-rules" id="resetPasswordRules" aria-live="polite">
                <div class="password-rule" data-rule="uppercase"><i class="fa-solid fa-circle"></i>One uppercase letter</div>
                <div class="password-rule" data-rule="special"><i class="fa-solid fa-circle"></i>One special character</div>
                <div class="password-rule" data-rule="number"><i class="fa-solid fa-circle"></i>One number</div>
                <div class="password-rule" data-rule="length"><i class="fa-solid fa-circle"></i>At least 8 characters</div>
            </div>

            <form id="resetForm" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="field-wrap">
                        <i class="fa fa-envelope left-icon"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="field-wrap has-toggle">
                        <i class="fa fa-lock left-icon"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        <i class="fa fa-eye toggle-password" data-target="#password"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label class="form-label mb-0" for="password_confirmation">Confirm Password</label>
                        <small id="resetMatchIndicator" class="password-match-indicator" aria-live="polite"></small>
                    </div>
                    <div class="field-wrap has-toggle">
                        <i class="fa fa-check-circle left-icon"></i>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            required
                        >
                        <i class="fa fa-eye toggle-password" data-target="#password_confirmation"></i>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-reset w-100">Reset Password</button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="btn-link-soft">
                    <i class="fa fa-arrow-left me-1"></i> Back to Login
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function (icon) {
        icon.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('data-target'));
            if (!input) return;

            input.type = (input.type === 'password') ? 'text' : 'password';
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    const resetPasswordInput = document.getElementById('password');
    const resetConfirmPasswordInput = document.getElementById('password_confirmation');
    const resetPasswordRules = document.getElementById('resetPasswordRules');
    const resetMatchIndicator = document.getElementById('resetMatchIndicator');
    if (resetPasswordInput && resetPasswordRules) {
        const ruleEls = {
            uppercase: resetPasswordRules.querySelector('[data-rule="uppercase"]'),
            special: resetPasswordRules.querySelector('[data-rule="special"]'),
            number: resetPasswordRules.querySelector('[data-rule="number"]'),
            length: resetPasswordRules.querySelector('[data-rule="length"]')
        };

        const updatePasswordRules = function (value) {
            const checks = {
                uppercase: /[A-Z]/.test(value),
                special: /[@$!%*?&#]/.test(value),
                number: /\d/.test(value),
                length: value.length >= 8
            };

            Object.keys(ruleEls).forEach(function (key) {
                const el = ruleEls[key];
                if (!el) return;
                el.classList.toggle('is-met', checks[key]);
            });
        };

        resetPasswordInput.addEventListener('input', function () {
            updatePasswordRules(this.value || '');
            updatePasswordMatch();
        });

        updatePasswordRules(resetPasswordInput.value || '');

        const updatePasswordMatch = function () {
            if (!resetMatchIndicator || !resetConfirmPasswordInput) return;

            const password = resetPasswordInput.value || '';
            const confirm = resetConfirmPasswordInput.value || '';

            resetMatchIndicator.classList.remove('is-match', 'is-mismatch');

            if (!confirm) {
                resetMatchIndicator.textContent = '';
                return;
            }

            if (password === confirm) {
                resetMatchIndicator.textContent = 'Passwords match';
                resetMatchIndicator.classList.add('is-match');
                return;
            }

            resetMatchIndicator.textContent = 'Passwords do not match';
            resetMatchIndicator.classList.add('is-mismatch');
        };

        resetConfirmPasswordInput?.addEventListener('input', updatePasswordMatch);
        updatePasswordMatch();
    }
});
</script>
@endsection
