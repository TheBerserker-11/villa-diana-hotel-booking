@extends('admin.layouts.app')

@section('title','Edit Event')

@section('content')
@include('components.show-success')

<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h2 class="mb-0">Edit Event</h2>
            <small class="vd-small-muted">{{ $event->name }}</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- Card --}}
    <div class="vd-card">
        <div class="vd-card-body">

            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Event Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $event->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        required
                    >{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Main Image</label>

                    @if($event->image)
                        <div class="mb-2">
                            <img
                                src="{{ $event->image_url }}"
                                class="img-thumbnail"
                                style="max-width:180px;"
                                alt="Main Image"
                            >
                        </div>
                    @endif

                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted d-block mt-1">Leave empty to keep the current main image.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Images</label>

                    @if($event->images && $event->images->count())
                        <div class="row g-2 mb-2">
                            @foreach($event->images as $img)
                                <div class="col-6 col-md-3 col-lg-2">
                                    <img
                                        src="{{ $img->image_url }}"
                                        class="img-thumbnail w-100"
                                        style="height:100px;object-fit:cover;"
                                        alt="Event Image"
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <input type="file"
                           name="images[]"
                           class="form-control @error('images') is-invalid @enderror"
                           multiple accept="image/*">
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="text-muted d-block mt-1">
                        Uploading adds new images (does not delete existing ones).
                    </small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle me-1"></i> Update Event
                    </button>

                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
