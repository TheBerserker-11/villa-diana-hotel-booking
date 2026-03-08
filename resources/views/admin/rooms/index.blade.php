@extends('admin.layouts.app')

@section('title','Rooms')

@section('content')
@include('components.show-success')

<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
        <div class="flex-grow-1">
            <h2 class="mb-0">All Rooms</h2>
            <small class="text-muted">Manage room inventory and availability</small>
        </div>

        <div class="d-grid d-sm-flex gap-2">
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i> Add Room
            </a>
        </div>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.rooms.index') }}" class="mb-2">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control"
                   placeholder="Search room name, bed type, status..."
                   value="{{ request('search') }}">
            @if(request()->filled('search'))
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
        </div>
    </form>

    <div class="vd-small-muted mb-3">
        Total rooms: <strong>{{ $rooms->count() }}</strong>
    </div>

    {{-- ================= MOBILE CARDS ================= --}}
    <div class="d-md-none">
        @forelse($rooms as $room)
        <div class="vd-card mb-3">
            <div class="vd-card-body">

                <div class="d-flex align-items-start gap-3">
                    <img src="{{ asset('storage/rooms/'.$room->image) }}"
                         class="rounded shadow-sm"
                         style="width:84px;height:70px;object-fit:cover;">

                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $room->roomtype->name }}</div>
                        <div class="text-muted small">{{ $room->bed_type }}</div>
                        <div class="mt-2 fw-bold">₱{{ number_format($room->price,0) }}</div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <a class="btn btn-sm btn-warning flex-grow-1"
                       href="{{ route('admin.rooms.edit',$room->id) }}">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>

                    {{-- ✅ NEW DELETE BUTTON --}}
                    <button type="button"
                            class="btn btn-sm btn-danger flex-grow-1 open-delete-room"
                            data-id="{{ $room->id }}"
                            data-name="{{ $room->roomtype->name }}">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="text-center vd-empty py-4">No rooms created yet.</div>
        @endforelse
    </div>

    {{-- ================= DESKTOP TABLE ================= --}}
    <div class="vd-card d-none d-md-block">
        <div class="vd-card-body p-0">
            <div class="table-responsive">
                <table class="table vd-table-bs mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th>Room Name</th>
                            <th>Total Rooms</th>
                            <th>Beds</th>
                            <th>Bed Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th style="width:150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                        <tr>
                            <td class="fw-semibold">{{ $room->roomtype->name }}</td>
                            <td>{{ $room->total_room }}</td>
                            <td>{{ $room->no_beds }}</td>
                            <td>{{ $room->bed_type }}</td>
                            <td class="fw-bold">₱{{ number_format($room->price,0) }}</td>
                            <td>
                                <span class="badge {{ $room->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $room->status ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-warning"
                                       href="{{ route('admin.rooms.edit',$room->id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- ✅ NEW DELETE BUTTON --}}
                                    <button type="button"
                                            class="btn btn-sm btn-danger open-delete-room"
                                            data-id="{{ $room->id }}"
                                            data-name="{{ $room->roomtype->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No rooms found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================
   🔥 SINGLE REUSABLE DELETE ROOM MODAL
===================================================== --}}
<div class="modal fade" id="deleteRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Room</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete
                "<strong id="deleteRoomName"></strong>"?
            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                <form method="POST" id="deleteRoomForm">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================
   🔥 MODAL SCRIPT
===================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('deleteRoomModal'));
    const form  = document.getElementById('deleteRoomForm');
    const name  = document.getElementById('deleteRoomName');

    document.querySelectorAll('.open-delete-room').forEach(btn => {
        btn.addEventListener('click', function () {
            name.textContent = this.dataset.name;
            form.action = `/admin/rooms/${this.dataset.id}`;
            modal.show();
        });
    });
});
</script>

@endsection