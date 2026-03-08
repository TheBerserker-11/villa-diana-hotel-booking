@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')

<section class="vd-amenity-hero" style="background-image:url('{{ asset('img/amenities/brickyard.jpg') }}');">
    <div class="vd-amenity-hero__overlay"></div>

    <div class="container vd-amenity-hero__content text-center">
        <span class="vd-amenity-hero__badge">
            <i class="fa-solid fa-utensils"></i> Dining
        </span>

        <h1 class="vd-amenity-hero__title">Brickyard Bar + Kitchen</h1>
        <p class="vd-amenity-hero__subtitle">
            Comfort food, burgers, pasta, and Filipino favorites — paired with a perfect bottle of wine.
        </p>

        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
            <a href="#details" class="btn btn-warning btn-lg px-4">Explore Details</a>
            <a href="#gallery" class="btn btn-outline-light btn-lg px-4 ms-2">View Gallery</a>
        </div>
    </div>
</section>

<div class="amenity-container" id="details">
    <div class="amenity-card vd-amenity-card-upgraded">

        <div class="vd-amenity-media">
            <img src="{{ asset('img/amenities/brickyard.jpg') }}"
                 alt="Brickyard Bar + Kitchen"
                 class="amenity-img vd-amenity-img-upgraded">
        </div>

        <div class="amenity-info vd-amenity-info-upgraded">
            <div class="vd-amenity-heading">
                <h2 class="vd-amenity-title">Brickyard Bar + Kitchen</h2>
                <p class="vd-amenity-subtitle">
                    A cozy dining spot inside Villa Diana Hotel.
                </p>
            </div>

            <div class="vd-amenity-chips">
                <span class="vd-chip"><i class="fa-solid fa-clock"></i> 6:30 AM – 10:00 PM</span>
                <span class="vd-chip"><i class="fa-solid fa-wine-glass"></i> Wine-friendly</span>
                <span class="vd-chip"><i class="fa-solid fa-user-group"></i> Guests welcome</span>
            </div>

            <div class="vd-amenity-text">
                <p>
                    The Brickyard Bar + Kitchen is a small homey restaurant in the heart of Villa Diana Hotel.
                </p>
                <p>
                    The Brickyard offers menus from comfort food, burgers, pasta, to traditional Filipino dishes,
                    and choices of succulent steak that you can pair with a perfect bottle of wine.
                </p>
                <p>
                    The perfect place to wine and dine! Come and see for yourselves!
                </p>
            </div>

            <div class="vd-amenity-note">
                <i class="fa-solid fa-circle-info"></i>
                <div>
                    <strong>Note:</strong> Non-Hotel Guests are also welcome in the Restaurant.
                </div>
            </div>

            <div class="vd-amenity-meta">
                <div class="vd-meta">
                    <div class="vd-meta__label">Opening Hours</div>
                    <div class="vd-meta__value">6:30 AM – 10:00 PM</div>
                </div>
                <div class="vd-meta">
                    <div class="vd-meta__label">For Questions</div>
                    <div class="vd-meta__value">0917-550-6588</div>
                </div>
            </div>

            <div class="vd-amenity-cta">
                <a href="tel:09175506588" class="btn btn-dark px-4">Call Now</a>
                <a href="#gallery" class="btn btn-outline-dark px-4 ms-2">See Photos</a>
            </div>

            <p class="vd-amenity-tagline">GREAT FOOD. GREAT WINE. GREAT TIME.</p>
        </div>
    </div>
</div>

