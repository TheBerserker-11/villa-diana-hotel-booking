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

    /* Top banner */
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

    .auth-brand{
        display:flex;
        align-items:center;
        gap:12px;
    }

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

    .auth-badge i{
        color:#FEA116;
        font-size:18px;
    }

    .auth-logo{
        font-weight:800;
        font-size:18px;
        margin:0;
    }

    .auth-sub{
        margin:2px 0 0 0;
        opacity:.85;
        font-size:13px;
    }

    .auth-body{
        padding:26px 26px 24px 26px;
    }

    .info-box{
        background:#f8fafc;
        border:1px solid #e9eef5;
        border-radius:14px;
        padding:12px 14px;
        font-size:13px;
        color:#64748b;
        margin-bottom:18px;
    }

    .info-box i{
        color:#FEA116;
        margin-right:8px;
    }

    .input-icon{ position:relative; }

    .input-icon i{
        position:absolute;
        top:50%;
        left:14px;
        transform:translateY(-50%);
        color:#94a3b8;
    }

    .form-control{
        height:50px;
        border-radius:14px;
        padding-left:42px;
        border:1px solid #e6ebf2;
    }

    .form-control:focus{
        border-color: rgba(254,161,22,.55);
        box-shadow: 0 0 0 .2rem rgba(254,161,22,.15);
    }

    .alert{
        border-radius:14px;
        font-size:14px;
    }

    .btn-reset{
        height:50px;
        border-radius:14px;
        background:#FEA116;
        border:none;
        font-weight:800;
        letter-spacing:.35px;
        box-shadow: 0 10px 26px rgba(254,161,22,.25);
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
    }

    .btn-reset:hover{ background:#e18d0f; }

    .btn-reset:disabled{
        opacity:.75;
        cursor:not-allowed;
        box-shadow:none;
    }

    .spinner{
        width:18px;
        height:18px;
        border-radius:999px;
        border:2px solid rgba(255,255,255,.55);
        border-top-color:#fff;
        display:none;
        animation: spin .8s linear infinite;
    }
    @keyframes spin{ to { transform: rotate(360deg);} }

    .btn-link-soft{
        color:#64748b;
        text-decoration:none;
        font-size:13px;
    }
    .btn-link-soft:hover{ color:#0f172b; text-decoration:underline; }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-top">
            <div class="auth-brand">
                <div class="auth-badge">
                    <i class="fa fa-envelope-open-text"></i>
                </div>
                <div>
                    <p class="auth-logo mb-0">Villa Diana Hotel</p>
                    <p class="auth-sub mb-0">Password Recovery</p>
                </div>
            </div>
        </div>

        <div class="auth-body">

            <div class="info-box">
                <i class="fa fa-circle-info"></i>
                Enter your email and we’ll send a secure reset link.
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-1"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4 input-icon">
                    <i class="fa fa-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        autocomplete="off"
                        placeholder="Enter your email address"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button id="sendBtn" type="submit" class="btn btn-reset w-100 text-white">
                    <span class="spinner" id="btnSpinner"></span>
                    <span id="btnText">Send Reset Link</span>
                    <i class="fa fa-paper-plane"></i>
                </button>
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
    const form = document.getElementById('forgotForm');
    const btn = document.getElementById('sendBtn');
    const spinner = document.getElementById('btnSpinner');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function () {
        btn.disabled = true;
        spinner.style.display = 'inline-block';
        btnText.textContent = 'Sending link...';
    });
</script>
@endsection