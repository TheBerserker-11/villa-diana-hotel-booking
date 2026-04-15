@extends('layouts.app')

@section('content')

<section class="vd-hero">
    <div class="vd-hero__overlay"></div>
    <div class="container vd-hero__content text-center">
        <h1 class="vd-hero__title">Events & Venues</h1>
        <p class="vd-hero__subtitle">
            Celebrate milestones, host gatherings, and create unforgettable moments at Villa Diana Hotel.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
            <a href="#venues" class="btn btn-warning btn-lg px-5">Explore Venues</a>
            <a href="#events" class="btn btn-outline-light btn-lg px-5 ms-2">View Events</a>
        </div>
    </div>
</section>

<div class="container py-5">

    <section id="venues" class="mb-5">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h2 class="vd-section-title mb-1">Available Venues</h2>
                <p class="text-muted mb-0">Choose the perfect space for your guests.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($halls as $hall)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="vd-venue-card h-100">
                        <div class="vd-venue-card__top">
                            <div class="vd-venue-card__icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div>
                                <h5 class="vd-venue-card__name mb-0">{{ $hall->name }}</h5>
                                <small class="text-muted">Event Venue</small>
                            </div>
                        </div>

                        <div class="vd-venue-card__meta">
                            <div class="vd-meta-row">
                                <span class="vd-meta-label">Max Capacity</span>
                                <span class="vd-meta-value">{{ $hall->max_capacity }} guests</span>
                            </div>
                            <div class="vd-meta-row">
                                <span class="vd-meta-label">Starting Price</span>
                                <span class="vd-meta-value text-warning fw-bold">₱{{ number_format($hall->price, 2) }}</span>
                            </div>
                        </div>

                        <div class="vd-venue-card__cta mt-auto">
                            <a href="#events" class="btn btn-sm btn-outline-dark w-100">
                                View Suitable Events
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="events">
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h2 class="vd-section-title mb-1">Events</h2>
                <p class="text-muted mb-0">Explore our event types and packages.</p>
            </div>
        </div>

        @if($events->count())
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-12 col-lg-6">
                        <div class="vd-event-card">
                            <div class="vd-event-card__media">
                                @if($event->images->count())
                                    <div class="vd-slideshow" data-slideshow>
                                        @foreach($event->images as $image)
                                            <img
                                                src="{{ $image->image_url }}"
                                                class="vd-slide"
                                                alt="{{ $event->name }}"
                                                data-event-id="{{ $event->id }}"
                                            >
                                        @endforeach
                                    </div>
                                @else
                                    <div class="vd-media-placeholder">
                                        <i class="fa fa-image"></i>
                                        <span>No image available</span>
                                    </div>
                                @endif

                                <div class="vd-event-card__badge">
                                    <i class="fa fa-star me-1"></i> Popular
                                </div>
                            </div>

                            <div class="vd-event-card__body">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <h4 class="vd-event-title mb-1">{{ $event->name }}</h4>
                                </div>

                                <p class="vd-event-desc mb-3">
                                    {{ $event->description }}
                                </p>

                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button"
                                            class="btn btn-sm btn-dark"
                                            data-open-gallery
                                            data-event-id="{{ $event->id }}">
                                        View Photos
                                    </button>

                                    <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-dark">
                                        Inquire Now
                                    </a>
                                </div>

                                <small class="text-muted d-block mt-3">
                                    Tip: Click any photo to view full gallery.
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No events available at the moment.</p>
        @endif
    </section>

</div>

<section class="vd-cta">
    <div class="container text-center">
        <h3 class="mb-2 fw-bold">Ready to plan your event?</h3>
        <p class="mb-3">Let Villa Diana Hotel handle the details — venue, food, and accommodations.</p>
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-5">Get Started</a>
    </div>
</section>

<!-- IMAGE POPUP MODAL -->
<div id="imageModal" class="vd-modal">
    <button class="vd-modal__close" type="button" aria-label="Close">&times;</button>
    <button class="vd-modal__nav vd-modal__nav--prev" type="button" aria-label="Previous">&#10094;</button>
    <img id="modalImage" class="vd-modal__img" alt="Event Image">
    <button class="vd-modal__nav vd-modal__nav--next" type="button" aria-label="Next">&#10095;</button>
</div>

@endsection

@push('scripts')
<style>
/* ===== Villa Diana Events Redesign (Scoped) ===== */
.vd-hero{
    position: relative;
    min-height: 55vh;
    display:flex;
    align-items:center;
    background: url('{{ asset('img/event-hero.jpg') }}') center/cover no-repeat;
}
.vd-hero__overlay{
    position:absolute;
    inset:0;
    background: linear-gradient(180deg, rgba(15,23,43,.75), rgba(15,23,43,.55));
}
.vd-hero__content{ position:relative; z-index:1; padding: 60px 0; }
.vd-hero__title{ font-weight:800; letter-spacing:.4px; font-size: clamp(2rem, 4vw, 3.2rem); }
.vd-hero__subtitle{ max-width: 820px; margin: 10px auto 0; color: rgba(255,255,255,.88); }

