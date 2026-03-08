@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="container-xxl py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h1>{{ $room->roomtype->name }} - Virtual Tour</h1>

            <div class="room-description mt-4 text-start">
                @php
                    $tour = $room->tour_details;
                    $intro = (string) ($tour['intro'] ?? '');
                    $left = collect($tour['room_highlights'] ?? []);
                    $right = collect($tour['comfort_amenities'] ?? []);
                    $noteClean = (string) ($tour['note'] ?? '');
                @endphp

                @if($intro !== '')
                    <p class="lead text-muted mb-3" style="line-height:1.8;">
                        {{ $intro }}
                    </p>
                @endif

                @if($left->isNotEmpty() || $right->isNotEmpty())
                    <hr>

                    <div class="row align-items-start">
                        <div class="col-md-6 mb-3">
                            <h5 class="fw-bold">🏡 Room Highlights</h5>
                            <ul class="mb-0 ps-3" style="line-height:1.9;">
                                @foreach($left as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h5 class="fw-bold">🛏 Comfort & Amenities</h5>
                            <ul class="mb-0 ps-3" style="line-height:1.9;">
                                @foreach($right as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Styled Important Note --}}
                @if($noteClean !== '')
                    <div class="mt-4">
                        <div class="p-4 rounded-4 border shadow-sm"
                             style="background: linear-gradient(135deg, rgba(254,161,22,0.12), rgba(15,23,43,0.06));">

                            <div class="d-flex align-items-start gap-3">

                                <div class="d-flex align-items-center justify-content-center rounded-circle"
                                     style="width:48px;height:48px;background:#FEA116;">
                                    <span style="font-size:20px;color:white;">⚠️</span>
                                </div>

                                <div>
                                    <h6 class="fw-bold mb-1" style="color:#0F172B;">
                                        Important Booking Note
                                    </h6>

                                    <p class="mb-0 text-muted" style="line-height:1.7;">
                                        {{ $noteClean }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div class="ratio ratio-16x9 rounded shadow mb-4">
            <iframe src="{{ $room->kuula_link }}"
                    allowfullscreen
                    allow="xr-spatial-tracking; gyroscope; accelerometer"
                    scrolling="no"></iframe>
        </div>

        <div class="text-center">
            <a href="{{ route('rooms.index', request()->query()) }}" 
            class="btn btn-dark rounded-pill px-4 py-2">
                Back to Rooms
            </a>
        </div>

        <div class="mt-5">
            <div class="p-4 p-md-5 rounded-4 shadow-sm border bg-light">

                <div class="text-center mb-4">
                    <span class="badge bg-dark px-3 py-2 rounded-pill mb-2">GOOD TO KNOW</span>
                    <h4 class="fw-bold mb-1">Hotel Stay Information</h4>
                    <p class="text-muted mb-0">Quick details to help you plan your stay.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="h-100 p-4 rounded-4 bg-white border shadow-sm text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-25"
                                 style="width:54px;height:54px;">
                                🍳
                            </div>
                            <h6 class="fw-bold mt-3 mb-1">Breakfast</h6>
                            <p class="text-muted mb-0">Breakfast not included</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h-100 p-4 rounded-4 bg-white border shadow-sm text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
                                 style="width:54px;height:54px;">
                                👨‍👩‍👧‍👦
                            </div>
                            <h6 class="fw-bold mt-3 mb-1">Extra Guests</h6>
                            <p class="text-muted mb-0">
                                <span class="fw-semibold text-dark">₱1,200/night</span> per additional guest
                                <br>
                                <small>(includes beddings, towels & toiletries)</small>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="h-100 p-4 rounded-4 bg-white border shadow-sm text-center">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10"
                                 style="width:54px;height:54px;">
                                🕒
                            </div>
                            <h6 class="fw-bold mt-3 mb-1">Check-in / Check-out</h6>
                            <p class="text-muted mb-0">
                                Check-in: <span class="fw-semibold text-dark">2:00 PM</span><br>
                                Check-out: <span class="fw-semibold text-dark">12:00 PM</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-4 border bg-white text-center text-muted">
                    Prices subject to change without prior notice.
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('footer')
    @include('sections.newsletter')
    @include('layouts.footer')
@endsection
