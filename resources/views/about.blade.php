@extends('layouts.app')

@section('content')

<section class="about-hero position-relative">
    <div class="about-hero-overlay"></div>

    <div class="container py-5 position-relative" style="z-index:2;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            

            <span class="about-pill">
                <i class="fa fa-leaf me-2"></i>Nature • Comfort • Events
            </span>
        </div>

        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold text-white mb-3">
                    About Villa Diana Hotel
                </h1>
                <p class="lead text-white-50 mb-4" style="max-width: 720px;">
                    A destination born from a love for nature—crafted into a place where families gather,
                    weddings feel magical, and every stay feels like home.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <div class="hero-stat">
                        <div class="hero-stat-number">1993</div>
                        <div class="hero-stat-label">The vision began</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">10,000+</div>
                        <div class="hero-stat-label">Trees planted</div>
                    </div>
                    <div class="hero-stat">
                    <div class="hero-stat-number">
                        150 <span class="ha">ha</span>
                        </div>
                        <div class="hero-stat-label">Nature estate</div>
                </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hero-card shadow-lg">
                    <div class="hero-card-inner">
                        <h5 class="fw-bold mb-2">Where Nature Meets Comfort</h5>
                        <p class="text-muted mb-3">
                            From peaceful stays to unforgettable celebrations, Villa Diana offers a refreshing escape
                            surrounded by lush gardens, rolling hills, and warm hospitality.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="mini-badge"><i class="fa fa-wifi me-1"></i>Free Wi-Fi</span>
                            <span class="mini-badge"><i class="fa fa-concierge-bell me-1"></i>24/7 Front Desk</span>
                            <span class="mini-badge"><i class="fa fa-utensils me-1"></i>Bar + Kitchen</span>
                            <span class="mini-badge"><i class="fa fa-car me-1"></i>Parking</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <div class="about-image-wrap shadow-lg">
                    <img src="{{ asset('img/aboutvd.jpg') }}" alt="About Villa Diana Hotel" class="img-fluid about-image">
                </div>

                <div class="mt-4 p-4 bg-light rounded-4 shadow-sm">
                    <h5 class="fw-bold mb-2">A Living Sanctuary</h5>
                    <p class="text-muted mb-0">
                        What started as a vision became a thriving landscape—home to trees, birds, and memories.
                        Villa Diana grew with nature at its heart.
                    </p>
                </div>
            </div>

            <div class="col-lg-7">
                <h6 class="section-title text-primary text-uppercase">Our Story</h6>
                <h2 class="fw-bold mb-3">Villa Diana Hotel Inc. – History</h2>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">1993 — Love at first sight</h6>
                        <p class="text-muted mb-0">
                            Mrs. Lorna Babaran explored a parcel of land in Cordon, Isabela—complete with a creek,
                            rolling hills, and natural terrain that matched their vision.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">Acquisition & growth</h6>
                        <p class="text-muted mb-0">
                            The land was acquired by Mr. and Mrs. Virgilio Babaran from former Governor Tinio of
                            Gapan, Nueva Ecija.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">Reforestation & nature-first development</h6>
                        <p class="text-muted mb-0">
                            Two years later, reforestation began—over 10,000 seedlings were planted, including hardwood
                            species such as Narra, Tindalo, Dao, Mahogany, and more.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">Infrastructure built with care</h6>
                        <p class="text-muted mb-0">
                            Road networks, drainage systems, fish ponds, composting sites, and retaining walls were developed—
                            creating safe spaces and helping prevent creek erosion. Birds later migrated and made the area
                            their second home—Villa Diana’s Bird Sanctuary.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">From rest house to celebrations</h6>
                        <p class="text-muted mb-0">
                            It started as a family rest house—camping trips and reunions. Visitors admired the place,
                            and soon Villa Diana became a natural venue for gatherings.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">October 25, 1997 — The first wedding</h6>
                        <p class="text-muted mb-0">
                            The first wedding was held under the mango trees—marking the beginning of Villa Diana’s catering
                            and events services, followed by countless celebrations.
                        </p>
                    </div>
                </div>

                <div class="story-block">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">Summer’s Tree House & River Rock Hotel</h6>
                        <p class="text-muted mb-0">
                            A childhood dream became a landmark: Summer’s Tree House. Its charm drew more guests and inspired
                            the family to open the River Rock Hotel.
                        </p>
                    </div>
                </div>

                <div class="story-block mb-4">
                    <div class="story-dot"></div>
                    <div class="story-content">
                        <h6 class="fw-bold mb-1">Today — a destination of excellence</h6>
                        <p class="text-muted mb-0">
                            Villa Diana now spans 150 hectares, including River Rock Hotel, Loma’s Garden, Country Villa,
                            Patio Dolores, Dawn’s Creek, Putting Green, Debbie’s Pond, Gio’s Sports Center, Hilltop,
                            Summer’s Tree House, and the growing Villa Diana Shire (acquired in 2013).
                        </p>
                    </div>
                </div>

                <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm border">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <h4 class="fw-bold mb-0">Why Choose Us?</h4>
                        <span class="text-muted small">Comfort you can feel • Service you can trust</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-hotel"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Elegant, Spacious Rooms</h6>
                                    <p class="text-muted mb-0">Relax in a cozy space designed for comfort.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-smile"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Friendly & Attentive Staff</h6>
                                    <p class="text-muted mb-0">We take care of every detail of your stay.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-map-marked-alt"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Convenient Location</h6>
                                    <p class="text-muted mb-0">A peaceful escape with easy access.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-wifi"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Free Wi-Fi</h6>
                                    <p class="text-muted mb-0">Stay connected throughout your visit.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-coffee"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Great Dining Options</h6>
                                    <p class="text-muted mb-0">Enjoy meals and moments at our café/kitchen.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="choose-card">
                                <i class="fa fa-concierge-bell"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">24/7 Front Desk</h6>
                                    <p class="text-muted mb-0">Support whenever you need it.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="{{ route('contact') }}" class="btn btn-primary px-4 py-2">
                            <i class="fa fa-phone-alt me-2"></i>Contact Us
                        </a>
                        <a href="{{ route('rooms.index') ?? '#' }}" class="btn btn-outline-dark px-4 py-2">
                            <i class="fa fa-bed me-2"></i>Explore Rooms
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
/* ===== About Page Modern Styles ===== */
.about-hero{
    background-image: url("{{ asset('img/aboutvd.jpg') }}");
    background-size: cover;
    background-position: center;
    min-height: 420px;
}
.about-hero-overlay{
    position:absolute;
    inset:0;
    background: linear-gradient(90deg, rgba(15,23,43,.92), rgba(15,23,43,.55));
}
.about-pill{
    display: inline-flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,.14);
    color: #fff;
    font-weight: 700;
    letter-spacing: .3px;
    border: 1px solid rgba(255,255,255,.18);
}

