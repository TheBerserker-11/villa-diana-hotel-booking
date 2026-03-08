<div class="container-xxl py-5">
    <div class="container">

        <!-- Section Title -->
        <div class="text-center mb-5">
            <h6 class="section-title text-primary text-uppercase">Our Team</h6>
            <h1 class="mb-4">Meet the <span class="text-primary text-uppercase">Villa Diana Staff</span></h1>
            <p class="text-muted">Friendly faces dedicated to making your stay unforgettable.</p>
        </div>

        <!-- Team Grid -->
        <div class="row g-4 justify-content-center">

            @php
                $staffs = [
                    ['img'=>'p1.jpg','name'=>'Glenda Cawagas','role'=>'Hotel Staff'],
                    ['img'=>'p2.jpg','name'=>'Monette Fajardo','role'=>'Hotel Staff'],
                    ['img'=>'p3.png','name'=>'Creselle Maraña','role'=>'Front Desk'],
                    ['img'=>'p3.jpg','name'=>'Kenn Tucay','role'=>'Hotel Staff'],
                    ['img'=>'p4.jpg','name'=>'Sunshine Sanglay','role'=>'Hotel Staff'],
                ];
            @endphp

            @foreach($staffs as $index => $staff)
            <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.{{ $index+1 }}s">

                <div class="team-card shadow-sm">

                    <div class="team-img-wrapper">
                        <img src="{{ asset('img/team/'.$staff['img']) }}" class="img-fluid" alt="{{ $staff['name'] }}">
                    </div>

                    <div class="team-info text-center">
                        <h5 class="mb-1">{{ $staff['name'] }}</h5>
                        <small class="text-muted">{{ $staff['role'] }}</small>
                    </div>

                </div>

            </div>
            @endforeach

        </div>
    </div>
</div>
