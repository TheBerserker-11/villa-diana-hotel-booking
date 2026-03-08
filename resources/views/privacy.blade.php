@extends('layouts.app')

@section('header')
    @include('layouts.header')

    <div class="privacy-hero py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <a href="{{ route('home') }}" class="btn btn-light shadow-sm px-3 rounded-pill">
                    <span class="me-2">←</span> Back
                </a>

                <span class="privacy-chip">
                    <i class="fa-solid fa-shield-halved me-2"></i> Privacy
                </span>
            </div>

            <div class="text-center">
                <h1 class="display-5 fw-bold mb-2">Privacy Policy</h1>
                <p class="lead text-muted mb-0">
                    At Villa Diana Hotel, we respect your privacy and keep your information secure.
                </p>
            </div>
        </div>
    </div>

    <style>
        .privacy-hero{
            background:
                radial-gradient(900px 300px at 10% 10%, rgba(254,161,22,.18), transparent 60%),
                radial-gradient(700px 280px at 90% 0%, rgba(15,23,43,.12), transparent 60%),
                linear-gradient(180deg, rgba(15,23,43,.04), rgba(255,255,255,1));
            border-bottom: 1px solid rgba(0,0,0,.06);
        }

        .privacy-chip{
            display:inline-flex;
            align-items:center;
            padding:10px 14px;
            border-radius:999px;
            background: rgba(15,23,43,.06);
            border: 1px solid rgba(15,23,43,.10);
            color: #0F172B;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-size: 12px;
        }

        .privacy-card{
            border: 1px solid rgba(0,0,0,.08);
            border-radius: 20px;
            overflow: hidden;
        }

        .privacy-muted{ color:#6B7280; }

        .privacy-icon{
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(254,161,22,.14);
            border: 1px solid rgba(254,161,22,.22);
            color: #0F172B;
            font-size: 18px;
            flex: 0 0 auto;
        }

        .privacy-stat{
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(15,23,43,.08);
            border-radius: 16px;
            padding: 14px 14px;
            display:flex;
            gap:12px;
            align-items:flex-start;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .privacy-stat:hover{
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(15,23,43,.10);
        }

        .privacy-side{
            position: sticky;
            top: 96px;
        }
        @media (max-width: 991.98px){
            .privacy-side{ position: static; top:auto; }
        }

        .privacy-contact{
            border-radius: 18px;
            background:
                radial-gradient(700px 240px at 0% 0%, rgba(254,161,22,.16), transparent 60%),
                linear-gradient(180deg, rgba(15,23,43,.03), rgba(255,255,255,1));
            border: 1px solid rgba(15,23,43,.08);
            padding: 16px;
        }

        /* Accordion – premium look */
        .accordion{ --bs-accordion-border-color: rgba(15,23,43,.10); }

        .accordion-item{
            border-radius: 16px !important;
            overflow: hidden;
            border: 1px solid rgba(15,23,43,.10) !important;
            box-shadow: 0 10px 26px rgba(15,23,43,.06);
        }

        .accordion-button{
            font-weight: 800;
            letter-spacing: .02em;
        }

        .accordion-button:not(.collapsed){
            background: rgba(254,161,22,.12);
            color: #0F172B;
            box-shadow: none;
        }

        .accordion-button:focus{
            box-shadow: 0 0 0 .2rem rgba(254,161,22,.18);
            border-color: rgba(254,161,22,.35);
        }

        .privacy-kicker{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 12px;
            border-radius:999px;
            background: rgba(254,161,22,.12);
            border: 1px solid rgba(254,161,22,.25);
            color:#0F172B;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .10em;
        }
    </style>
@endsection

@section('content')
<div class="container my-5">

    <div class="row g-4 mb-4">
        <!-- Main -->
        <div class="col-12 col-lg-8">
            <div class="card privacy-card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="privacy-icon"><i class="fa-solid fa-lock"></i></div>
                        <div>
                            <div class="privacy-kicker mb-2">
                                <i class="fa-solid fa-circle-check"></i> Overview
                            </div>
                            <h4 class="fw-bold mb-1">Your privacy matters</h4>
                            <p class="privacy-muted mb-0">
                                This policy explains what we collect, why we collect it, and how we protect it when you use our website and booking services.
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="privacy-stat">
                                <div class="privacy-icon"><i class="fa-solid fa-receipt"></i></div>
                                <div>
                                    <div class="fw-semibold">We collect</div>
                                    <div class="privacy-muted small">Basic booking details & usage data</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="privacy-stat">
                                <div class="privacy-icon"><i class="fa-solid fa-gears"></i></div>
                                <div>
                                    <div class="fw-semibold">We use it</div>
                                    <div class="privacy-muted small">To process bookings and improve service</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="privacy-stat">
                                <div class="privacy-icon"><i class="fa-solid fa-shield-halved"></i></div>
                                <div>
                                    <div class="fw-semibold">We protect it</div>
                                    <div class="privacy-muted small">Using security best practices</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <div class="privacy-side">
                <div class="card privacy-card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Quick Summary</h5>

                        <div class="d-flex gap-3 mb-3">
                            <div class="privacy-icon"><i class="fa-solid fa-eye"></i></div>
                            <div>
                                <div class="fw-semibold">Transparent</div>
                                <div class="privacy-muted small">We tell you what we collect and why.</div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-3">
                            <div class="privacy-icon"><i class="fa-solid fa-bell-slash"></i></div>
                            <div>
                                <div class="fw-semibold">Opt-out</div>
                                <div class="privacy-muted small">You may opt-out of promotions anytime.</div>
                            </div>
                        </div>

                        <div class="privacy-contact mt-3">
                            <div class="d-flex gap-3">
                                <div class="privacy-icon"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <div class="fw-semibold">Need help?</div>
                                    <div class="privacy-muted small">
                                        Email us at
                                        <a href="mailto:villadianahotel@gmail.com" class="text-decoration-none fw-semibold">
                                            villadianahotel@gmail.com
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="card privacy-card shadow-sm">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold mb-2">Policy Details</h4>
            <p class="privacy-muted mb-4">
                Below are the details of our privacy practices in a readable format.
            </p>

            <div class="accordion" id="privacyAccordion">

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="headingCollect">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCollect" aria-expanded="true" aria-controls="collapseCollect">
                            Information We Collect
                        </button>
                    </h2>
                    <div id="collapseCollect" class="accordion-collapse collapse show" aria-labelledby="headingCollect" data-bs-parent="#privacyAccordion">
                        <div class="accordion-body">
                            <ul class="mb-0">
                                <li>Personal details (name, contact information, etc.) during bookings</li>
                                <li>Payment information</li>
                                <li>Website usage data via cookies</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="headingUse">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUse" aria-expanded="false" aria-controls="collapseUse">
                            How We Use Your Data
                        </button>
                    </h2>
                    <div id="collapseUse" class="accordion-collapse collapse" aria-labelledby="headingUse" data-bs-parent="#privacyAccordion">
                        <div class="accordion-body">
                            <ul class="mb-0">
                                <li>To process bookings and payments</li>
                                <li>To improve our services and website</li>
                                <li>To send promotional offers (you may opt-out)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="headingProtect">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProtect" aria-expanded="false" aria-controls="collapseProtect">
                            Data Protection
                        </button>
                    </h2>
                    <div id="collapseProtect" class="accordion-collapse collapse" aria-labelledby="headingProtect" data-bs-parent="#privacyAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                We implement industry-standard security measures to protect your data from unauthorized access or disclosure.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingContact">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                            Contact
                        </button>
                    </h2>
                    <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact" data-bs-parent="#privacyAccordion">
                        <div class="accordion-body">
                            <p class="mb-2">
                                If you have any concerns regarding your privacy, please email us at:
                            </p>
                            <div class="p-3 rounded-4 border bg-light">
                                <span class="fw-semibold">villadianahotel@gmail.com</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /accordion -->
        </div>
    </div>

</div>
@endsection

@section('footer')
    @include('sections.newsletter')
    @include('layouts.footer')

    <footer class="text-center py-4 border-top mt-5">
        <p class="mb-0">&copy; {{ date('Y') }} Villa Diana Hotel. All rights reserved.</p>
    </footer>
@endsection