<div class="amenity-carousel" id="gallery">
    <h2 class="vd-gallery-title">Gallery</h2>
    <p class="vd-gallery-subtitle">A quick look inside Brickyard.</p>

    <div class="carousel-container vd-carousel-upgraded">
        <button class="prev vd-nav-btn" type="button" aria-label="Previous">&#10094;</button>

        <div class="carousel-track-wrapper">
            <div class="carousel-track">
                <img src="{{ asset('img/amenities/adaDa.jpg') }}" alt="Gallery Photo 1">
                <img src="{{ asset('img/amenities/asdds.jpg') }}" alt="Gallery Photo 2">
                <img src="{{ asset('img/amenities/asdfg.jpg') }}" alt="Gallery Photo 3">
                <img src="{{ asset('img/amenities/asdfgh.jpg') }}" alt="Gallery Photo 4">
                <img src="{{ asset('img/amenities/asw.jpg') }}" alt="Gallery Photo 5">
                <img src="{{ asset('img/amenities/DRINKS.jpg') }}" alt="Gallery Photo 6">
                <img src="{{ asset('img/amenities/FOOD.jpg') }}" alt="Gallery Photo 7">
                <img src="{{ asset('img/amenities/1.jpeg') }}" alt="Gallery Photo 8">
                <img src="{{ asset('img/amenities/2.jpeg') }}" alt="Gallery Photo 9">
                <img src="{{ asset('img/amenities/3.jpeg') }}" alt="Gallery Photo 10">
                <img src="{{ asset('img/amenities/4.jpg') }}" alt="Gallery Photo 11">
                <img src="{{ asset('img/amenities/5.jpeg') }}" alt="Gallery Photo 12">
                <img src="{{ asset('img/amenities/6.jpeg') }}" alt="Gallery Photo 13">
                <img src="{{ asset('img/amenities/7.jpeg') }}" alt="Gallery Photo 14">
                <img src="{{ asset('img/amenities/8.jpeg') }}" alt="Gallery Photo 15">
                <img src="{{ asset('img/amenities/9.jpeg') }}" alt="Gallery Photo 16">
                <img src="{{ asset('img/amenities/10.jpeg') }}" alt="Gallery Photo 17">
                <img src="{{ asset('img/amenities/11.jpeg') }}" alt="Gallery Photo 18">
                <img src="{{ asset('img/amenities/12.jpeg') }}" alt="Gallery Photo 19">
                <img src="{{ asset('img/amenities/13.jpeg') }}" alt="Gallery Photo 20">
                <img src="{{ asset('img/amenities/14.jpeg') }}" alt="Gallery Photo 21">
                <img src="{{ asset('img/amenities/15.jpeg') }}" alt="Gallery Photo 22">
                <img src="{{ asset('img/amenities/16.jpeg') }}" alt="Gallery Photo 23">
                <img src="{{ asset('img/amenities/17.jpeg') }}" alt="Gallery Photo 24">
                <img src="{{ asset('img/amenities/18.jpeg') }}" alt="Gallery Photo 25">
                <img src="{{ asset('img/amenities/19.jpeg') }}" alt="Gallery Photo 26">
                <img src="{{ asset('img/amenities/20.jpeg') }}" alt="Gallery Photo 27">
                <img src="{{ asset('img/amenities/21.jpeg') }}" alt="Gallery Photo 28">
                <img src="{{ asset('img/amenities/22.jpeg') }}" alt="Gallery Photo 29">
                <img src="{{ asset('img/amenities/23.jpeg') }}" alt="Gallery Photo 30">
                <img src="{{ asset('img/amenities/24.jpeg') }}" alt="Gallery Photo 31">
                <img src="{{ asset('img/amenities/25.jpeg') }}" alt="Gallery Photo 32">
                <img src="{{ asset('img/amenities/26.jpeg') }}" alt="Gallery Photo 33">
                <img src="{{ asset('img/amenities/27.jpeg') }}" alt="Gallery Photo 34">
                <img src="{{ asset('img/amenities/28.jpeg') }}" alt="Gallery Photo 35">
            </div>
        </div>

        <button class="next vd-nav-btn" type="button" aria-label="Next">&#10095;</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    if (!track) return;

    const slides = Array.from(track.children);
    const nextButton = document.querySelector('.next');
    const prevButton = document.querySelector('.prev');

    let index = 0;
    const slidesToShow = 3; // looks cleaner with your new big cards
    const totalSlides = slides.length;

    function updateCarousel() {
        const slideWidth = slides[0].getBoundingClientRect().width + 10;
        track.style.transform = 'translateX(' + (-index * slideWidth) + 'px)';
    }

    nextButton?.addEventListener('click', () => {
        if(index < totalSlides - slidesToShow){
            index++;
        } else {
            index = 0;
        }
        updateCarousel();
    });

    prevButton?.addEventListener('click', () => {
        if(index > 0){
            index--;
        } else {
            index = Math.max(totalSlides - slidesToShow, 0);
        }
        updateCarousel();
    });

    window.addEventListener('resize', updateCarousel);
    setInterval(() => { nextButton?.click(); }, 5000);
});
</script>

@endsection

@section('footer')
    @include('sections.newsletter')
    @include('layouts.footer')
@endsection
