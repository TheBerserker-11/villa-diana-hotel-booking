@extends('layouts.app')

@section('header')
    @include('layouts.header')

    <!-- Booking -->
    @include('sections.booking-header')
@endsection

@section('content')
    <!-- Room -->
    @include('sections.room-container-details')

    <!-- Testimonial -->
    @include('sections.testimonial')

    <!-- Newsletter -->
    @include('sections.newsletter')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection