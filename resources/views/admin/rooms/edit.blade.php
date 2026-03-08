@extends('admin.layouts.app')

@section('title','Update Room')

@section('content')
<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h2 class="mb-0">Update Room</h2>
            <small class="text-muted">Edit room details and pricing</small>
        </div>

        <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="vd-card">
        <div class="vd-card-body">

            <form class="row g-3" method="POST"
                  action="{{ route('admin.rooms.update', ['room' => $room->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Room Type --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Room Type</label>
                    <select name="room_type_id" class="form-select vd-select @error('room_type_id') is-invalid @enderror">
                        <option value="">Choose...</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}"
                                @selected(old('room_type_id', $room->room_type_id) == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Total Rooms --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Total Rooms</label>
                    <input type="number" name="total_room"
                           value="{{ old('total_room', $room->total_room) }}"
                           class="form-control vd-input @error('total_room') is-invalid @enderror">
                    @error('total_room')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Beds --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">No. of Beds</label>
                    <input type="number" name="no_beds"
                           value="{{ old('no_beds', $room->no_beds) }}"
                           class="form-control vd-input @error('no_beds') is-invalid @enderror">
                    @error('no_beds')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Bed Type --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Bed Type</label>
                    <input type="text" name="bed_type"
                           value="{{ old('bed_type', $room->bed_type ?? '') }}"
                           class="form-control vd-input @error('bed_type') is-invalid @enderror">
                    @error('bed_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Price (Base Rate / Night)</label>
                    <div class="input-group">
                        <span class="input-group-text">₱</span>
                        <input type="text" id="priceInput" name="price"
                               value="{{ number_format(old('price', $room->price), 0) }}"
                               class="form-control vd-input @error('price') is-invalid @enderror">
                    </div>
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Included Pax --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Included Pax <span class="text-muted">(included in base price)</span></label>
                    <input type="number"
                           name="included_pax"
                           value="{{ old('included_pax', $room->included_pax ?? 1) }}"
                           min="1"
                           max="22"
                           class="form-control vd-input @error('included_pax') is-invalid @enderror">
                    @error('included_pax')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Example: If base price includes 2 guests, set this to 2.</small>
                </div>

                {{-- Max Capacity --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Max Capacity <span class="text-muted">(bucket)</span></label>
                    @php
                        $caps = [2, 3, 6, 8, 16, 20, 22];
                        $selectedCap = (int) old('max_capacity', $room->max_capacity ?? 2);
                    @endphp
                    <select name="max_capacity" class="form-select vd-select @error('max_capacity') is-invalid @enderror">
                        @foreach($caps as $cap)
                            <option value="{{ $cap }}" @selected($selectedCap === $cap)>
                                {{ $cap }} pax
                            </option>
                        @endforeach
                    </select>
                    @error('max_capacity')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Used for recommendations/filtering when guests choose a number.</small>
                </div>

                {{-- Description --}}
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control vd-input @error('desc') is-invalid @enderror"
                              name="desc" rows="4">{{ old('desc', $room->desc) }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Current Image --}}
                @if($room->image)
                    <div class="col-12">
                        <label class="form-label d-block">Current Image</label>
                        <img src="{{ asset('storage/rooms/' . $room->image) }}"
                             class="rounded shadow-sm"
                             style="width:150px; height:110px; object-fit:cover; border:1px solid var(--vd-border);">
                    </div>
                @endif

                {{-- New Image --}}
                <div class="col-12">
                    <label class="form-label">New Image</label>
                    <input type="file" name="image" class="form-control vd-input @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kuula --}}
                <div class="col-12">
                    <label class="form-label">Kuula 360° Virtual Tour Link</label>
                    <input type="url"
                           name="kuula_link"
                           value="{{ old('kuula_link', $room->kuula_link) }}"
                           placeholder="https://kuula.co/share/xxxxx"
                           class="form-control vd-input @error('kuula_link') is-invalid @enderror">
                    @error('kuula_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status"
                               @checked(old('status', $room->status))>
                        <label class="form-check-label">Active / Disabled</label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Update Room
                    </button>

                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('priceInput');
    if (!input) return;

    input.addEventListener('input', function () {
        let value = this.value.replace(/,/g, '').replace(/[^\d]/g, '');
        this.value = value ? Number(value).toLocaleString('en-US') : '';
    });

    input.form.addEventListener('submit', function () {
        input.value = input.value.replace(/,/g, '');
    });
});
</script>
@endsection