.vd-section-title{ font-weight: 800; color:#0F172B; }

.vd-venue-card{
    background:#fff;
    border-radius:18px;
    box-shadow: 0 10px 24px rgba(15,23,43,.08);
    padding: 18px;
    display:flex;
    flex-direction:column;
    border: 1px solid rgba(15,23,43,.06);
    transition: transform .2s ease, box-shadow .2s ease;
}
.vd-venue-card:hover{
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(15,23,43,.12);
}
.vd-venue-card__top{
    display:flex;
    gap:12px;
    align-items:center;
    margin-bottom: 14px;
}
.vd-venue-card__icon{
    width:44px; height:44px;
    border-radius:12px;
    display:grid; place-items:center;
    background: rgba(254,161,22,.15);
    color:#FEA116;
    font-size: 18px;
}
.vd-venue-card__name{ font-weight: 800; color:#0F172B; }
.vd-venue-card__meta{
    background: rgba(15,23,43,.03);
    border-radius: 14px;
    padding: 12px;
}
.vd-meta-row{
    display:flex;
    justify-content:space-between;
    gap:10px;
    font-size: 14px;
    padding: 6px 0;
}
.vd-meta-row + .vd-meta-row{ border-top: 1px dashed rgba(15,23,43,.10); }
.vd-meta-label{ color: rgba(15,23,43,.70); }
.vd-meta-value{ color:#0F172B; font-weight:600; }

.vd-event-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    border: 1px solid rgba(15,23,43,.06);
    box-shadow: 0 10px 26px rgba(15,23,43,.08);
    transition: transform .2s ease, box-shadow .2s ease;
}
.vd-event-card:hover{
    transform: translateY(-4px);
    box-shadow: 0 16px 34px rgba(15,23,43,.12);
}
.vd-event-card__media{
    position:relative;
    height: 320px;
    background: rgba(15,23,43,.04);
}
.vd-event-card__badge{
    position:absolute;
    top:14px; left:14px;
    background: rgba(15,23,43,.75);
    color:#fff;
    padding: 8px 10px;
    border-radius: 999px;
    font-size: 12px;
}
.vd-slideshow{ position:absolute; inset:0; }
.vd-slide{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    opacity:0;
    transition: opacity .6s ease;
    cursor: zoom-in;
}
.vd-slide.active{ opacity:1; }

.vd-media-placeholder{
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    gap:8px;
    color: rgba(15,23,43,.55);
}

.vd-event-card__body{ padding: 18px 18px 20px; }
.vd-event-title{ font-weight: 900; color:#0F172B; }
.vd-event-desc{
    color: rgba(15,23,43,.75);
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow:hidden;
}

.vd-cta{
    background: #0F172B;
    color:#fff;
    padding: 70px 0;
}
.vd-cta p{ color: rgba(255,255,255,.85); }

/* Modal */
.vd-modal{
    display:none;
    position:fixed;
    inset:0;
    background: rgba(0,0,0,.78);
    z-index: 9999;
    align-items:center;
    justify-content:center;
    padding: 18px;
}
.vd-modal.show{ display:flex; }
.vd-modal__img{
    max-width: min(1100px, 92vw);
    max-height: 82vh;
    border-radius: 14px;
    box-shadow: 0 18px 55px rgba(0,0,0,.45);
}
.vd-modal__close{
    position:absolute;
    top:14px; right:18px;
    background: rgba(255,255,255,.12);
    border:none;
    color:#fff;
    width:44px; height:44px;
    border-radius: 999px;
    font-size: 28px;
    line-height: 1;
}
.vd-modal__nav{
    position:absolute;
    top:50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,.12);
    border:none;
    color:#fff;
    width:54px; height:54px;
    border-radius: 999px;
    font-size: 26px;
}
.vd-modal__nav--prev{ left: 18px; }
.vd-modal__nav--next{ right: 18px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-slideshow]').forEach(slideshow => {
        const slides = slideshow.querySelectorAll('.vd-slide');
        if (!slides.length) return;

        let index = 0;
        slides[index].classList.add('active');

        setInterval(() => {
            slides[index].classList.remove('active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('active');
        }, 3200);
    });

    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const closeBtn = document.querySelector('.vd-modal__close');
    const prevBtn = document.querySelector('.vd-modal__nav--prev');
    const nextBtn = document.querySelector('.vd-modal__nav--next');

    let currentImages = [];
    let currentIndex = 0;

    function openModal(images, startIndex){
        currentImages = images;
        currentIndex = startIndex;
        modal.classList.add('show');
        modalImg.src = currentImages[currentIndex].src;
    }

    function showImage(index){
        if (!currentImages.length) return;
        currentIndex = (index + currentImages.length) % currentImages.length;
        modalImg.src = currentImages[currentIndex].src;
    }

    document.querySelectorAll('.vd-slide').forEach(img => {
        img.addEventListener('click', () => {
            const eventId = img.dataset.eventId;
            const imgs = Array.from(document.querySelectorAll(`.vd-slide[data-event-id="${eventId}"]`));
            const idx = imgs.indexOf(img);
            openModal(imgs, idx);
        });
    });

    document.querySelectorAll('[data-open-gallery]').forEach(btn => {
        btn.addEventListener('click', () => {
            const eventId = btn.dataset.eventId;
            const imgs = Array.from(document.querySelectorAll(`.vd-slide[data-event-id="${eventId}"]`));
            if (!imgs.length) return;
            openModal(imgs, 0);
        });
    });

    prevBtn?.addEventListener('click', () => showImage(currentIndex - 1));
    nextBtn?.addEventListener('click', () => showImage(currentIndex + 1));
    closeBtn?.addEventListener('click', () => modal.classList.remove('show'));

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('show');
    });

    document.addEventListener('keydown', (e) => {
        if (!modal.classList.contains('show')) return;
        if (e.key === 'Escape') modal.classList.remove('show');
        if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
        if (e.key === 'ArrowRight') showImage(currentIndex + 1);
    });
});
</script>
@endpush
