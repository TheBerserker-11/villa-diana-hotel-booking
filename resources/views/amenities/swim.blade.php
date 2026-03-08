@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="amenity-wrap">
    <div class="amenity-shell">

        <div class="amenity-grid">
            <div class="amenity-left">
                <div class="amenity-photo">
                    <img src="{{ asset('img/amenities/swim.jpg') }}" alt="Swim and Relax">
                </div>
            </div>

            <div class="amenity-right">
                <h2 class="amenity-title">Swim & Relax</h2>
                <p class="amenity-lead">
                    Complete your staycation experience here at <strong>Villa Diana Hotel</strong>!
                    Enjoy the refreshing poolside while ordering delicious food and drinks directly from our restaurant.
                </p>

                <div class="amenity-features">
                    <span class="chip"><i class="fa fa-water me-2"></i>Poolside</span>
                    <span class="chip"><i class="fa fa-utensils me-2"></i>Food & Drinks</span>
                    <span class="chip"><i class="fa fa-microphone me-2"></i>Karaoke</span>
                </div>

                <p class="amenity-text">
                    You can even request to have your meals served by the pool for the ultimate comfort and relaxation.
                </p>
                <p class="amenity-text">
                    To make it more fun, sing your heart out with our <strong>karaoke</strong> while you and your loved ones relax by the water.
                </p>

                <div class="amenity-hours">
                    <i class="fa fa-clock me-2"></i>
                    <span><strong>Pool Hours:</strong> 8:00 AM – 8:00 PM</span>
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
