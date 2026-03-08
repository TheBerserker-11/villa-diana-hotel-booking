<div class="container-fluid p-0 mb-5">
    <div id="header-carousel"
         class="carousel slide position-relative"
         data-bs-ride="carousel"
         data-bs-interval="3500"
         data-bs-pause="false"
         data-bs-touch="true"
         data-bs-wrap="true">

        {{-- Images --}}
        <div class="carousel-inner">
            @php
                $carouselImages = [
                    'carousel-1.jpeg', 'carousel-2.jpg', 'carousel-3.jpg',
                    'carousel-4.jpg', 'carousel-5.jpg', 'carousel-6.jpg',
                    'carousel-7.jpg', 'carousel-8.jpg', 'carousel-9.jpg',
                    'carousel-10.jpg'
                ];
            @endphp

            @foreach($carouselImages as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('img/' . $image) }}" class="d-block w-100 carousel-img" alt="Image {{ $index + 1 }}">
                </div>
            @endforeach
        </div>

        {{-- Progress dots --}}
        <div class="carousel-indicators vd-carousel-indicators">
            @foreach($carouselImages as $index => $image)
                <button
                    type="button"
                    data-bs-target="#header-carousel"
                    data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>

        {{-- Sticky caption --}}
        <div class="vd-sticky-caption">
            <div class="vd-caption-inner text-center">
                <h6 class="section-title text-white text-uppercase mb-3">Luxury Living</h6>
                <h1 class="display-3 text-white mb-4">Discover A Brand Luxurious Hotel</h1>
                <a class="btn btn-primary py-md-3 px-md-5" href="{{ route('rooms.index') }}">
                    Book A Room
                </a>
            </div>
        </div>

        {{-- Scroll cue --}}
        <button class="vd-scroll-cue" type="button" aria-label="Scroll down">
            <span class="vd-scroll-cue__text">Scroll Down</span>
            <i class="bi bi-chevron-double-down" aria-hidden="true"></i>
        </button>

        {{-- Controls --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<style>
#header-carousel {
    height: 85vh;
    min-height: 520px;
    max-height: 760px;
}

#header-carousel .carousel-inner,
#header-carousel .carousel-item {
    height: 100%;
}

#header-carousel .carousel-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#header-carousel .vd-sticky-caption {
    position: absolute;
    inset: 0;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

#header-carousel .vd-sticky-caption a,
#header-carousel .vd-sticky-caption button {
    pointer-events: auto;
}

#header-carousel .vd-caption-inner {
    padding: 1.25rem;
    max-width: 900px;
}

#header-carousel .carousel-control-prev,
#header-carousel .carousel-control-next {
    z-index: 7;
}

#header-carousel .vd-carousel-indicators {
    z-index: 7;
    bottom: 1rem;
    margin-bottom: 0;
    gap: 0.5rem;
}

#header-carousel .vd-carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 999px;
    border: 0;
    margin: 0;
    background: rgba(255, 255, 255, 0.55);
    opacity: 1;
    transition: transform .2s ease, background-color .2s ease;
}

#header-carousel .vd-carousel-indicators .active {
    background: rgba(34, 40, 49, 0.95);
    transform: scale(1.15);
}

#header-carousel .vd-scroll-cue {
    position: absolute;
    left: 50%;
    bottom: 3.4rem;
    transform: translateX(-50%);
    z-index: 7;
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: 0.1rem;
    border: 0;
    background: transparent;
    color: #fff;
    text-shadow: 0 2px 14px rgba(0, 0, 0, 0.6);
    line-height: 1;
}

#header-carousel .vd-scroll-cue__text {
    font-size: .75rem;
    letter-spacing: .12em;
    text-transform: uppercase;
    opacity: .88;
}

#header-carousel .vd-scroll-cue i {
    font-size: 1.45rem;
    animation: vd-scroll-bounce 1.25s ease-in-out infinite;
}

#header-carousel .vd-scroll-cue:hover {
    color: #fff;
}

#header-carousel::before {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 4;
    background: rgba(0, 0, 0, .35);
    pointer-events: none;
}

@keyframes vd-scroll-bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(6px); }
}

@media (max-width: 768px) {
    #header-carousel {
        height: 65vh;
        min-height: 420px;
    }

    #header-carousel .vd-scroll-cue {
        bottom: 2.9rem;
    }

    #header-carousel .vd-carousel-indicators {
        bottom: .6rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('header-carousel');
    const scrollCue = document.querySelector('#header-carousel .vd-scroll-cue');

    if (!carousel || !scrollCue) return;

    scrollCue.addEventListener('click', () => {
        const doc = document.documentElement;
        const maxScrollTop = Math.max(
            document.body.scrollHeight,
            doc.scrollHeight
        ) - window.innerHeight;

        const targetTop = Math.max(maxScrollTop, 0);

        if ('scrollBehavior' in doc.style) {
            window.scrollTo({ top: targetTop, behavior: 'smooth' });
            return;
        }

        window.scrollTo(0, targetTop);
    });
});
</script>
