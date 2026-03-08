<!-- ===== MODERN FOOTER START ===== -->
<footer class="villa-footer text-light">

    <div class="container py-5">

        <div class="row g-5">

            <!-- HOTEL BRAND -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">
                    <h3 class="fw-bold text-white mb-3">Villa Diana Hotel</h3>

                    <p class="footer-tagline">
                        Where nature meets comfort.  
                        Experience peaceful stays, memorable events, and warm hospitality
                        just minutes away from Santiago City.
                    </p>

                    <div class="footer-social mt-4">
                        <a href="https://www.facebook.com/villadianahotel/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="social-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://www.instagram.com/ilovevilladiana/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="social-circle">
                             <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CONTACT -->
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Contact Information</h5>

                <div class="footer-contact">
                    <p><i class="fa fa-map-marker-alt"></i> Capirpiriwan, Cordon, Isabela</p>
                    <p><i class="fa fa-phone-alt"></i> 0917-550-6588</p>
                    <p><i class="fa fa-envelope"></i> villadianahotel@gmail.com</p>
                </div>

                <div class="footer-hours mt-4">
                    <small class="text-muted">Open 24/7 for reservations & inquiries</small>
                </div>
            </div>

            <!-- QUICK LINKS -->
            <div class="col-lg-4 col-md-12">
                <h5 class="footer-title">Quick Links</h5>

                <div class="row">
                    <div class="col-6">
                        <ul class="footer-links">
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                             <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>

                    <div class="col-6">
                        <ul class="footer-links">
                            <li><i class="fa fa-wifi me-2"></i>Free Wi-Fi</li>
                            <li><i class="fa fa-concierge-bell me-2"></i>24/7 Front Desk</li>
                            <li><i class="fa fa-utensils me-2"></i>Bar & Kitchen</li>
                            <li><i class="fa fa-car me-2"></i>Huge Parking</li>
                            <li><i class="fa fa-bed me-2"></i>Room Service</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SUB FOOTER -->
    <div class="footer-bottom">
        <div class="container d-md-flex justify-content-between text-center text-md-start">
            <p class="mb-0">
                © {{ date('Y') }} <strong>Villa Diana Hotel</strong>. All rights reserved.
            </p>

            <small class="text-muted">
                Designed & Developed for Hotel Booking System
            </small>
        </div>
    </div>

</footer>

<!-- Luxury Back To Top -->
<a href="#" class="vd-backtotop" aria-label="Back to top">
    <i class="bi bi-arrow-up-short"></i>
</a>