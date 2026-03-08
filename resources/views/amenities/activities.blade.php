@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="activity-wrap">
    <div class="container">

        <div class="activity-hero">
            <div class="activity-hero-inner">
                <div class="activity-kicker">Villa Diana Hotel</div>
                <h1 class="activity-title">Activities</h1>
                <p class="activity-subtitle">
                    Time to bond with nature — enjoy trails, games, swimming, and relaxing services
                    designed for a refreshing stay.
                </p>

                <div class="activity-badges">
                    <span class="activity-badge"><i class="fa fa-leaf me-2"></i>Nature</span>
                    <span class="activity-badge"><i class="fa fa-dumbbell me-2"></i>Active</span>
                    <span class="activity-badge"><i class="fa fa-spa me-2"></i>Relax</span>
                </div>
            </div>
        </div>

        <div class="activity-card mt-4">
            <div class="row g-3 g-lg-4">

                <div class="col-12">
                    <p class="activity-lead mb-0">
                        <span class="fw-bold text-uppercase">Time to bond with nature!</span>
                        Most of our activities involve spending time with Mother Nature — trees, flowers, landscapes,
                        wide garden spaces, and the sound of singing birds. You might even spot wild ducks!
                    </p>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-person-running"></i></div>
                        <div>
                            <div class="activity-name">Jogging / Walking / Trail Running</div>
                            <div class="activity-desc">Request a trail map at the front desk.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-bicycle"></i></div>
                        <div>
                            <div class="activity-name">Biking</div>
                            <div class="activity-desc">Bring your own bike (rentals not available at the moment).</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-water"></i></div>
                        <div>
                            <div class="activity-name">Swimming</div>
                            <div class="activity-desc">Open daily from <strong>8:00 AM – 8:00 PM</strong>.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-table-tennis-paddle-ball"></i></div>
                        <div>
                            <div class="activity-name">Table Tennis</div>
                            <div class="activity-desc">Available upon request at the front desk.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-volleyball"></i></div>
                        <div>
                            <div class="activity-name">Volleyball</div>
                            <div class="activity-desc">Available upon request at the front desk.</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fa fa-camera"></i></div>
                        <div>
                            <div class="activity-name">Nature Tripping & Photography</div>
                            <div class="activity-desc">Capture memories while enjoying the scenery.</div>
                        </div>
                    </div>
                </div>

                

            </div>
        </div>

    </div>
</div>
@endsection

@section('footer')
    @include('sections.newsletter')
    @include('layouts.footer')
@endsection
