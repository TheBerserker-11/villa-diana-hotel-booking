@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')

<div class="container-xxl py-5">
    <div class="container" style="max-width:900px;">

        <!-- Page Header -->
        <div class="text-center mb-5">
            <h6 class="section-title text-primary text-uppercase">Help Center</h6>
            <h1>Frequently Asked <span class="text-primary">Questions</span></h1>
            <p class="text-muted">Everything you need to know before booking your stay.</p>
        </div>

        <div class="accordion" id="faqAccordion">

            <!-- 1 BOOKING -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        How do I book a room?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Browse available rooms, choose your dates and number of guests, then proceed to payment.
                        You must create an account before confirming your booking.
                    </div>
                </div>
            </div>

            <!-- 2 ACCOUNT -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Do I need an account to book?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        You can browse rooms and view the booking summary as a guest, but you must log in or register
                        to confirm the booking and proceed with payment.
                    </div>
                </div>
            </div>

            <!-- 3 AVAILABILITY -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Why does it say “Search availability first”?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        To show accurate availability, please select your check-in and check-out dates first.
                        The system will hide rooms that are already booked for the selected dates.
                    </div>
                </div>
            </div>

            <!-- 4 PAYMENT -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq4">
                        What payment methods do you accept?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        We currently accept <strong>GCash payments</strong>.
                        After paying, enter your <strong>GCash reference code</strong> and upload proof (optional).
                    </div>
                </div>
            </div>

            <!-- 5 REFERENCE CODE -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq5">
                        Where can I find my GCash reference code?
                    </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        After sending your GCash payment, open your GCash transaction receipt/history and copy the
                        <strong>13-digit reference number</strong> shown on the transaction details.
                    </div>
                </div>
            </div>

            <!-- 6 CONFIRMATION -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq6">
                        Is my booking confirmed immediately after payment?
                    </button>
                </h2>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        After submitting your booking, it will be marked <strong>Pending</strong>.
                        Our staff/admin will review and confirm your booking.
                    </div>
                </div>
            </div>

            <!-- 7 CHECK-IN OUT -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq7">
                        What are the check-in and check-out times?
                    </button>
                </h2>
                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Check-in: <strong>2:00 PM</strong><br>
                        Check-out: <strong>12:00 PM</strong>
                    </div>
                </div>
            </div>

            <!-- 8 EARLY/LATE -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq8">
                        Can I request early check-in or late check-out?
                    </button>
                </h2>
                <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, you may request early check-in or late check-out depending on availability.
                        Additional charges may apply. Please contact us before your arrival.
                    </div>
                </div>
            </div>

            <!-- 9 EXTRA GUEST -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq9">
                        Is there a charge for extra guests?
                    </button>
                </h2>
                <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Extra guests cost <strong>₱1,200 per night</strong> and include beddings, towels, and toiletries.
                        The system automatically calculates extra guest fees based on your total guests.
                    </div>
                </div>
            </div>

            <!-- 10 CHILDREN/INFANTS -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq10">
                        Are children and infants counted as guests?
                    </button>
                </h2>
                <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Adults, children, and infants are included in the guest count for capacity and pricing computation.
                    </div>
                </div>
            </div>

            <!-- 11 PETS -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq11">
                        Are pets allowed?
                    </button>
                </h2>
                <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Pet policy may vary per room and hotel rules. Please contact us to confirm if pets are allowed for your stay.
                    </div>
                </div>
            </div>

            <!-- 12 CANCELLATION -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq12">
                        Can I cancel my booking?
                    </button>
                </h2>
                <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Cancellation rules depend on your booking type. Fully paid reservations may be refunded based on policy,
                        while deposits for cancelled reservations are generally non-refundable.
                    </div>
                </div>
            </div>

            <!-- 13 CHANGES -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq13">
                        Can I change my booking dates after submitting?
                    </button>
                </h2>
                <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        If you need to change your booking details, please contact us as soon as possible.
                        Changes are subject to availability and policy.
                    </div>
                </div>
            </div>

            <!-- 14 ID REQUIREMENT -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq14">
                        Do I need to present a valid ID upon check-in?
                    </button>
                </h2>
                <div id="faq14" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Please bring at least one valid government-issued ID for verification upon check-in.
                    </div>
                </div>
            </div>

            <!-- 15 WIFI / AMENITIES -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq15">
                        What amenities are included?
                    </button>
                </h2>
                <div id="faq15" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Amenities vary per room type. You can view inclusions under each room.
                        Common inclusions include Wi-Fi, air-conditioning, private bathroom, and toiletries.
                    </div>
                </div>
            </div>

            <!-- 16 PARKING -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq16">
                        Is parking available?
                    </button>
                </h2>
                <div id="faq16" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Parking availability depends on the property capacity. Please contact us for current parking guidelines.
                    </div>
                </div>
            </div>

            <!-- 17 EVENTS -->
            <div class="accordion-item mb-3 border-0 shadow-sm">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq17">
                        Do you host events and weddings?
                    </button>
                </h2>
                <div id="faq17" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes! We offer venues for corporate events, weddings, birthdays, retreats, and team building.
                        You can also check our Events page for updates.
                    </div>
                </div>
            </div>

        </div>

        <!-- Contact CTA -->
        <div class="text-center mt-5">
            <h5>Still have questions?</h5>
            <p class="text-muted">Our team is happy to help.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-center">
                <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill px-4 py-2">
                    Contact Us
                </a>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                    View Rooms
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@section('footer')
    @include('layouts.footer')
@endsection