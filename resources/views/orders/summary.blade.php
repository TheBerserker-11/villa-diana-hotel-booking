@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@push('styles')
<style>
    /* ===== Villa Diana Booking Summary (page-only) ===== */
    .vd-summary-wrap{
        padding: 3rem 0;
        background:
            radial-gradient(900px circle at 15% 20%, rgba(254,161,22,.18), transparent 55%),
            radial-gradient(800px circle at 85% 25%, rgba(15,23,43,.18), transparent 55%),
            radial-gradient(900px circle at 60% 90%, rgba(254,161,22,.10), transparent 55%),
            linear-gradient(180deg, #f7f8fb 0%, #ffffff 55%, #f7f8fb 100%);
    }

    .vd-summary-card{
        border: 0;
        border-radius: 18px;
        box-shadow: 0 14px 40px rgba(15,23,43,.12);
        overflow: hidden;
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(6px);
    }

    .vd-summary-card .card-body{
        padding: 1.5rem;
    }

    .vd-summary-title{
        font-weight: 800;
        letter-spacing: .2px;
        color: #0f172b;
        margin: 0;
    }

    .vd-muted{
        color: rgba(15,23,43,.65);
    }

    .vd-room-img{
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid rgba(15,23,43,.10);
        box-shadow: 0 10px 22px rgba(15,23,43,.12);
    }

    .vd-kv{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 1rem;
        padding: .55rem 0;
        border-bottom: 1px dashed rgba(15,23,43,.14);
    }
    .vd-kv:last-child{ border-bottom:0; padding-bottom:0; }
    .vd-kv strong{ color:#0f172b; }

    .vd-total{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding-top: .9rem;
        margin-top: .6rem;
        border-top: 1px solid rgba(15,23,43,.12);
    }

    .vd-btn-orange{
        background: #FEA116;
        border-color: #FEA116;
        color: #0f172b;
        font-weight: 800;
        border-radius: 14px;
        padding: .75rem 1rem;
        box-shadow: 0 12px 26px rgba(254,161,22,.25);
    }
    .vd-btn-orange:hover{
        background: #f39a0f;
        border-color: #f39a0f;
        color: #0f172b;
    }

    .vd-btn-soft{
        border-radius: 14px;
        border: 1px solid rgba(15,23,43,.20);
        background: rgba(255,255,255,.7);
        color: #0f172b;
        font-weight: 700;
        padding: .55rem .9rem;
    }

    .vd-input{
        border-radius: 14px;
        border: 1px solid rgba(15,23,43,.16);
        padding: .65rem .85rem;
        box-shadow: none !important;
    }
    .vd-input:focus{
        border-color: rgba(254,161,22,.65);
        box-shadow: 0 0 0 .2rem rgba(254,161,22,.18) !important;
    }

    .vd-check .form-check-input{
        width: 1.15rem;
        height: 1.15rem;
        margin-top: .2rem;
        border-color: rgba(15,23,43,.25);
    }
    .vd-check .form-check-input:checked{
        background-color: #FEA116;
        border-color: #FEA116;
    }

    .vd-note{
        font-size: .9rem;
        color: rgba(15,23,43,.65);
    }
</style>
@endpush

@section('content')
@php
    $subTotal = $subTotal ?? (($pricing['per_night'] ?? 0) * ($nights ?? 1));
    $vatAmount = $vatAmount ?? ($subTotal * 0.10);
    $grandTotal = $grandTotal ?? ($subTotal + $vatAmount);
@endphp

<div class="vd-summary-wrap">
    <div class="container" style="max-width: 980px;">

        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h2 class="vd-summary-title">Booking Summary</h2>
                <div class="vd-muted">Review details before payment</div>
            </div>
            <a href="{{ route('rooms.index', request()->query()) }}" class="vd-btn-soft">Back</a>
        </div>

        <div class="row g-4">
            {{-- Left --}}
            <div class="col-lg-7">
                <div class="card vd-summary-card">
                    <div class="card-body">

                        <div class="d-flex gap-3 align-items-center mb-3">
                            <img
                                class="vd-room-img"
                                src="{{ $room->image ? asset('storage/rooms/' . $room->image) : 'https://via.placeholder.com/120x90?text=Room' }}"
                                alt="Room image"
                            >
                            <div>
                                <h5 class="mb-1" style="font-weight:800;color:#0f172b;">
                                    {{ $room->roomtype->name ?? $room->name ?? 'Room' }}
                                </h5>

                                <div class="vd-note">
                                    Check-in: <strong>{{ $fields['check_in'] }}</strong> •
                                    Check-out: <strong>{{ $fields['check_out'] }}</strong> •
                                    Nights: <strong>{{ $nights }}</strong>
                                </div>

                                <div class="vd-note">
                                    Guests: <strong>{{ $totalGuests }}</strong>
                                    (Adults {{ $fields['adults'] }},
                                    Children {{ $fields['children'] ?? 0 }},
                                    Infants {{ $fields['infants'] ?? 0 }})
                                </div>
                            </div>
                        </div>

                        <div class="vd-kv">
                            <span class="vd-muted">Price per night</span>
                            <strong>₱{{ number_format($pricing['per_night'] ?? 0, 2) }}</strong>
                        </div>

                        <div class="vd-kv">
                            <span class="vd-muted">Subtotal</span>
                            <strong>₱{{ number_format($subTotal, 2) }}</strong>
                        </div>

                        <div class="vd-kv">
                            <span class="vd-muted">VAT (10%)</span>
                            <strong>₱{{ number_format($vatAmount, 2) }}</strong>
                        </div>

                        <div class="vd-total">
                            <span style="font-weight:900;color:#0f172b;font-size:1.05rem;">Total</span>
                            <strong style="font-weight:900;color:#0f172b;font-size:1.25rem;">
                                ₱{{ number_format($grandTotal, 2) }}
                            </strong>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right --}}
            <div class="col-lg-5">
                <div class="card vd-summary-card">
                    <div class="card-body">
                        <h5 class="mb-1" style="font-weight:900;color:#0f172b;">Proceed to Payment</h5>
                        <div class="vd-note mb-3">Enter your reference and upload proof if available.</div>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @auth
                        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="room_id" value="{{ $fields['room_id'] }}">
                            <input type="hidden" name="check_in" value="{{ $fields['check_in'] }}">
                            <input type="hidden" name="check_out" value="{{ $fields['check_out'] }}">
                            <input type="hidden" name="adults" value="{{ $fields['adults'] }}">
                            <input type="hidden" name="children" value="{{ $fields['children'] ?? 0 }}">
                            <input type="hidden" name="infants" value="{{ $fields['infants'] ?? 0 }}">
                            <input type="hidden" name="pets" value="{{ $fields['pets'] ?? 0 }}">

                            <div class="mb-3">
                                <label class="form-label" style="font-weight:800;color:#0f172b;">Reference Code</label>
                                <input
                                    type="text"
                                    name="reference_code"
                                    class="form-control vd-input"
                                    required
                                    minlength="13"
                                    maxlength="13"
                                    placeholder="13-character code"
                                >
                                @error('reference_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="font-weight:800;color:#0f172b;">Upload Proof (optional)</label>
                                <input type="file" name="proof_image" class="form-control vd-input" accept="image/*">
                                @error('proof_image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-check vd-check mb-2">
                                <input class="form-check-input" type="checkbox" name="paid" value="1" id="paid" required>
                                <label class="form-check-label" for="paid">I confirm payment was made</label>
                            </div>

                            <div class="form-check vd-check mb-3">
                                <input class="form-check-input" type="checkbox" name="terms" value="1" id="terms" required>
                                <label class="form-check-label" for="terms">I agree to the terms</label>
                            </div>

                            <button class="btn vd-btn-orange w-100">Submit Booking</button>
                        </form>
                    @else
                        <div class="alert alert-warning mb-3">
                            Please log in or create an account to proceed to payment.
                        </div>

                        <a class="btn vd-btn-orange w-100 mb-2"
                        href="{{ route('login', ['redirect' => url()->full()]) }}">
                            Login to Continue
                        </a>

                        <a class="btn vd-btn-soft w-100"
                        href="{{ route('register', ['redirect' => url()->full()]) }}">
                            Create Account
                        </a>
                    @endauth

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection