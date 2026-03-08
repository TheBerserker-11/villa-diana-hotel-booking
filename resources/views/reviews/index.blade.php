@extends('layouts.app')

@section('content')
<div class="container-xxl py-5 reviews-page">
    <div class="container">

        <div class="text-center mb-5">
            <h6 class="section-title text-primary text-uppercase">Testimonials</h6>
            <h1 class="mb-2">Guest Reviews</h1>
            <p class="text-muted mb-0 reviews-intro-copy">
                Real experiences from guests who stayed and celebrated with us at Villa Diana Hotel.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger shadow-sm border-0">
                <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger shadow-sm border-0">
                <i class="fa fa-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <div class="row g-4 align-items-start">

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg review-form-card overflow-hidden">
                    <div class="p-4 p-md-5 review-form-shell">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h4 class="mb-1">Write a Review</h4>
                                <small class="text-muted">Share your experience with other guests</small>
                            </div>
                            <div class="review-badge">
                                <i class="fa fa-star me-1"></i> Villa Diana
                            </div>
                        </div>

                        @guest
                            <div class="p-3 bg-white rounded-3 shadow-sm">
                                <p class="text-muted mb-3">
                                    You need to log in first to write a review.
                                </p>
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                    <i class="fa fa-sign-in-alt me-2"></i>Log in to Write a Review
                                </a>
                            </div>
                        @endguest

                        @auth
                            @if($canWriteReview)
                                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Your name" value="{{ old('name', Auth::user()->name) }}" required>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Location</label>
                                            <input type="text" name="location" class="form-control form-control-lg" placeholder="e.g., Isabela" value="{{ old('location') }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Avatar</label>
                                            <input type="file" name="avatar" class="form-control">
                                            <small class="text-muted">Optional. JPG/PNG recommended.</small>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Title</label>
                                            <input type="text" name="title" class="form-control form-control-lg" placeholder="e.g., Amazing stay!" value="{{ old('title') }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Insider Tip</label>
                                            <input type="text" name="insider_tip" class="form-control form-control-lg" placeholder="e.g., Try the Brickyard Bar at night" value="{{ old('insider_tip') }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Review <span class="text-danger">*</span></label>
                                            <textarea name="content" rows="4" class="form-control form-control-lg" placeholder="Tell us what you loved..." required>{{ old('content') }}</textarea>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                                            <select name="rating" class="form-select form-select-lg" required>
                                                <option value="5" {{ old('rating', '5') == '5' ? 'selected' : '' }}>&#9733;&#9733;&#9733;&#9733;&#9733; (5) Excellent</option>
                                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>&#9733;&#9733;&#9733;&#9733;&#9734; (4) Very Good</option>
                                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>&#9733;&#9733;&#9733;&#9734;&#9734; (3) Good</option>
                                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>&#9733;&#9733;&#9734;&#9734;&#9734; (2) Fair</option>
                                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>&#9733;&#9734;&#9734;&#9734;&#9734; (1) Poor</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label fw-semibold">Date of Stay</label>
                                            <input type="date" name="stay_date" class="form-control form-control-lg" value="{{ old('stay_date') }}">
                                        </div>

                                        <div class="col-12 pt-2">
                                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                                <i class="fa fa-paper-plane me-2"></i>Submit Review
                                            </button>
                                            <small class="text-muted d-block text-center mt-2">
                                                By submitting, you agree your review may be displayed publicly.
                                            </small>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="p-3 bg-white rounded-3 shadow-sm mt-3">
                                    <p class="text-muted mb-3">
                                        {{ $reviewEligibilityMessage }}
                                    </p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fa fa-receipt me-2"></i>View My Bookings
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="mb-0">Latest Reviews</h4>
                    <span class="text-muted small">
                        {{ $reviews->count() }} review{{ $reviews->count() > 1 ? 's' : '' }}
                    </span>
                </div>

                <div class="reviews-list">
                    @forelse($reviews as $review)
                        <div class="card border-0 shadow-sm mb-4 review-card overflow-hidden">
                            <div class="p-4 p-md-4">

                                <div class="d-flex align-items-start gap-3">
                                    <div class="avatar-wrap">
                                        <img
                                            src="{{ $review->avatar ? asset('storage/' . $review->avatar) : asset('img/default-avatar.jpg') }}"
                                            alt="{{ $review->name }}"
                                            class="review-avatar"
                                        >
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <h6 class="mb-0 fw-bold">{{ $review->name }}</h6>
                                            @if($review->location)
                                                <span class="text-muted small">
                                                    <i class="fa fa-map-marker-alt me-1"></i>{{ $review->location }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                                            <div class="rating-pill">
                                                {!! str_repeat('<i class="fa fa-star"></i>', (int)$review->rating) !!}
                                                {!! str_repeat('<i class="fa fa-star text-muted opacity-50"></i>', 5 - (int)$review->rating) !!}
                                                <span class="ms-2">{{ (int)$review->rating }}/5</span>
                                            </div>

                                            @if($review->stay_date)
                                                <span class="text-muted small">
                                                    <i class="fa fa-calendar-alt me-1"></i>
                                                    Stayed {{ \Carbon\Carbon::parse($review->stay_date)->format('F Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @auth
                                        @if(Auth::id() === $review->user_id)
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-danger delete-btn"
                                                data-delete-form-id="deleteForm-{{ $review->id }}"
                                                title="Delete review"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                                @if($review->insider_tip)
                                    <div class="insider-tip mt-3">
                                        <span class="tip-badge"><i class="fa fa-lightbulb me-1"></i>Insider Tip</span>
                                        <span class="ms-2">{{ $review->insider_tip }}</span>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <h5 class="mb-2 review-title">
                                        {{ $review->title ? $review->title : 'Guest Review' }}
                                    </h5>

                                    @php
                                        $content = $review->content ?? '';
                                        $isLong = strlen($content) > 220;
                                        $short = $isLong ? substr($content, 0, 220) . '...' : $content;
                                    @endphp

                                    <p class="text-muted mb-0 review-content">
                                        <span class="preview-text">{{ $short }}</span>

                                        @if($isLong)
                                            <a href="javascript:void(0)" class="read-more ms-1">Read more</a>
                                            <span class="full-text d-none">{{ $content }}</span>
                                        @endif
                                    </p>
                                </div>

                                @auth
                                    @if(Auth::id() === $review->user_id)
                                        <form
                                            id="deleteForm-{{ $review->id }}"
                                            action="{{ route('reviews.destroy', $review->id) }}"
                                            method="POST"
                                            class="d-none review-delete-form"
                                        >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                @endauth

                            </div>
                        </div>
                    @empty
                        <div class="card border-0 shadow-sm p-4 text-center">
                            <h5 class="mb-2">No reviews yet</h5>
                            <p class="text-muted mb-0">Be the first to share your experience at Villa Diana Hotel.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<div id="deleteModal" class="modal-overlay d-none">
    <div class="modal-content card border-0 shadow-lg p-4 p-md-5">
        <h4 class="mb-2">Delete this review?</h4>
        <p class="text-muted mb-4">
            This action cannot be undone.
        </p>
        <div class="d-flex justify-content-end gap-2">
            <button id="cancelDelete" class="btn btn-light border">Cancel</button>
            <button id="confirmDelete" class="btn btn-danger">
                <i class="fa fa-trash me-2"></i>Delete
            </button>
        </div>
    </div>
</div>
@endsection
