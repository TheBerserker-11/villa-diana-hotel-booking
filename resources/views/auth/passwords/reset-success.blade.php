@extends('layouts.app')

@section('content')
<style>
    body{
        background: radial-gradient(1200px 600px at 20% 10%, rgba(1,60,43,.10), transparent 60%),
                    radial-gradient(900px 500px at 90% 20%, rgba(254,161,22,.10), transparent 55%),
                    #f6f7fb;
    }

    .reset-success-wrap{
        min-height: 82vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 12px;
    }

    .reset-success-modal{
        width: 100%;
        max-width: 460px;
        border-radius: 18px;
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 45px rgba(0,0,0,.12);
        padding: 28px 24px;
        text-align: center;
    }

    .reset-success-icon{
        width: 70px;
        height: 70px;
        border-radius: 50%;
        margin: 0 auto 14px;
        background: rgba(34,197,94,.12);
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
    }

    .reset-success-title{
        margin: 0 0 8px;
        color: #0f172b;
        font-weight: 800;
    }

    .reset-success-text{
        margin: 0 0 18px;
        color: #475569;
        font-size: .95rem;
    }

    .btn-reset-success{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 180px;
        padding: .7rem 1rem;
        border-radius: 12px;
        border: 0;
        text-decoration: none;
        font-weight: 700;
        background: #FEA116;
        color: #0F172B;
        box-shadow: 0 10px 20px rgba(254,161,22,.28);
    }
    .btn-reset-success:hover{
        color: #0F172B;
        background: #ffb13a;
    }

    .reset-success-note{
        margin-top: 12px;
        color: #64748b;
        font-size: .85rem;
    }
</style>

<div class="reset-success-wrap">
    <div class="reset-success-modal" role="dialog" aria-modal="true" aria-labelledby="resetSuccessTitle">
        <div class="reset-success-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h2 class="reset-success-title" id="resetSuccessTitle">Password Successfully Reset</h2>
        <p class="reset-success-text">
            {{ $message ?? 'Your password has been updated successfully. You are now signed in.' }}
        </p>

        <a href="{{ $redirectTo ?? route('home') }}" class="btn-reset-success" id="continueAfterReset">
            Continue to Home
        </a>

        <div class="reset-success-note">Redirecting automatically...</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const redirectTo = @json($redirectTo ?? route('home'));
    setTimeout(function () {
        window.location.href = redirectTo;
    }, 1800);
});
</script>
@endsection