.hero-card{
    border-radius: 18px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(6px);
}
.hero-card-inner{ padding: 22px; }
.mini-badge{
    display:inline-flex;
    align-items:center;
    padding: 7px 10px;
    border-radius: 999px;
    background: rgba(254,161,22,.14);
    color: #0F172B;
    font-weight: 700;
    font-size: .85rem;
    border: 1px solid rgba(254,161,22,.25);
}

.hero-stat{
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 14px;
    padding: 12px 14px;
    min-width: 160px;
}
.hero-stat-number{
    color: #fff;
    font-weight: 900;
    font-size: 1.25rem;
    line-height: 1.1;
}
.hero-stat-label{
    color: rgba(255,255,255,.7);
    font-size: .85rem;
    margin-top: 4px;
}

.about-image-wrap{
    border-radius: 18px;
    overflow: hidden;
}
.about-image{
    width: 100%;
    height: 420px;
    object-fit: cover;
}

.story-block{
    position: relative;
    display: flex;
    gap: 14px;
    padding: 14px 0;
}
.story-block:before{
    content:"";
    position:absolute;
    left: 7px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(15,23,43,.12);
}
.story-dot{
    width: 16px;
    height: 16px;
    border-radius: 999px;
    background: rgba(254,161,22,.95);
    margin-top: 4px;
    box-shadow: 0 0 0 5px rgba(254,161,22,.18);
    flex: 0 0 auto;
}
.story-content{ padding-bottom: 2px; }

.choose-card{
    display: flex;
    gap: 12px;
    padding: 14px 14px;
    border-radius: 14px;
    background: rgba(15,23,43,.04);
    border: 1px solid rgba(15,23,43,.07);
    transition: .2s ease;
    height: 100%;
}
.choose-card:hover{
    transform: translateY(-2px);
    background: rgba(254,161,22,.07);
    border-color: rgba(254,161,22,.20);
}
.choose-card i{
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(254,161,22,.15);
    color: #0F172B;
    font-size: 18px;
    flex: 0 0 auto;
}
/* ===== About CTA Buttons (Round Edge) ===== */
.about-hero .btn,
.container .btn {
    border-radius: 999px !important;   /* full pill */
    font-weight: 700;
    letter-spacing: .03em;
    padding: 10px 22px;
    transition: all .25s ease;
}

/* Specific to Why Choose Us buttons */
.bg-white .btn-primary,
.bg-white .btn-outline-dark {
    border-radius: 999px !important;
}

/* Hover lift effect */
.bg-white .btn-primary:hover,
.bg-white .btn-outline-dark:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,.12);
}

</style>
@endpush