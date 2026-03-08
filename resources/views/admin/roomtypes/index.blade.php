@extends('admin.layouts.app')

@section('title','Room Types')

@section('content')
@include('components.show-success')

<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="min-w-0">
            <h2 class="mb-0">All Room Types</h2>
            <small class="text-muted">Manage room classifications</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>

            <a href="{{ route('admin.roomtypes.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i> Add Room Type
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="vd-card">
        <div class="vd-card-body p-0">
            <div class="table-responsive">
                <table class="table vd-table-bs vd-striped align-middle mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th style="min-width:220px;">Name</th>
                            <th style="width:160px;" class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($types as $type)
                            <tr>
                                <td class="fw-semibold">{{ $type->name }}</td>

                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-sm btn-warning"
                                           href="{{ route('admin.roomtypes.edit', $type->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- ✅ NEW DELETE BUTTON --}}
                                        <button type="button"
                                                class="btn btn-sm btn-danger open-delete-modal"
                                                data-id="{{ $type->id }}"
                                                data-name="{{ $type->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">
                                    You haven't created any room types yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
   ✅ SINGLE REUSABLE DELETE MODAL (NO MORE FLICKER)
========================================================= --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete
                "<strong id="deleteRoomTypeName"></strong>"?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- =========================================================
   ✅ SCRIPT TO CONTROL MODAL
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm  = document.getElementById('deleteForm');
    const deleteName  = document.getElementById('deleteRoomTypeName');

    document.querySelectorAll('.open-delete-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const name = this.dataset.name;

            deleteName.textContent = name;
            deleteForm.action = `/admin/roomtypes/${id}`;

            deleteModal.show();
        });
    });
});
</script>

@endsection