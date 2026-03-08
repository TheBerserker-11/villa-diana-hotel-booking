<div class="container-xxl py-5">
    <div class="container">

        <!-- Section Header -->
        <div class="text-center mb-5">
            <h6 class="section-title text-primary text-uppercase">Our Rooms</h6>
            <h1>Explore Our <span class="text-primary text-uppercase">Rooms</span></h1>
        </div>

        <div class="row g-4 wow fadeInUp" data-wow-delay="0.1s">

        @forelse($rooms as $room)
        <div class="col-lg-4 col-md-6">

            <div class="room-item shadow h-100 d-flex flex-column">

                <!-- Room Image (PRICE REMOVED HERE) -->
                <div class="position-relative">
                    <img 
                        src="{{ asset('storage/rooms/' . $room->image) }}" 
                        class="img-fluid w-100"
                        alt="{{ $room->roomtype->name ?? 'Room' }}"
                        style="height:220px; object-fit:cover;"
                    >
                </div>

                <!-- Card Content -->
                <div class="p-4 d-flex flex-column flex-grow-1">

                    <h5 class="mb-3">
                        {{ $room->roomtype->name ?? 'Room' }}
                    </h5>

                    @php
                        $roomType = $room->roomtype;
                        $inclusions = $roomType?->inclusions;
                    @endphp

                    @if($inclusions && $inclusions->isNotEmpty())
                        <ul class="list-unstyled small mb-4">
                            @foreach($inclusions->take(3) as $inc)
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fa {{ $inc->icon }} text-warning me-2"></i>
                                    <span>{{ $inc->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- CTA ALWAYS AT BOTTOM -->
                    <div class="mt-auto text-center">
                        <a href="{{ route('rooms.index') }}" 
                           class="btn btn-primary rounded-pill py-2 px-4">
                            View More Rooms
                        </a>
                    </div>

                </div>
            </div>

        </div>
        @empty
            <p class="text-center">No rooms available.</p>
        @endforelse

        </div>


        <!-- HOTEL INFO NOTICE (No pricing revealed) -->
        <div class="room-note-box mt-5">

            <div class="room-note-item">
                <i class="fa fa-mug-hot"></i>
                <span>
                    <strong>Breakfast not included.</strong>
                    Additional guest fees may apply.
                </span>
            </div>

            <div class="room-note-divider"></div>

            <div class="room-note-item">
                <i class="fa fa-clock"></i>
                <span>
                    Check-in: <strong>2PM</strong> • Check-out: <strong>12PM</strong>
                </span>
            </div>

            <div class="room-note-divider"></div>

            <div class="room-note-item">
                <i class="fa fa-circle-info"></i>
                <span>
                    Full pricing and availability shown after viewing all rooms.
                </span>
            </div>

        </div>

    </div>
</div>