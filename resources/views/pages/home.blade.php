@extends('layouts.app')

@section('header')
    @include('layouts.header')

    <!-- Carousel -->
    <div class="container-fluid p-0">
        @include('sections.carousel')
    </div>

    {{-- ✅ Virtual Tour (SHOW ONLY when logged in) --}}
    
        <div class="container-fluid pb-4">
            <div class="ratio ratio-16x9 rounded shadow">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allowfullscreen 
                    allow="xr-spatial-tracking; gyroscope; accelerometer" 
                    scrolling="no" 
                    src="https://kuula.co/share/collection/7D9cZ?logo=0&info=0&fs=1&vr=1&initload=0&thumbs=1">
                </iframe>
            </div>
        </div>
    

    <!-- Call To Action Buttons -->
    <div class="container text-center pb-5">
        <h3 class="mb-3">Ready to book your stay?</h3>
        <p class="mb-4">Sign in to manage bookings or start a new reservation.</p>

        <div class="d-grid gap-2 d-sm-flex justify-content-center">
            @auth
                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg w-100 w-sm-auto">
                    My Bookings
                </a>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    Book Another Room
                </a>
            @else
                <a href="{{ route('login', ['redirect' => url()->full()]) }}"
                class="btn btn-primary btn-lg w-100 w-sm-auto">
                    Login
                </a>

                <a href="{{ route('register', ['redirect' => url()->full()]) }}"
                class="btn btn-outline-primary btn-lg w-100 w-sm-auto">
                    Create Account
                </a>
            @endauth
        </div>
    </div>
@endsection

@section('content')

    {{-- ✅ Explore Our Services (SHOW ONLY when logged in) --}}
    @auth
        @include('sections.service')
    @endauth

    {{-- ✅ Rooms stays visible for guest + logged in --}}
    @include('sections.room-container-brief')

    @include('sections.how-to-get-here')

    @include('sections.testimonial')

    {{-- ✅ Hotel Staff / Team (SHOW ONLY when logged in) --}}
    @auth
        @include('sections.team')
    @endauth

    @include('sections.newsletter')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection