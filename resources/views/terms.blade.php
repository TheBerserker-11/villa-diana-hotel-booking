@extends('layouts.app')

@section('header')
    @include('layouts.header')

    <div class="terms-hero py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <a href="{{ route('home') }}" class="btn btn-light shadow-sm px-3 rounded-pill">
                    <span class="me-2">←</span> Back
                </a>

                <span class="terms-chip">
                    <i class="fa-solid fa-file-contract me-2"></i> Terms
                </span>
            </div>

            <div class="text-center">
                <h1 class="display-5 fw-bold mb-2">Hotel Terms & Conditions</h1>
                <p class="lead text-muted mb-0">
                    Please be reminded that these conditions apply to all guests of the hotel.
                </p>
            </div>
        </div>
    </div>

    <style>
        .terms-hero{
            background:
                radial-gradient(900px 300px at 10% 10%, rgba(254,161,22,.18), transparent 60%),
                radial-gradient(700px 280px at 90% 0%, rgba(15,23,43,.12), transparent 60%),
                linear-gradient(180deg, rgba(15,23,43,.04), rgba(255,255,255,1));
            border-bottom: 1px solid rgba(0,0,0,.06);
        }

        .terms-chip{
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

        .terms-card{
            border: 1px solid rgba(0,0,0,.08);
            border-radius: 20px;
            overflow: hidden;
        }

        .terms-muted{ color: #6B7280; }

        .terms-icon{
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

        .terms-stat{
            background: rgba(255,255,255,.78);
            border: 1px solid rgba(15,23,43,.08);
            border-radius: 16px;
            padding: 14px 14px;
            display:flex;
            gap:12px;
            align-items:flex-start;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .terms-stat:hover{
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(15,23,43,.10);
        }

        .terms-side{
            position: sticky;
            top: 96px;
        }
        @media (max-width: 991.98px){
            .terms-side{ position: static; top:auto; }
        }

        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,43,.10);
            background: rgba(255,255,255,.82);
            font-size: 13px;
            font-weight: 700;
            color: #0F172B;
        }
        .pill strong{ font-weight: 900; }

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

        .terms-kicker{
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

        .terms-callout{
            border-radius: 18px;
            background:
                radial-gradient(700px 240px at 0% 0%, rgba(254,161,22,.16), transparent 60%),
                linear-gradient(180deg, rgba(15,23,43,.03), rgba(255,255,255,1));
            border: 1px solid rgba(15,23,43,.08);
            padding: 16px;
        }
    </style>
@endsection

@section('content')
<div class="container my-5">

    <div class="row g-4 mb-4">
        <!-- Main -->
        <div class="col-12 col-lg-8">
            <div class="card terms-card shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <div class="d-flex gap-3 align-items-start">
                        <div class="terms-icon"><i class="fa-solid fa-file-lines"></i></div>
                        <div>
                            <div class="terms-kicker mb-2">
                                <i class="fa-solid fa-circle-check"></i> Overview
                            </div>
                            <h4 class="fw-bold mb-1">Guidelines for a safe & comfortable stay</h4>
                            <p class="terms-muted mb-0">
                                These terms help keep your booking, stay, and hotel environment clear and fair for everyone.
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex flex-wrap gap-2">
                        <span class="pill"><i class="fa-solid fa-door-open"></i> Check-in: <strong>2:00 PM</strong></span>
                        <span class="pill"><i class="fa-solid fa-clock"></i> No-show release: <strong>4:00 PM</strong></span>
                        <span class="pill"><i class="fa-solid fa-right-from-bracket"></i> Check-out: <strong>12:00 PM</strong></span>
                        <span class="pill"><i class="fa-solid fa-user-group"></i> Visitors until: <strong>10:00 PM</strong></span>
                        <span class="pill"><i class="fa-solid fa-peso-sign"></i> Extra visitor: <strong>₱350</strong>/person</span>
                        <span class="pill"><i class="fa-solid fa-bed"></i> Max per room: <strong>2</strong> persons</span>
                    </div>

                    <div class="terms-callout mt-4 mb-0">
                        <div class="d-flex gap-3">
                            <div class="terms-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                            <div>
                                <div class="fw-bold mb-1">Reminder</div>
                                <div class="terms-muted small">
                                    The hotel may refuse service for unsafe, abusive, or unacceptable behavior to protect guests and staff.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <div class="terms-side">
                <div class="card terms-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Quick Access</h5>

                        <div class="terms-stat mb-3">
                            <div class="terms-icon"><i class="fa-solid fa-bell-concierge"></i></div>
                            <div>
                                <div class="fw-semibold">Bookings & Charges</div>
                                <div class="terms-muted small">Availability, pricing, damages, visitors</div>
                            </div>
                        </div>

                        <div class="terms-stat mb-3">
                            <div class="terms-icon"><i class="fa-solid fa-credit-card"></i></div>
                            <div>
                                <div class="fw-semibold">Payments</div>
                                <div class="terms-muted small">Outstanding balance due on departure</div>
                            </div>
                        </div>

                        <div class="terms-stat">
                            <div class="terms-icon"><i class="fa-solid fa-shield"></i></div>
                            <div>
                                <div class="fw-semibold">Rules & Liability</div>
                                <div class="terms-muted small">Conduct, safety, and responsibility</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="mailto:villadianahotel@gmail.com" class="btn btn-outline-dark w-100 rounded-pill">
                                Contact Support
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="card terms-card shadow-sm">
        <div class="card-body p-4 p-md-5">
            <h4 class="fw-bold mb-2">Terms & Conditions</h4>
            <p class="terms-muted mb-4">Tap a section to expand.</p>

            <div class="accordion" id="termsAccordion">

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            1. Bookings
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                Guests may book in advance or on arrival. Rooms are subject to availability and the hotel reserves the right to refuse booking for good reason.
                                Although payment is generally on departure, guests may be required to provide a deposit on booking or arrival.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            2. Check-in and Check-out Rules
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>
                                Guests may check in anytime from <strong>2:00 PM</strong> on the day of arrival.
                                If the guest has not checked in by <strong>4:00 PM</strong>, the hotel reserves the right to release the room unless the guest has notified the hotel of late arrival.
                                Rooms are held for the entire day of arrival.
                            </p>
                            <p class="mb-0">
                                On departure, guests must vacate their rooms and check-out no later than <strong>12:00 PM</strong>.
                                Failure to do so will entitle the hotel to charge for an additional night.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            3. Charges
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p>
                                Charges are at the hotel’s current room rates available upon request. Pricelists for additional items, such as restaurant meals and room service, are on display at relevant locations and available on request.
                            </p>
                            <p>
                                The hotel reserves the right to charge guests for any damage caused to any of the hotel’s property (including furniture and fixtures).
                            </p>
                            <p class="mb-0">
                                Rooms are allowed a maximum of <strong>2 persons</strong> per room. Visitors of guests are allowed until <strong>10:00 PM</strong>.
                                After this time, they will be asked to register and will be charged <strong>₱350 per person</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            4. Payment
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                Guests must pay all outstanding charges on departure. The hotel reserves the right to hold any guest who refuses to give payment for services acquired.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            5. Cancellation
                        </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                For cancellation of pre-paid bookings, a refund will be given for the fully paid reservations.
                                Deposits will not be returned for cancelled reservations.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            6. Right of Refusal
                        </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                The hotel reserves the right to refuse a guest entry and accommodation if, on arrival, management reasonably considers that the guest is under the influence of alcohol or drugs,
                                unsuitably dressed, or behaving in a threatening, abusive, or otherwise unacceptable manner.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading7">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            7. Disturbance
                        </button>
                    </h2>
                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <p class="mb-0">
                                The hotel reserves the right to require a guest to leave if he/she is causing disturbance, annoying other guests or hotel staff, or behaving in an unacceptable manner.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading8">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            8. Hotel Rules
                        </button>
                    </h2>
                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <ul class="mb-0">
                                <li>Guests shall comply with all reasonable rules and procedures in effect at the hotel, including but not limited to health and security procedures and statutory registration requirements.</li>
                                <li>Guests shall not bring their own food or drink into the hotel for consumption on the premises.</li>
                                <li>Animals are not allowed in the rooms.</li>
                                <li>Children under the age of 14 must be supervised by adult guests at all times.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading9">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            9. Liability
                        </button>
                    </h2>
                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            <ul class="mb-0">
                                <li>The hotel shall not be liable to guests for any loss or damage to property caused by misconduct or negligence of a guest, an act of God, or where the guest remains in exclusive charge of the property concerned.</li>
                                <li>The hotel shall not be liable for any failure or delay in performing obligations due to causes beyond its control, including war, riot, natural disaster, epidemic, bad weather, terrorist activity, government or regulatory action, industrial dispute, failure of power, or other similar events.</li>
                                <li>The hotel is not liable for any loss or damage caused to a guest’s vehicle, unless caused by the hotel’s willful misconduct.</li>
                                <li>Guests will be liable for any loss, damage, or personal injury they may cause at the hotel.</li>
                            </ul>
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