@extends('layouts.app')

@section('content')

<section class="contact-hero position-relative">
    <div class="contact-hero-overlay"></div>

    <div class="container py-5 position-relative" style="z-index:2;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            

            <span class="contact-pill">
                <i class="fa fa-headset me-2"></i>Support • Booking • Inquiries
            </span>
        </div>

        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold text-white mb-2">Contact Us</h1>
                <p class="lead text-white-50 mb-0" style="max-width: 720px;">
                    We’d love to hear from you. Send us a message for questions, feedback, or booking inquiries —
                    our team is ready to help.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="contact-hero-card shadow-lg">
                    <div class="contact-hero-card-inner">
                        <h6 class="fw-bold mb-2">Quick Contact</h6>
                        <div class="d-flex flex-column gap-2">
                            <a href="tel:09175506588" class="quick-link">
                                <i class="fa fa-phone-alt me-2"></i> 0917-550-6588
                            </a>
                            <a href="mailto:villadianahotel@gmail.com" class="quick-link">
                                <i class="fa fa-envelope me-2"></i> villadianahotel@gmail.com
                            </a>
                            <a href="https://www.facebook.com/villadianahotel/" class="quick-link" target="_blank">
                                <i class="fab fa-facebook-f me-2"></i> Facebook Page
                            </a>
                            <a href="https://www.instagram.com/ilovevilladiana/" class="quick-link" target="_blank">
                                <i class="fab fa-instagram me-2"></i> Instagram
                            </a>
                        </div>
                        <small class="text-muted d-block mt-3">
                            <i class="fa fa-clock me-1"></i> Open 24/7 for inquiries
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-4">

            <div class="col-lg-5">
                <div class="row g-3">

                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4 rounded-4 contact-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Hotel Address</h6>
                                    <p class="text-muted mb-0">
                                        Villa Diana Hotel<br>
                                        Capirpiriwan, Cordon, Isabela, Philippines 3312, Isabela
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card border-0 shadow-sm p-4 rounded-4 contact-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box">
                                    <i class="fa fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Phone</h6>
                                    <a class="text-muted text-decoration-none" href="tel:09175506588">
                                        0917-550-6588
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card border-0 shadow-sm p-4 rounded-4 contact-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email</h6>
                                    <a class="text-muted text-decoration-none" href="mailto:villadianahotel@gmail.com">
                                        villadianahotel@gmail.com
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4 rounded-4 contact-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box">
                                    <i class="fa fa-share-alt"></i>
                                </div>
                                <div class="w-100">
                                    <h6 class="fw-bold mb-2">Social</h6>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a class="btn btn-outline-dark btn-sm px-3" target="_blank"
                                           href="https://www.facebook.com/villadianahotel/">
                                            <i class="fab fa-facebook-f me-2"></i>Facebook
                                        </a>
                                        <a class="btn btn-outline-dark btn-sm px-3" target="_blank"
                                           href="https://www.instagram.com/ilovevilladiana/">
                                            <i class="fab fa-instagram me-2"></i>Instagram
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden contact-form-card">
                    <div class="p-4 p-md-5" style="background: rgba(254,161,22,.08);">
                        <h4 class="fw-bold mb-1">Send us a message</h4>
                        <p class="text-muted mb-4">We usually reply as soon as possible.</p>

                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Name</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white"><i class="fa fa-user text-muted"></i></span>
                                        <input type="text" class="form-control" placeholder="Your Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white"><i class="fa fa-envelope text-muted"></i></span>
                                        <input type="email" class="form-control" placeholder="Your Email">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white"><i class="fa fa-comment-dots text-muted"></i></span>
                                        <textarea class="form-control" rows="5" placeholder="Write your message..."></textarea>
                                    </div>
                                </div>

                                <div class="col-12 pt-2">
                                    <button type="submit" class="btn btn-primary btn-lg px-4 w-100">
                                        <i class="fa fa-paper-plane me-2"></i>Send Message
                                    </button>
                                    <small class="text-muted d-block text-center mt-2">
                                        For bookings, please include preferred date(s) and number of guests.
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
                    <div class="p-3 border-bottom bg-white">
                        <h6 class="fw-bold mb-0"><i class="fa fa-map me-2 text-primary"></i>Find us on the map</h6>
                    </div>

                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps?q=Cordon%20Isabela%20Villa%20Diana%20Hotel&output=embed"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<style>
/* ===== Contact Page Modern Styles ===== */
.contact-hero{
    background: linear-gradient(180deg, rgba(15,23,43,.92), rgba(15,23,43,.75)),
        url("{{ asset('img/aboutvd.jpg') }}");
    background-size: cover;
    background-position: center;
    min-height: 360px;
}
.contact-hero-overlay{
    position:absolute;
    inset:0;
    background: linear-gradient(90deg, rgba(15,23,43,.88), rgba(15,23,43,.35));
}
.contact-pill{
    display: inline-flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,.14);
    color: #fff;
    font-weight: 700;
    border: 1px solid rgba(255,255,255,.18);
}
.contact-hero-card{
    border-radius: 18px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(6px);
}
.contact-hero-card-inner{ padding: 22px; }
.quick-link{
    display: inline-flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 12px;
    background: rgba(15,23,43,.06);
    color: #0F172B;
    text-decoration: none;
    font-weight: 700;
    transition: .2s ease;
}
.quick-link:hover{
    background: rgba(254,161,22,.15);
    transform: translateY(-1px);
}
.contact-card{ transition: .2s ease; }
.contact-card:hover{
    transform: translateY(-2px);
    border-color: rgba(254,161,22,.22);
}
.icon-box{
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(254,161,22,.16);
    color: #0F172B;
    flex: 0 0 auto;
}
.rounded-4{ border-radius: 18px !important; }
</style>
@endpush