@extends('admin.layouts.app')

@section('title','Edit Room Type')

@section('content')
<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h2 class="mb-0">Edit Room Type</h2>
            <small class="text-muted">{{ $type->name }}</small>
        </div>

        <a href="{{ route('admin.roomtypes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="vd-card">
        <div class="vd-card-body">

            <form class="row g-3" method="POST" action="{{ route('admin.roomtypes.update', $type->id) }}">
                @csrf
                @method('PUT')

                <div class="col-12 col-md-6">
                    <label for="name" class="form-label">Room Type Name</label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $type->name) }}"
                        class="form-control vd-input @error('name') is-invalid @enderror"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn vd-btn vd-btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Update Room Type
                    </button>

                    <a href="{{ route('admin.roomtypes.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection