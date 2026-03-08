@extends('admin.layouts.app')

@section('title','Create Room Type')

@section('content')
<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h2 class="mb-0">Create Room Type</h2>
            <small class="text-muted">Add a new room classification</small>
        </div>

        <a href="{{ route('admin.roomtypes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="vd-card">
        <div class="vd-card-body">

            <form class="row g-3" method="POST" action="{{ route('admin.roomtypes.store') }}">
                @csrf

                <div class="col-12 col-md-6">
                    <label class="form-label">Room Type Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control vd-input @error('name') is-invalid @enderror"
                        list="roomTypeList"
                        placeholder="Enter or select a room type"
                        value="{{ old('name') }}"
                        required
                    >

                    <datalist id="roomTypeList">
                        @foreach(($types ?? collect()) as $type)
                            <option value="{{ $type->name }}"></option>
                        @endforeach
                    </datalist>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small class="vd-small-muted d-block mt-1">
                        Tip: You can type a new name or select an existing suggestion.
                    </small>
                </div>

                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn vd-btn vd-btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add Room Type
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